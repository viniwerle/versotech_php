<?php

require_once 'connection.php';

class colorUserDB
{
    private $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function allByUser($user_id)
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT colors.id, colors.name, colors.colorHexa
             FROM colors
             INNER JOIN user_colors ON colors.id = user_colors.color_id
             WHERE user_colors.user_id = ?"
        );
        $statement->execute([$user_id]);
        $statement->setFetchMode(PDO::FETCH_INTO, new stdClass);
        return $statement;
    }

    private function existsRelationship($color_id, $user_id)
    {
        $statement = $this->connection->getConnection()->prepare("SELECT COUNT(*) FROM user_colors WHERE user_id = :user_id AND color_id = :color_id");
        $statement->execute(['user_id' => $user_id, 'color_id' => $color_id]);
        return $statement->fetchColumn() > 0;
    }

    public function create($color_id, $user_id)
    {
        if ($this->existsRelationship($color_id, $user_id)) {
            return false;
        }
        $statement = $this->connection->getConnection()->prepare("INSERT INTO user_colors (color_id, user_id) VALUES (:color_id,:user_id)");
        $statement->execute(['user_id' => $user_id, 'color_id' => $color_id]);

    }

    public function delete($color_id, $user_id)
    {
        $statement = $this->connection->getConnection()->prepare("DELETE FROM user_colors WHERE user_id = :user_id AND color_id = :color_id");
        $statement->execute(['user_id' => $user_id, 'color_id' => $color_id]);
    }
}
