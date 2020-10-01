<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Remove Score - Guitar Wars</title>

    <link rel="stylesheet" href="_css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Chilanka|Roboto" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
</head>
<body>
    <div class="bac-menu">
        <div class="container">
            <img src="_img/logo.png" alt="Logo Guitar Wars" class="logo-gw">
            <nav class="menu">
                <ul class="ul-menu">
                    <li><a href="index.php">Recordes</a></li>
                    <li><a href="add-high-score.php">Add Recorde</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <div id="content-form">
        <?php
require_once 'appvars.php';
require_once 'connectvars.php';

if (isset($_GET['id']) && isset($_GET['date']) && isset($_GET['name'])
    && isset($_GET['score']) && isset($_GET['screenshot'])) {

    //Pega os dados do GET
    $id = $_GET['id'];
    $date = $_GET['date'];
    $name = $_GET['name'];
    $score = $_GET['score'];
    $screenshot = $_GET['screenshot'];
} elseif (isset($_POST['id']) && isset($_POST['date']) && isset($_POST['name'])
    && isset($_POST['score']) && isset($_POST['screenshot'])) {

    //Pega os dados do POST
    $id = $_POST['id'];
    $date = $_POST['date'];
    $name = $_POST['name'];
    $score = $_POST['score'];
    $screenshot = $_POST['screenshot'];
} else {
    echo '<p class="erro">Desculpe, nenhuma pontuação foi especificada para ser removida.</p>';
}

if (isset($_POST['submit'])) {
    if ($_POST['confirm'] == 'Yes') {
        $id = $_POST['id'];

        //Exclui o arquivo grafico do servidor
        @unlink(GW_UPLOADPATH . $screenshot);

        //Conect no banco de dados
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        //exclui todos os dados da pontuação do banco
        $query = "DELETE FROM guitarwars WHERE id = ('$id') LIMIT 1 ";

        mysqli_query($dbc, $query);
        mysqli_close($dbc);

        echo '<p class="confirmacao">A pontuação foi removida com sucesso.</p>';
    } else {
        echo '<p class="erro">A pontuação não foi removida.</p>';
    }
} elseif (isset($id) && isset($name) && isset($date) && isset($score) && isset($screenshot)) {
    echo '<span class="font-m">Remover pontuação</span><br>';
    echo '<span class="remove-name">' . $name . '</span>';
    echo '<span class="remove-score">' . $score . '</span>';
    echo '<span class="remove-date">Data do record - ' . $date . '</span>';

    // Screenshot do record
    if (is_file(GW_UPLOADPATH . $screenshot) && filesize(GW_UPLOADPATH . $screenshot) > 0) {
        // verifica se não estão vazios
        echo '<img  style="margin: 20px 0 0 0;" src="' . GW_UPLOADPATH . $screenshot . '" class="screenshot">';
    } else {
        echo '<img src="" alt="Unverified score :/" class="screenshot">';
    }

    //formulário
    echo '<form method="post" action="removescore.php" id="form-remove">';
    echo '<label class="container">Estou ciente, deletar!';
    echo '<input type="checkbox" name="confirm" value="Yes" />';
    echo '<span class="checkmark"></span>';
    echo '</label>';

    echo '<input type="submit" value="Excluir" name="submit" class="remove-submit submit" />';

    echo '<input type="hidden" name="id" value="' . $id . '" />';
    echo '<input type="hidden" name="name" value="' . $name . '" />';
    echo '<input type="hidden" name="score" value="' . $score . '" />';
    echo '<input type="hidden" name="screenshot" value="' . $screenshot . '" />';
    echo '</form>';

}
echo '<a href="admin.php" class="link"> &lt;&lt; Voltar a página admin</a>';
?>
    </div>

    <footer>
        <p id="copy">&reg; Guitar Wars High Score - 2019</p>
    </footer>
</body>
</html>