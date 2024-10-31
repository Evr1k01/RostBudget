<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Services\Interfaces\ICategory;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller {
    private ICategory $categoryService;

    public function __construct(ICategory $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResource {
        return CategoryResource::collection($this->categoryService->getCategories());
    }
}
