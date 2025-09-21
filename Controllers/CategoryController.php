<?php

namespace Controllers;

use Core\Response;
use Core\Validator;
use Services\CategoryService;

class CategoryController
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function createCategory()
    {
        Validator::require(["name", "color"], $_POST);

        $name = strtolower(trim($_POST['name']));
        $color = trim($_POST['color']);

        $categoryId = $this->categoryService->createCategory($name, $color);

        if (!$categoryId) {
            Response::error("Category Adding Failed", [$categoryId]);
        }

        Response::success("Category created successfully", [
            'id' => $categoryId
        ]);
    }
}
