<?php

require_once '../css.php';
require_once '../src/ColorDB.php';

$db = new ColorDB();

function renderForm($color = null)
{

    $idField = $color ? "<input type='hidden' id='id' name='id' class='form-control' value='{$color->id}' required>" : '';
    $nameValue = $color ? $color->name : '';
    $colorHexa = $color ? $color->colorHexa : '';
    $buttonText = $color ? 'Salvar edição' : 'Salvar nova cor';
    echo "
    <form action='save.php' method='post' class='bg-light p-4 rounded shadow'>
        $idField
        <div class='form-group'>
            <label for='name'>Nome</label>
            <input type='text' id='name' name='name' class='form-control' value='{$nameValue}' required>
        </div>
        <div class='form-group'>
            <label for='colorHexa'>Cor</label>
            <input type='color' id='colorHexa' name='colorHexa' class='form-control' value=#{$colorHexa} required>
        </div>
        <button type='submit' class='btn btn-primary'>{$buttonText}</button>
        <a href='/colors/list.php' class='btn btn-secondary'>Cancelar</a>
    </form>";
}



renderHeader();
// Se tem o id na requição, então é para editar um usuário
if (isset($_GET['id'])) {
    $color = $db->show($_GET['id']);
    echo "<h2 class='mb-4'>Editar cor</h2>";
    renderForm($color);
} else {
    echo "<h2 class='mb-4'>Criar cor</h2>";
    renderForm();
}
renderFooter();
