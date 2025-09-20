<?php

namespace Models;

class Admin
{
    public int $id;
    public string $email;
    public string $password;

    public function __construct(array $data)
    {
        $this->id = (int) $data['id'];
        $this->email = $data['email'];
        $this->password = $data['password'];
    }
}
