<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class RatesController extends Controller
{
    /**
     * Store the user's birthday.
     *
     * @param Request $request
     */
    public function store(Request $request) {
        $todayDate = Carbon::now()->format('Y-m-d');
        $request->validate([
           'birthday_date' => 'required|date|date_format:Y-m-d|before_or_equal:'.$todayDate
        ]);

        dd($request->all());
    }
}
