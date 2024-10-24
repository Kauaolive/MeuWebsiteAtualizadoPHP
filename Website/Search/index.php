<?php
require_once "verificar_sessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pesquisar informações</title>
</head>

<body>
    <header>
        <form class="pesquisa" action="pesquisa.php" target="pesquisaResultado" method="get">

            <input type="text" id="pesquisaUsuario" name="pesquisaUsuario" placeholder="Nome do usuário...">
           
            <input type="text" id="pesquisaEmail" name="pesquisaEmail" placeholder="Email...">
           
            <input type="text" id="pesquisaTelefone" name="pesquisaTelefone" placeholder="Telefone...">
           
            <input type="text" id="pesquisaCNPJ" name="pesquisaCNPJ" placeholder="CNPJ/CPF...">
           
            <input type="text" id="pesquisaCEP" name="pesquisaCEP" placeholder="CEP...">
           
            <select name="situacao" id="situacao">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
                <option value="">Ambos</option>
            </select>
           
            <input type="hidden" id="pagination" name="pagination" value="0">
            <button type="Submit" id="botaoPesquisa"></button>
        </form>
    </header>

    <iframe id="pesquisaResultados" name="pesquisaResultado" src="pesquisa.php"></iframe>
</body>

</html>
