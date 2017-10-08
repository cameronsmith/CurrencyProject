<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rate extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'fetched'
    ];

    protected $fillable = ['fetched', 'rate', 'occurrences'];

    /**
     * Return date in correct format.
     *
     * @param $value
     * @return string
     */
    public function getFetchedAttribute($value)
    {
        return (new Carbon($value))->format('jS F Y');
    }

}
