<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

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
     * Store the user's birthday.
     *
     * @param Request $request
     */
    public function store(Request $request) {
        $request->validate([
           'dob' => 'required|date|date_format:Y-m-d|before_or_equal:'.$this->now->format('Y-m-d')
        ]);

        $lastBirthday = $this->getLastBirthday(new Carbon($request->input('dob')));

        dd($lastBirthday);
    }

    /**
     * Get last birthday.
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
}
