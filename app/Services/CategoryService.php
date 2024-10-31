<?php

namespace App\Services;

use App\Models\Category;
use App\Services\Interfaces\ICategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CategoryService implements ICategory {

    public function getCategories(): Collection {
        return Category::all();
    }
}
