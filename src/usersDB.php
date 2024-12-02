<?php

require_once 'connection.php';
require_once 'colorUserDB.php';

class usersDB
{
    private $connection;

    public function __construct()
    {

        $this->connection = new Connection();
    }


    //Retorna todos os usuarios
    public function all()
    {
        $statement = $this->connection->getConnection()->prepare(
            "SELECT 
                users.id AS userId,
                users.name AS userName,
                users.email AS userEmail,
                colors.id AS colorId,
                colors.name AS colorName,
                colors.colorHexa AS colorHexa
             FROM users
             LEFT JOIN user_colors ON users.id = user_colors.user_id
             LEFT JOIN colors ON user_colors.color_id = colors.id"
        );
        $statement->execute();
        $users = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $userId = $row['userId'];

        // Cria um novo stdClass para o usuário, se necessário
        if (!isset($users[$userId])) {
            $user = new stdClass();
            $user->id = $row['userId'];
            $user->name = $row['userName'];
            $user->email = $row['userEmail'];
            $user->colors = []; // Inicializa como array vazio
            $users[$userId] = $user;
        }

        // Adiciona a cor ao usuário, se houver uma cor associada
        if (!is_null($row['colorId'])) {
            $color = new stdClass();
            $color->id = $row['colorId'];
            $color->name = $row['colorName'];
            $color->colorHexa = $row['colorHexa'];

            $users[$userId]->colors[] = $color;
        }
    }

    // Retorna os objetos stdClass como array numérico
    return array_values($users);
    }

    //Retorna um usuário, pelo ID
    public function show($id)
    {
        $statement = $this->connection->getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $statement->execute([$id]);
        $statement->setFetchMode(PDO::FETCH_INTO, new stdClass);
        $user = $statement->fetch();
        if ($user) {
            $colorUser = new colorUserDB();
            $user->colors = $colorUser->allByUser($id);
        } else {
            $user = null;
        }
        return $user;
    }

    public function create($name, $email)
    {
        $statement = $this->connection->getConnection()->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        if ($statement->execute(['name' => $name, 'email' => $email])) {
            return $this->connection->getConnection()->lastInsertId();
        }
        return false;
    }

    public function update($name, $email, $id)
    {
        $statement = $this->connection->getConnection()->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        return $statement->execute(['name' => $name, 'email' => $email, 'id' => $id]);
    }

    public function delete($id)
    {
        $statement = $this->connection->getConnection()->prepare("DELETE FROM users WHERE id = :id");
        return $statement->execute(['id' => $id]);
    }
}
