<?php
require_once 'connection.php';

class ColorDB
{
    private $connection;

    public function __construct()
    {

        $this->connection = new Connection();
    }


    //Retorna todos os usuarios
    public function all()
    {
        return $this->connection->query("SELECT * FROM colors");
    }

    //Retorna um usuário, pelo ID
    public function show($id)
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM colors WHERE id = ?");
        $statement->execute([$id]);
        $statement->setFetchMode(PDO::FETCH_INTO, new stdClass);
        return $statement->fetch();
    }

    public function create($name, $colorHexa)
    {
        $statement = $this->connection->getConnection()->prepare("INSERT INTO colors (name, colorHexa) VALUES (:name, :colorHexa)");
        if ($statement->execute(['name' => $name, 'colorHexa' => $colorHexa])) {
            return $this->connection->getConnection()->lastInsertId();
        }
        return false;
    }

    public function update($name, $colorHexa, $id)
    {
        $colorHexa = str_replace("#",'',$colorHexa);
        $statement = $this->connection->getConnection()->prepare("UPDATE colors SET name = :name, colorHexa = :colorHexa WHERE id = :id");
        return $statement->execute(['name' => $name, 'colorHexa' => $colorHexa, 'id' => $id]);
    }

    public function delete($id)
    {
        $statement = $this->connection->getConnection()->prepare("DELETE FROM colors WHERE id = :id");
        return $statement->execute(['id' => $id]);
    }
}
