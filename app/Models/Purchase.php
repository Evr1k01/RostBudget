<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model {
    use HasUuids, SoftDeletes;

    protected $table = 'purchases';
    protected $fillable = [
        'id',
        'user_id',
        'description',
        'expense',
        'date',
        'category_id'
    ];

    public $timestamps = false;
}
