<?php

require_once '../css.php';
require_once '../src/usersDB.php';
require_once '../src/ColorDB.php';

$db = new usersDB();


function renderForm($user = null)
{
    $idField = $user ? "<input type='hidden' id='id' name='id' class='form-control' value='{$user->id}' required>" : '';
    $nameValue = $user ? $user->name : '';
    $emailValue = $user ? $user->email : '';
    $buttonText = $user ? 'Salvar edição' : 'Salvar novo usuário';
    echo "
    <form action='save.php' method='post' class='bg-light p-4 rounded shadow'>
        $idField
        <div class='form-group'>
            <label for='name'>Nome</label>
            <input type='text' id='name' name='name' class='form-control' value='$nameValue' required>
        </div>
        <div class='form-group'>
            <label for='email'>Email</label>
            <input type='email' id='email' name='email' class='form-control' value='$emailValue' required>
        </div>
        <button type='submit' class='btn btn-primary'>$buttonText</button>
        <a href='/' class='btn btn-secondary'>Cancelar</a>
    </form>";
}

function renderFormColor($user)
{
    $dbColor = new ColorDB();
    echo "<form action='saveColor.php' method='post' class='bg-light p-4 rounded shadow'>
    <div class='form-group'>
    <input type='hidden' id='user_id' name='user_id' class='form-control' value='{$user->id}' require>
    <select id='color_id' name='color_id' class='form-control'>
        <option value='' disabled selected>Selecione uma cor</option>";

    foreach ($dbColor->all() as $color) {
        echo "<option value='{$color->id}' style='background-color: #{$color->colorHexa}' >{$color->name}</option>";
    }
    echo "</select>
    </div>
    <button type='submit' class='btn btn-primary'>Salvar cor</button>
</form>";
}
function renderTableColors($user)
{
    echo "
    <table class='table table-striped table-bordered'>
        <thead class='thead-dark'>
            <tr>
                <th scope='col'>Nome</th>
                <th scope='col'>Cor</th>
                <th scope='col'>Ação</th>
            </tr>
        </thead>
        <tbody>";

    foreach ($user->colors as $color) {
        renderTableRow($color, $user->id);
    }

    echo "
        </tbody>
    </table>";
}

function renderTableRow($color, $userId)
{
    echo "
    <tr>
        <td>{$color->name}</td>
        <td>
            <span 
                class='badge' 
                style='background-color: #{$color->colorHexa}; color: #fff; padding: 5px 10px;'>
                #{$color->colorHexa}
            </span>
        </td>
        <td>
            <a 
                href='/users/removeColor.php?color_id={$color->id}&user_id={$userId}' 
                class='btn btn-sm btn-danger'>
                Excluir
            </a>
        </td>
    </tr>";
}


renderHeader();
// Se tem o id na requição, então é para editar um usuário
if (isset($_GET['id'])) {
    $user = $db->show($_GET['id']);
    echo "<h2 class='mb-4'>Editar Usuário</h2>";
    renderForm($user);
    renderFormColor($user);
    renderTableColors($user);
} else {
    echo "<h2 class='mb-4'>Criar Usuário</h2>";
    renderForm();
}
renderFooter();
