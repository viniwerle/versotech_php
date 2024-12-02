<?php

require_once '../src/usersDB.php';

$db = new usersDB();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = $db->delete($id);
}
header("Location: /");
