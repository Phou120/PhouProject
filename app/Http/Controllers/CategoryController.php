<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function addCategory(CategoryRequest $request)
    {
        return $this->categoryService->addCategory($request);
    }

    public function editCategory(CategoryRequest $request)
    {
        return $this->categoryService->editCategory($request);
    }

    public function deleteCategory(CategoryRequest $request)
    {
        return $this->categoryService->deleteCategory($request);
    }

    public function listCategories()
    {
        return $this->categoryService->listCategories();
    }
}
