<?php

require_once '../src/usersDB.php';


// Verifica se os campos necessários estão na requisição
if (isset($_POST['name']) && isset($_POST['email'])) {
    $db = new usersDB();
    if (isset($_POST['id'])) { // Se tem id, então é para atualizar o usuario
        $id = $_POST['id'];
        print_r($id);
        $user = $db->update($_POST['name'], $_POST['email'], $id);
        
        header("Location: /");

    } else { // Se não tem, então é para criar um usuario
        $user = $db->create($_POST['name'], $_POST['email']);
        header("Location: /users/userForm.php?id=".$user);
    }
}
