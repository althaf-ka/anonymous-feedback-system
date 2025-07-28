<?php
require_once '../../models/User.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$user = User::findByUsername($username);

if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    header("Location: /views/" . $user['role'] . "/dashboard.php");
    exit;
} else {
    echo "Invalid credentials.";
}
