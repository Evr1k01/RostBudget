<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthReport extends Model {

    use HasUuids, SoftDeletes;

    protected $table = 'month_reports';
    protected $fillable = [
        'id',
        'sum',
        'month',
        'year',
        'top_category',
        'user_id'
    ];

    protected $casts = [
        'sum' => 'array'
    ];
}
