<?php

namespace Core;

use mysqli;
use mysqli_result;
use Exception;

class Database
{
    private static ?Database $instance = null;
    private ?mysqli $connection = null;
    private array $config;

    private function __construct()
    {
        $this->config = require __DIR__ . '/../config/database.php';
    }

    /**
     * Create the mysqli connection when needed.
     */
    private function connect(): void
    {
        if ($this->connection !== null) {
            return;
        }

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $this->connection = new mysqli(
                $this->config['host'],
                $this->config['user'],
                $this->config['password'],
                $this->config['database'],
                $this->config['port']
            );

            $this->connection->set_charset($this->config['charset']);
        } catch (Exception $e) {
            throw new Exception("DB Connection failed: " . $e->getMessage(), 500, $e);
        }
    }

    /**
     * Singleton instance.
     */
    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get an active connection.
     */
    private function getConnection(): mysqli
    {
        $this->connect();
        return $this->connection;
    }

    /**
     * Run a query (prepared statements).
     */
    public function query(string $sql, array $params = []): mysqli_result|bool
    {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        if (!empty($params)) {
            $types = $this->getParamTypes($params);
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        if (str_starts_with(strtoupper($sql), "SELECT")) {
            return $stmt->get_result();
        }

        return true;
    }

    /**
     * Close connection optional only.
     */
    public function close(): void
    {
        if ($this->connection) {
            $this->connection->close();
            $this->connection = null;
        }
    }

    /**
     * Fetch one row.
     */
    public function fetchOne(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params);

        if ($result instanceof mysqli_result) {
            $row = $result->fetch_assoc();
            return $row ?: null;
        }

        return null;
    }


    /**
     * Fetch all rows.
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $result = $this->query($sql, $params);
        return $result instanceof mysqli_result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Fetch a single column (like COUNT(*) or id).
     */
    public function fetchColumn(string $sql, array $params = []): mixed
    {
        $row = $this->fetchOne($sql, $params);
        return $row ? reset($row) : null;
    }

    /**
     * Get affected rows from last query.
     */
    public function getAffectedRows(): int
    {
        return $this->getConnection()->affected_rows;
    }

    /**
     * Transaction handling.
     */
    public function beginTransaction(): void
    {
        $this->getConnection()->begin_transaction();
    }

    public function commit(): void
    {
        $this->getConnection()->commit();
    }

    public function rollback(): void
    {
        $this->getConnection()->rollback();
    }

    /**
     * Escape string manually (rarely needed if using prepared statements).
     */
    public function escape(string $value): string
    {
        return $this->getConnection()->real_escape_string($value);
    }

    /**
     * Detect parameter types for bind_param.
     */
    private function getParamTypes(array $params): string
    {
        $types = '';
        foreach ($params as $param) {
            $types .= match (true) {
                is_int($param)   => 'i',
                is_float($param) => 'd',
                is_null($param)  => 's',
                default          => 's',
            };
        }
        return $types;
    }

    /**
     * Prevent cloning and unserializing.
     */
    private function __clone() {}

    public function __wakeup(): void
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
