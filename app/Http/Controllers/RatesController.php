<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Log;
use App\Contracts\RatesService;
use App\Rate;

class RatesController extends Controller
{
    protected $now;

    /**
     * RatesController constructor.
     */
    public function __construct() {
        $this->now = Carbon::now();
    }

    /**
     * Show rates page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $rates = Rate::orderBy('fetched', 'desc')->get();
        return view('index', compact('rates'));
    }

    /**
     * Get the user's last birthday, save their rate, and return their response.
     *
     * @param Request $request
     * @param RatesService $ratesService
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, RatesService $ratesService) {
        $request->validate([
           'dob' => 'required|date|date_format:Y-m-d|before_or_equal:'.$this->now->format('Y-m-d')
        ]);

        $lastBirthday = $this->getLastBirthday(new Carbon($request->input('dob')));

        $existingRate = Rate::where('fetched', $lastBirthday)->first();
        if (!is_null($existingRate)) {
            $existingRate->increment('occurrences');
            return $this->getSuccessReturn($lastBirthday, $existingRate->rate);
        }

        try {
            $rate = $ratesService->getRatesByDate($lastBirthday);
        } catch (Exception $exception) {
            Log::critical('Rates service threw an exception and/or is unavailable.', [
                'exception_notice'   => $exception->getMessage(),
                'requested_date' => $lastBirthday->format('Y-m-d')
            ]);

            return back()->withErrors(['The rates service is currently unavailable.']);
        }

        Rate::create([
            'rate' => $rate,
            'fetched' => $lastBirthday
        ]);

        return $this->getSuccessReturn($lastBirthday, $rate);
    }

    /**
     * Get last birthday from a date of birth.
     *
     * @param $dateOfBirth
     * @return Carbon
     */
    protected function getLastBirthday(Carbon $dateOfBirth) {
        $birthdayThisYear = Carbon::create($this->now->year, $dateOfBirth->month, $dateOfBirth->day)->startOfDay();

        if ($birthdayThisYear->isFuture()) {
            return $birthdayThisYear->subYear();
        }

        return $birthdayThisYear;
    }

    /**
     * Get successful return response.
     *
     * @param Carbon $date
     * @param $rate
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function getSuccessReturn(Carbon $date, $rate) {
        $date = $date->format('jS F Y');
        return back()->with('success_message', 'On '. $date. ' the rate was ' . $rate);
    }
}
