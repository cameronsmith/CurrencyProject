<?php namespace App\Contracts;

use Carbon\Carbon;

interface RatesService
{
    public function getCurrency();
    public function setCurrency($requestedCurrency);
    public function getRatesByDate(Carbon $date);
}