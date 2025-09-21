<?php

declare(strict_types=1);

namespace Models;

class Category
{
    public int $id;
    public string $name;
    public string $color;

    public function __construct(array $data)
    {
        $this->id    = $data['id'] ?? '';
        $this->name  = $data['name'] ?? '';
        $this->color = $data['color'] ?? '';
    }
}
