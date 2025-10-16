# Anonymous Feedback System

<p align="center">
  <img src="https://raw.githubusercontent.com/althaf-ka/anonymous-feedback-system/main/public/default-og-image.png?raw=true" alt="Anonymous Feedback System Logo" width="600">
</p>

A modern, secure, and performant anonymous feedback platform built from scratch in **pure, object-oriented PHP**. This project adheres to professional design patterns and PSR standards without relying on any external frameworks.

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php" alt="PHP Version">
  <img src="https://img.shields.io/badge/Dependencies-Zero-brightgreen?style=for-the-badge" alt="Zero Dependencies">
  <img src="https://img.shields.io/badge/Architecture-MVC%20%2F%20Service--Repository-blue?style=for-the-badge" alt="Architecture">
</p>

---

## 🏛️ Architectural Highlights

This project was built to demonstrate a high-quality web application using **pure PHP with zero dependencies**. It showcases a deep understanding of core web technologies and software architecture without the aid of a framework.

- **Zero Dependencies:** The entire application is self-contained. There is no `vendor` folder or `composer install` step.

- **Custom Core Components:** The project features a robust, custom-built infrastructure, including:

  - A **PSR-4 compliant autoloader** for clean, on-demand class loading.
  - A **Middleware handler** for processing requests before they reach the controller (e.g., authentication).
  - A flexible **Router** with parameter matching to direct traffic to the correct controllers.

- **Professional Architecture:** It follows a strict **MVC (Model-View-Controller)** pattern combined with a **Service-Repository** layer. This clean separation of concerns makes the code highly maintainable and testable:

  - **Controller:** Handles HTTP requests and responses only.
  - **Service:** Contains all business logic (e.g., "how to cast a vote").
  - **Repository:** Contains all database queries.

- **Secure by Default:**
  - All database queries use **prepared statements** to prevent SQL injection.
  - APIs are protected from direct access via `X-Requested-With` header checks.
  - User privacy is protected by **hashing** sensitive data like IP addresses.

---

## ✨ Features

### 👤 User-Facing

- **Submit Anonymous Feedback:** A clean, validated form to submit ideas, ratings, and optional contact info.
- **Public Suggestions Board:** A dynamic, infinitely scrolling page to browse all public feedback.
- **Filter & Sort:** Filter feedback by category/status and sort by "most recent" or "most votes."
- **Anonymous Voting System:** A secure, login-less voting system using a combination of cookie and hashed IP-address constraints to prevent duplicate votes.
- **Dynamic SEO & OG Tags:** Every page features unique, dynamic meta tags for professional SEO and social media sharing.

### 🛡️ Admin Panel

- **Secure Admin Login:** A separate, session-protected dashboard.
- **Dynamic Dashboard:** At-a-glance metrics for feedback, users, and top categories, plus a live recent activity feed.
- **Full Feedback Management:** An infinitely scrolling table to view, filter, and search all submissions.
- **Detailed Feedback View:** A complete view of any feedback item with tools to manage it.
- **Change Status & Visibility:** Instantly update feedback status or toggle public visibility via AJAX.
- **Official Responses:** Write, edit, and publish official responses to feedback.
- **Category Management:** A full CRUD interface for managing feedback categories with an AJAX-powered UI.
- **Bulk Delete:** Securely delete multiple feedback items at once with a custom confirmation modal.
- **Asynchronous CSV Export:** Download all feedback data as a CSV file with one click, without leaving the page.
- **Custom 404 Page:** A branded, user-friendly "Not Found" page.

---

## 🚀 Installation and Setup

1.  **Clone the Repository**

    ```bash
    git clone https://github.com/althaf-ka/anonymous-feedback-system.git
    cd anonymous-feedback-system
    ```

2.  **Database Setup**

    - Create a new MySQL database (e.g., `feedback_system`).

3.  **Environment Variables**

    - Create a new file named `.env` in the root of your project.
    - Copy and paste the following content into the file, replacing the dummy values with your own.

    ```dotenv
    # Database Configuration
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_NAME=feedback_system
    DB_USER=root
    DB_PASSWORD=root
    DB_CHARSET=utf8mb4

    # Default Admin User
    ADMIN_EMAIL=admin@example.com
    ADMIN_PASSWORD=admin
    ```

4.  **Run the Setup Script**

    - In your terminal, run the setup script to create all necessary tables and the default admin user.

    ```bash
    php Setup/install.php
    ```

5.  **Configure Web Server**
    - Set your web server's document root to the `/public` directory. This is a critical security measure that prevents direct access to your application logic files.

---

## 🔀 Deployment

This repository includes a dedicated branch specifically for deploying on limited shared hosting environments.

### Deploying to Limited Shared Hosting (like InfinityFree)

For hosts that do not support modern MySQL functions (like `UUID_TO_BIN`) or `ON DELETE CASCADE` (common with the MyISAM engine), use the `deploy/infinityfree` branch.

**Branch:** `deploy/infinityfree`

This branch contains two key modifications to ensure compatibility:

1.  **UUIDs as `VARCHAR(36)`:**
    All `BINARY(16)` columns and `UUID_TO_BIN()` / `BIN_TO_UUID()` functions have been replaced. The database now uses the standard `VARCHAR(36)` type, and IDs are generated by the database's default `UUID()` function. This avoids the "execute command denied" error on restricted hosts.

2.  **Manual Cascading Deletes (The MyISAM Fix):**
    The `MyISAM` storage engine **does not support foreign keys or `ON DELETE CASCADE`**. To prevent orphaned data, the `deleteByIds` method on this branch is enhanced to manually delete related items within a PHP transaction.

    ```php
    // In FeedbackRepository.php on the deploy/infinityfree branch
    public function deleteByIds(array $uuids): int
    {
        if (empty($uuids)) {
            return 0;
        }

        // A transaction ensures all deletes succeed, or none do.
        $this->db->beginTransaction();

        try {
            $placeholders = implode(',', array_fill(0, count($uuids), '?'));

            // 1. Delete from child tables first
            $this->db->query("DELETE FROM feedback_votes WHERE feedback_id IN ($placeholders)", $uuids);
            $this->db->query("DELETE FROM feedback_responses WHERE feedback_id IN ($placeholders)", $uuids);

            // 2. Finally, delete from the parent table
            $this->db->query("DELETE FROM feedbacks WHERE id IN ($placeholders)", $uuids);

            $affectedRows = $this->db->getAffectedRows();
            $this->db->commit();

            return $affectedRows;
        } catch (\Exception $e) {
            $this.db->rollBack();
            throw $e;
        }
    }
    ```
