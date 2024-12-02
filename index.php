<?php

require_once 'css.php';
require_once './src/usersDB.php';

$db = new usersDB();

renderHeader();
echo "
    <div class='d-flex justify-content-between align-items-center mb-3'>
        <h2>Lista de Usuários</h2>
        <a href='/users/userForm.php' class='btn btn-success'>Criar Novo Usuário</a>
        <a href='/colors/list.php' class='btn btn-warning'>Listar cadastro de cores</a>
    </div>
    <table class='table table-striped table-bordered'>
        <thead class='thead-dark'>
            <tr>
                <th scope='col'>ID</th>
                <th scope='col'>Nome</th>
                <th scope='col'>Email</th>
                <th scope='col'>Cores</th>
                <th scope='col'>Ação</th>
            </tr>
        </thead>
        <tbody>
";

foreach ($db->all() as $user) {
    echo
        "<tr>
            <td>{$user->id}</td>
            <td>{$user->name}</td>
            <td>{$user->email}</td>
            <td>
            ";
    foreach ($user->colors as $color) {
        echo "<span class='badge' style='background-color: #{$color->colorHexa}; color: #fff; padding: 5px 10px;'> {$color->name}</span>";
    }
    echo "
            </td>
            <td>
                <a href='/users/userForm.php?id={$user->id}' class='btn btn-sm btn-primary'>Editar</a>
                <a href='/users/remove.php?id={$user->id}' class='btn btn-sm btn-danger'>Excluir</a>
            </td>
            ";

    echo "</td></tr>";
}

echo "
    </tbody>
    </table>
</div>
";
renderFooter();
