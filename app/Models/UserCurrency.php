<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserCurrency extends Model {
    use HasUuids;

    protected $table = 'user_currencies';

    protected $fillable = [
        'id',
        'user_id',
        'currency_id'
    ];

    public $timestamps = false;
}
