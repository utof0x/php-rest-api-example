<?php

class Database
{
    private string $host = 'localhost';
    private string $port = '8080';
    private string $dbname = 'myblog';
    private string $username = 'root';
    private string $password = '';
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;
//            mysql:host=127.0.0.1;port=3306;dbname=lightHp
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}