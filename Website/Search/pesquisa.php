<?php
require_once "verificar_sessao.php";
require_once "includes/dbh.inc.php";

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    header("Location: ../index.php");
    exit("Método inválido.");
}

$pesquisaUsuario = isset($_GET["pesquisaUsuario"]) ? trim($_GET["pesquisaUsuario"]) : '';
$pesquisaCNPJ = isset($_GET["pesquisaCNPJ"]) ? trim($_GET["pesquisaCNPJ"]) : '';
$pesquisaCEP = isset($_GET["pesquisaCEP"]) ? trim($_GET["pesquisaCEP"]) : '';
$pesquisaEmail = isset($_GET["pesquisaEmail"]) ? trim($_GET["pesquisaEmail"]) : '';
$pesquisaTelefone = isset($_GET["pesquisaTelefone"]) ? trim($_GET["pesquisaTelefone"]) : '';
$pagination = isset($_GET["pagination"]) && is_numeric($_GET["pagination"]) ? (int) $_GET["pagination"] : 0;
$situacao = isset($_GET["situacao"]) ? trim($_GET["situacao"]) : '';

$pesquisaUsuario = '%' . htmlspecialchars($pesquisaUsuario) . '%';
$pesquisaCNPJ = '%' . htmlspecialchars($pesquisaCNPJ) . '%';
$pesquisaCEP = '%' . htmlspecialchars($pesquisaCEP) . '%';
$pesquisaEmail = '%' . htmlspecialchars($pesquisaEmail) . '%';
$pesquisaTelefone = '%' . htmlspecialchars($pesquisaTelefone) . '%';
$limite = 15;
$offset = $pagination * $limite;

try {
    $query = "SELECT * FROM usuarios WHERE
        usuario LIKE :pesquisaUsuario
         AND
        CNPJ_CPF LIKE :pesquisaCNPJ
         AND
        CEP LIKE :pesquisaCEP
         AND
        email LIKE :pesquisaEmail
         AND
        telefone LIKE :pesquisaTelefone ";

    if( $situacao != ""){
        $query .= "AND situacao = :situacao ";

    }

    $query .= "ORDER BY usuario ASC LIMIT :offset, :limite;";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":pesquisaUsuario", $pesquisaUsuario, PDO::PARAM_STR);
    $stmt->bindParam(":pesquisaCNPJ", $pesquisaCNPJ, PDO::PARAM_STR);
    $stmt->bindParam(":pesquisaCEP", $pesquisaCEP, PDO::PARAM_STR);
    $stmt->bindParam(":pesquisaEmail", $pesquisaEmail, PDO::PARAM_STR);
    $stmt->bindParam(":pesquisaTelefone", $pesquisaTelefone, PDO::PARAM_STR);

    if( $situacao != ""){
        $stmt->bindParam(":situacao", $situacao, PDO::PARAM_STR);
    }
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->bindParam(":limite", $limite, PDO::PARAM_INT);

    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    exit("Erro na pesquisa: " . $e->getTraceAsString());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Pesquisar informações</title>
</head>
<body>
    <section>
        <?php if (empty($resultados)) : ?>
            <div><p>Nenhum resultado encontrado.</p>
                <form class="buttonPagina" method="GET" action="pesquisa.php">
                    <input type="hidden" name="pagination" value="<?= $pagination - 1 ?>">
                    <input type="hidden" name="pesquisaUsuario" value="<?= $pesquisaUsuario ?>">
                    <input type="hidden" name="pesquisaCNPJ" value="<?= $pesquisaCNPJ ?>">
                    <input type="hidden" name="pesquisaCEP" value="<?= $pesquisaCEP?>">
                    <input type="hidden" name="pesquisaEmail" value="<?= $pesquisaEmail?>">
                    <input type="hidden" name="pesquisaTelefone" value="<?= $pesquisaTelefone ?>">
                    <button type="submit" class="seta"><<</button>
                </form>
            </div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CNPJ/CPF</th>
                        <th>CEP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["usuario"]) ?></td>
                            <td><?= htmlspecialchars($row["email"]) ?></td>
                            <td><?= htmlspecialchars($row["telefone"]) ?></td>
                            <td><?= htmlspecialchars($row["CNPJ_CPF"]) ?></td>
                            <td><?= htmlspecialchars($row["CEP"]) ?></td>
                            <td>
                                <form action="At&Del/indexAtualizar.php" method="post" style="display:inline;">
                                    <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($row['id']); ?>">
                                    <button type="submit" class="edit">Editar</button>
                                </form>
                                <form action="At&Del/indexDelet.php" method="post" style="display:inline;">
                                    <input type="hidden" name="idUsuario" value="<?= htmlspecialchars($row['id']); ?>">
                                    <button type="submit" class="delete">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div id="paginacao">
                <?php if ($pagination > 0): ?>
                    <form class="buttonPagina" method="GET" action="pesquisa.php">
                    <input type="hidden" name="pagination" value="<?= $pagination - 1 ?>">
                    <input type="hidden" name="pesquisaUsuario" value="<?= $pesquisaUsuario ?>">
                    <input type="hidden" name="pesquisaCNPJ" value="<?= $pesquisaCNPJ ?>">
                    <input type="hidden" name="pesquisaCEP" value="<?= $pesquisaCEP?>">
                    <input type="hidden" name="pesquisaEmail" value="<?= $pesquisaEmail?>">
                    <input type="hidden" name="pesquisaTelefone" value="<?= $pesquisaTelefone ?>">
                    <button type="submit" class="seta"><<</button>
                    </form>
                <?php endif; ?>
                
                <form class="buttonPagina" method="GET" action="pesquisa.php">
                    <input type="hidden" name="pagination" value="<?= $pagination + 1 ?>">
                    <input type="hidden" name="pesquisaUsuario" value="<?= $pesquisaUsuario ?>">
                    <input type="hidden" name="pesquisaCNPJ" value="<?= $pesquisaCNPJ ?>">
                    <input type="hidden" name="pesquisaCEP" value="<?= $pesquisaCEP?>">
                    <input type="hidden" name="pesquisaEmail" value="<?= $pesquisaEmail?>">
                    <input type="hidden" name="pesquisaTelefone" value="<?= $pesquisaTelefone ?>">
                    <button type="submit" class="seta">>></button>
                </form>
            </div>
        <?php endif; ?>
    </section>
</body>
<footer>
    <p>Visite nossa <a href="http://localhost/website/cadastro">área de cadastros</a> para criar um novo cadastro</p>
</footer>
</html>
