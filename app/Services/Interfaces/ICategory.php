<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ICategory {
    public function getCategories(): Collection;
}
