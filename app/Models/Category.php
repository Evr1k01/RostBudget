<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    use HasUuids;

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'category_name'
    ];

    public $timestamps = false;
}
