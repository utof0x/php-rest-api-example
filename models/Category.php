<?php

class Category
{
    private $conn;
    private string $table = 'categories';

    public int $id;
    public string $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get_categories()
    {
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
        $statement = $this->conn->prepare($sql);
        $statement->execute();
        return $statement;
    }
}