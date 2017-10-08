<?php namespace App\Services\Rates;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Exceptions\RatesStatusCodeNot200Exception;
use App\Exceptions\NoRateFoundForCurrencyException;
use App\Contracts\RatesService;

class Fixer implements RatesService
{
    const FIXER_ENDPOINT = 'https://api.fixer.io/';
    const TIMEOUT = 5.0;
    const DEFAULT_CURRENCY = 'USD';

    protected $client;
    protected $selectedCurrency;

    /**
     * Fixer constructor.
     */
    public function __construct() {
        $this->client = new Client([
            'base_uri' => static::FIXER_ENDPOINT,
            'timeout'  => static::TIMEOUT,
        ]);

        $this->setCurrency(static::DEFAULT_CURRENCY);
    }

    /**
     * Set the requested currency.
     *
     * @param $requestedCurrency
     * @return $this
     */
    public function setCurrency($requestedCurrency) {
        $this->selectedCurrency = $requestedCurrency;
        return $this;
    }

    /**
     * Get the selected currency.
     *
     * @return string
     */
    public function getCurrency() {
        return $this->selectedCurrency;
    }

    /**
     * Get rates from a date.
     *
     * @param Carbon $date
     * @return mixed
     * @throws NoRateFoundForCurrencyException
     * @throws RatesStatusCodeNot200Exception
     */
    public function getRatesByDate(Carbon $date) {
        $response = $this->client->get($date->format('Y-m-d'));

        if ($response->getStatusCode() !== 200) {
            throw new RatesStatusCodeNot200Exception('An invalid status code: ' . $response->getStatusCode() . ' returned');
        }

        $content = json_decode($response->getBody());

        $rate = $content->rates->{$this->selectedCurrency};

        if (empty($rate)) {
            throw new NoRateFoundForCurrencyException('No rates found for currency: ' . $this->selectedCurrency);
        }

        return $rate;
    }
}