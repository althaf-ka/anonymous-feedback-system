<?php

namespace Services;

use models\Admin;
use Repositories\AdminRepository;
use Exception;

class AuthService
{
    public function __construct(private AdminRepository $adminRepo) {}

    public function login(string $email, string $password): Admin
    {
        $admin = $this->adminRepo->findByEmail($email);

        if (!$admin) {
            throw new Exception("Invalid email", 404);
        }

        $isVerified = password_verify($password, $admin->password);

        if (!$isVerified) {
            throw new Exception("Invalid password", 401);
        }

        return  $admin;
    }
}
