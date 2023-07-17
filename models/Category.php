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

    public function get_single_category(): void
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = :id ORDER BY created_at DESC';
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':id', $this->id);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
    }

    public function create(): bool
    {
        $sql = "INSERT INTO " . $this->table . " (name) VALUES (:name)";
        $statement = $this->conn->prepare($sql);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $statement->bindValue(':name', $this->name);

        if($statement->execute()) {
            return true;
        }

        printf("Error: %s.\n", $statement->error);

        return false;
    }

    public function update(): bool
    {
        $sql = "UPDATE " . $this->table . " SET name = :name WHERE id = :id";
        $statement = $this->conn->prepare($sql);

        $statement->bindValue(':id', $this->id);
        $statement->bindValue(':name', $this->name);

        if($statement->execute()) {
            return true;
        }

        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $statement = $this->conn->prepare($sql);

        $statement->bindValue(':id', $this->id);

        if($statement->execute()) {
            return true;
        }

        printf("Error: %s.\n", $statement->error);

        return false;
    }
}