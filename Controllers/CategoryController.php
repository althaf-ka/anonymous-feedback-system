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

    public function getCategories(): void
    {
        $limit = (int) ($_GET['limit'] ?? 20);
        $offset = (int) ($_GET['offset'] ?? 0);

        $data = $this->categoryService->getCategories($limit, $offset);
        Response::success("Categories fetched successfully", $data);
    }

    public function deleteCategory(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        Validator::require(["id"], $data);

        $id = $data['id'];

        $this->categoryService->deleteCategory($id);
        Response::success("Category deleted successfully");
    }
}
