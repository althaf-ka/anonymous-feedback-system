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

    $db->query("
        CREATE TABLE IF NOT EXISTS feedbacks (
            id BINARY(16) PRIMARY KEY DEFAULT (UUID_TO_BIN(UUID())),
            title VARCHAR(80) NOT NULL,
            message VARCHAR(600) NOT NULL,
            category_id BINARY(16) NOT NULL,
            is_public TINYINT(1) NOT NULL DEFAULT 0,
            allow_public TINYINT(1) NOT NULL DEFAULT 0,
            rating TINYINT UNSIGNED NOT NULL DEFAULT 0,
            contact_details VARCHAR(255) DEFAULT NULL,
            status ENUM('new', 'review', 'progress', 'resolved') NOT NULL DEFAULT 'new',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            resolved_at TIMESTAMP DEFAULT NULL,
            FOREIGN KEY (category_id) REFERENCES categories(id)
        )
    ");

    $db->query("
        CREATE TABLE IF NOT EXISTS feedback_votes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            feedback_id BINARY(16) NOT NULL,
            cookie_hash CHAR(64) NOT NULL,
            ip_address VARCHAR(45) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE(feedback_id, cookie_hash),
            UNIQUE(feedback_id, ip_address),
            FOREIGN KEY (feedback_id) REFERENCES feedbacks(id) ON DELETE CASCADE
        )
    ");

    $db->query("
        CREATE TABLE IF NOT EXISTS feedback_responses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            feedback_id BINARY(16) NOT NULL,
            response TEXT NOT NULL,
            last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY `uniq_feedback_id` (`feedback_id`),
            FOREIGN KEY (feedback_id) REFERENCES feedbacks(id) ON DELETE CASCADE
        )
    ");


    echo "🎉 Setup completed successfully.\n";

    $db->close();
} catch (Exception $e) {
    echo "❌ Setup failed: " . $e->getMessage() . "\n";
    exit(1);
}
