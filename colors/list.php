<?php

require_once '../css.php';
require_once '../src/colorDB.php';

$db = new colorDB();

renderHeader();
echo "
    <div class='d-flex justify-content-between align-items-center mb-3'>
        <h2>Lista de Usuários</h2>
        <a href='/colors/colorForm.php' class='btn btn-success'>Criar nova cor</a>
        <a href='/index.php' class='btn btn-danger'>Voltar para tela inicial</a>
    </div>
    <table class='table table-striped table-bordered'>
        <thead class='thead-dark'>
            <tr>
                <th scope='col'>ID</th>
                <th scope='col'>Nome da cor</th>
                <th scope='col'>Exemplo da cor</th>
                <th scope='col'>Ação</th>
            </tr>
        </thead>
        <tbody>
";

foreach ($db->all() as $color) {
    echo sprintf(
        "
            <tr>
                <td>%s</td>
                <td>%s</td>
                <td>
                    <span class='badge' style='background-color: #%s; color: #%s ; padding: 5px 10px;'>____________</span>
                </td>
                <td>
                    <a href='/colors/colorForm.php?id=%s' class='btn btn-sm btn-primary'>Editar</a>
                    <a href='/colors/remove.php?id=%s' class='btn btn-sm btn-danger'>Excluir</a>
                </td>
            </tr>
    ",
        $color->id,
        $color->name,
        $color->colorHexa,
        $color->colorHexa,
        $color->id,
        $color->id
    );
}

echo "
        </tbody>
    </table>
</div>
";
renderFooter();
