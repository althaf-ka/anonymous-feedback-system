<?php

namespace Services;

use Repositories\CategoryRepository;
use Exception;

class CategoryService
{
    public function __construct(private CategoryRepository $categoryRepo) {}

    public function createCategory(string $name, string $color): string | null
    {
        try {
            $categoryId = $this->categoryRepo->insert($name, $color);

            if ($categoryId === null) {
                throw new Exception("Failed to create category.");
            }

            return $categoryId;
        } catch (\mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) { // duplicate entry
                if (str_contains($e->getMessage(), 'name')) {
                    throw new Exception("Category with this name already exists");
                }
                if (str_contains($e->getMessage(), 'color')) {
                    throw new Exception("A category with this color already exists");
                }
            }

            throw new Exception("Unable to create category at this time. Please try again later.");
        }
    }
}
