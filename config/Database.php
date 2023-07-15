<?php

class Database
{
    private string $host = 'localhost';
    private string $dbname = 'localhost';
    private string $username = 'root';
    private string $password = '';
    private null|PDO $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}