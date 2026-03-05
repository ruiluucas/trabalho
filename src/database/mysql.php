<?php

use PDO;
use PDOException;

class MySqlDatabase
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {

        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $db   = $_ENV['DB_NAME'] ?? 'meu_banco';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? 'root';
        $port = $_ENV['DB_PORT'] ?? '3306';
        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new Exception("Erro ao conectar com o banco de dados dinâmico.");
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function fetch($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function fetchAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}
