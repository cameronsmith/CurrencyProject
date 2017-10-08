<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'fetched'
    ];

    protected $fillable = ['fetched', 'rate', 'occurrences'];
}
