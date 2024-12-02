<?php

require_once '../src/colorUserDB.php';

// Verifica se os campos necessários estão na requisição
if (isset($_POST['color_id']) && isset($_POST['user_id'])) {
    $db = new colorUserDB();
    $colorUser = $db->create($_POST['color_id'], $_POST['user_id']);
   header("Location: /users/userForm.php?id=" . $_POST['user_id']);
}


