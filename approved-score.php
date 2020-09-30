<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Approved Score - Guitar Wars</title>

    <link rel="stylesheet" href="_css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Chilanka|Roboto" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
</head>
<body>
    <img src="_img/logo.png" alt="" id="logo">
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
    echo '<p class="erro">Desculpe, nenhuma pontuação foi especificada para ser aprovada.</p>';
}

if (isset($_POST['submit'])) {
    if ($_POST['confirm'] == 'Yes') {
        $name = $_POST['name'];
        $score = $_POST['score'];
        $id = $_POST['id'];

        //Conect no banco de dados
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        //Aprova a pontuação do banco
        $query = "UPDATE guitarwars SET approved = 1 WHERE id = '$id'";

        mysqli_query($dbc, $query);
        mysqli_close($dbc);

        echo '<p class="confirmacao">A pontuação de ' . $score . ' para ' . $name . ' foi aprovada com sucesso!</p>';
    } else {
        echo '<p class="erro">Desculpe, houve alguma problema para aprovar a pontuação.</p>';
    }
} elseif (isset($id) && isset($name) && isset($date) && isset($score) && isset($screenshot)) {
    echo '<span class="font-m font-m-app">Aprovar pontuação</span><br>';
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
    echo '<form method="post" action="approved-score.php" id="form-remove">';
    echo '<label class="container">Estou ciente, adicionar!';
    echo '<input type="checkbox" name="confirm" value="Yes" />';
    echo '<span class="checkmark"></span>';
    echo '</label>';

    echo '<input type="submit" value="Aprovar" name="submit" class="approved-submit submit" />';

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