<?php

require_once '../src/usersDB.php';

$db = new usersDB();

if (isset($_GET['color_id']) && isset($_GET['user_id'])) {
        $db = new colorUserDB();
        $colorUser = $db->delete($_GET['color_id'], $_GET['user_id']);
}

header("Location: /users/userForm.php?id=" . $_GET['user_id']);





