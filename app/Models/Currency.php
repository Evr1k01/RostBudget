<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model {
    use HasUuids;

    protected $table = 'currencies';

    protected $fillable = [
        'id',
        'currency_code'
    ];

    public $timestamps = false;
}
