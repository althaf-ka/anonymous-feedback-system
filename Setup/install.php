<?php

declare(strict_types=1);

namespace Setup;

use Core\Database;
use Core\Env;
use mysqli;
use Exception;

require_once __DIR__ . '/../Core/Env.php';
require_once __DIR__ . '/../Core/Database.php';

Env::load();

$host = Env::get('DB_HOST');
$port = Env::get('DB_PORT') ?: 3306;
$dbName = Env::get('DB_NAME');
$user = Env::get('DB_USER');
$pass = Env::get('DB_PASSWORD');

$adminEmail = Env::get('ADMIN_EMAIL');
$adminPassword = Env::get('ADMIN_PASSWORD');

try {
    $mysqli = new mysqli($host, $user, $pass, '', (int)$port);
    $mysqli->set_charset('utf8mb4');

    // Create database if it doesn't exist
    $mysqli->query("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $mysqli->close();

    // Now connect using Database singleton (with DB)
    $db = Database::getInstance();


    $db->query("
        CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )
    ");


    $exists = $db->fetchColumn(
        "SELECT COUNT(*) FROM admins WHERE email = ?",
        [$adminEmail]
    );

    if (!$exists) {
        $hash = password_hash($adminPassword, PASSWORD_BCRYPT);
        $db->query(
            "INSERT INTO admins (email, password) VALUES (?, ?)",
            [$adminEmail, $hash]
        );
        echo "✅ Admin user created: {$adminEmail}\n";
    } else {
        echo "ℹ️ Admin already exists: {$adminEmail}\n";
    }

    $db->query("
        CREATE TABLE IF NOT EXISTS categories (
            id BINARY(16) PRIMARY KEY DEFAULT (UUID_TO_BIN(UUID())),
            name VARCHAR(255) NOT NULL UNIQUE,
            color VARCHAR(20) NOT NULL UNIQUE
        )
    ");

    echo "🎉 Setup completed successfully.\n";

    $db->close();
} catch (Exception $e) {
    echo "❌ Setup failed: " . $e->getMessage() . "\n";
    exit(1);
}
