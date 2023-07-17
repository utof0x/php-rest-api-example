<?php

class Post {
    private $conn;
    private string $table = 'posts';

    public string $id;
    public int $category_id;
    public string $category_name = '';
    public string $title = '';
    public string $body = '';
    public string $author = '';
    public string $created_at = '';

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

    public function read_single()
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
            WHERE
                p.id = :id';

        $statement = $this->conn->prepare($sql_query);
        $statement->bindValue(':id', $this->id);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    public function create(): bool
    {
        $sql_query = 'INSERT INTO ' . $this->table . ' (title, body, author, category_id)
            VALUES (:title, :body, :author, :category_id)';

        $statement = $this->conn->prepare($sql_query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        $statement->bindValue(':title', $this->title);
        $statement->bindValue(':body', $this->body);
        $statement->bindValue(':author', $this->author);
        $statement->bindValue(':category_id', $this->category_id);

        if ($statement->execute()) {
            return true;
        }

        printf("Error: %s.\n", $statement->error);

        return false;
    }

    public function update(): bool
    {
        $sql_query = '
        UPDATE ' . $this->table . '
        SET (:title, :body, :author, :category_id)
        WHERE id = :id';

        $statement = $this->conn->prepare($sql_query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $statement->bindValue(':title', $this->title);
        $statement->bindValue(':body', $this->body);
        $statement->bindValue(':author', $this->author);
        $statement->bindValue(':category_id', $this->category_id);
        $statement->bindValue(':id', $this->id);

        if ($statement->execute()) {
            return true;
        }

        printf("Error: %s.\n", $statement->error);

        return false;
    }

    public function delete(): bool
    {
        $sql_query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $statement = $this->conn->prepare($sql_query);
        $this->id = number_format(htmlspecialchars(strip_tags($this->id)));

        $statement->bindValue(':id', $this->id);

        if ($statement->execute()) {
            return true;
        }

        printf("Error: %s.\n", $statement->error);

        return false;
    }
}