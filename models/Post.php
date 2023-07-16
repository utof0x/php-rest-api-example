<?php

class Post {
    private $conn;
    private string $table = 'posts';

    public string $id;
    public string $category_id;
    public string $category_name;
    public string $title;
    public string $body;
    public string $author;
    public string $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read(): PDOStatement|bool
    {
        $sql_query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
            ' . $this->table . ' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC';

        $statement = $this->conn->prepare($sql_query);
        $statement->execute();
        return $statement;
    }
}