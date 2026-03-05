<?php

use PDO;
use PDOException;

class MySqlConnector
{
    private static $instance = null;
    private $connection;

    private $host = 'db';
    private $db   = 'meu_banco';
    private $user = 'root';
    private $pass = 'root';
    private $port = '3306';

    private function __construct()
    {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            throw new Exception("Erro na conexão: " . $e->getMessage());
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
