<?php

namespace controllers;

class AdminController {
    public function login() {
        require __DIR__ . '/../views/admin/login.php';
    }

    public function dashboard() {
      require __DIR__ . "/../views/admin/dashboard.php";
    }
}
