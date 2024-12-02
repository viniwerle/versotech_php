<?php

require_once '../src/ColorDB.php';


// Verifica se os campos necessários estão na requisição
if (isset($_POST['name']) && isset($_POST['colorHexa'])) {
    $db = new ColorDB();
    if (isset($_POST['id'])) { // Se tem id, então é para atualizar o usuario
        $id = $_POST['id'];
        $color = $db->update($_POST['name'], $_POST['colorHexa'], $id);        
        header("Location: /colors/list.php");

    } else { // Se não tem, então é para criar um usuario
        $color = $db->create($_POST['name'], $_POST['colorHexa']);
        header("Location: /colors/colorForm.php?id=".$color);
    }
}
