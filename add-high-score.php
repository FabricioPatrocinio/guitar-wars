<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Guitar Wars -Add Your High Score</title>

    <link rel="stylesheet" href="_css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Chilanka|Roboto" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
</head>
<body>
    <img src="_img/logo.png" alt="" id="logo">

    <div id="content-form">
        <nav id="menu">
            <ul>
                <a href="index.php"><li>Recordes</li></a>
                <a href="add-high-score.php"><li>Novo Recorde</li></a>
            </ul>
        </nav>
        <p class="apres">Logo mais você será um Guitar God.</p>
        <?php
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d H:i');
// compartiha os scripts
require_once 'connectvars.php';
require_once 'appvars.php';

if (isset($_POST['submit']) && isset($_FILES['screenshot']['name'])) {
    $name = $_POST['name'];
    $score = $_POST['score'];
    $music = $_POST['music'];
    $screenshot = $_FILES['screenshot']['name'];
    $screenshot_type = $_FILES['screenshot']['type'];
    $screenshot_size = $_FILES['screenshot']['size'];

    if (!empty($name) && !empty($score) && !empty($screenshot) && !empty($music)) {
        // move o arquivo para pasta alvo
        // time() --> gera numeros unicos, para evitar imagens com mesmo nome
        $screenshot_newname = time() . $screenshot;
        $target = GW_UPLOADPATH . $screenshot_newname;

        if ($_FILES['screenshot']['error'] == 0) {
            //move o arquivo para pasta alvo
            if (($screenshot_type == 'image/png') || ($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/jpg') && ($screenshot_size <= GW_MAXFILESIZE)) {
                //conecta-se ao banco de dados
                if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
                    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                    $query = "INSERT INTO guitarwars VALUES (DEFAULT, '$date', '$name', '$score', '$music', '$screenshot_newname', 0)";
                    mysqli_query($dbc, $query);
                    echo '<p class="confirmacao">Parabéns! <br> Seu recorde foi adicionado com sucesso!</p>';

                    $name = ""; // clear values
                    $score = "";
                    $music = "";
                    $screenshot = "";

                    mysqli_close($dbc);
                } else {
                    echo '<p class="erro">Erro ao enviar.</p>';
                }
            } else {
                echo '<p class="erro erro-yellow">Formato invalido ou imagem muito grande! <br> Por favor, envie uma imagem em um dos seguintes formatos PNG, JPG, PJEPG ou GIF ou reduza sua imagem para 32KB. Para reduzir sua imagem acesse: <a href="https://www.easy-resize.com/pt/" target="_blank">easy-resize</a></p>';
            }
        } else {
            echo '<p class="erro erro-yellow">O arquivo precisa ser um gráfico GIF, JPEG, ou PNG com menos de ' . (GW_MAXFILESIZE / 1024) . 'KB de tamanho. Para reduzir sua imagem acesse: <a href="https://www.easy-resize.com/pt/" target="_blank">easy-resize</a></p>';

            //try file graphic temporary
            @unlink($_FILES['screenshot']['tmp_name']);
        }
    } else {
        echo '<p class="erro">Por favor, insira todas as informações para adicionar seu recorde.</p>';
    }
}
?>

        <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="MAX_FILE_SIZE" value="320000">
            <!-- <label for="name">Nome do Guitar Hero </label><br> -->
            <input type="text" id="name" name="name" placeholder="Nome do guitar hero" value="<?php if (!empty($name)) { echo $name; }?>"><label>
            <!-- <label for="score">Pontuação </label><br> -->
            <input type="number" id="score" name="score" maxlength="7" max="9999999" oninput="maxLengthCheck(this)" placeholder="EX: 1000000" value="<?php if (!empty($score)) { echo $score; }?>">
            <br>
            <input type="text" id="add-music" name="music" placeholder="Musica - (Banda)" value="<?php if (!empty($music)) { echo $music; }?>">
            <br>
            <label for="score"><strong>Cadê a prova?</strong> selecione uma foto</label><br>
            <div id="file">
                <input type="file" accept="image/jpeg, image/jpg, image/png, image/gif" id="screenshot" name="screenshot" enctype="multipart/form-data" placeholder="Selecionar arquivo"> <br>
                <span id="file-name">Selecione a captura de tela</span>
            </div>
            <input type="submit" value="Adicionar recorde" name="submit" id="submit">
        </form>
    </div>

    <footer>
        <p id="copy" style="float: none;">
            &reg; Guitar Wars Hing Score- 2019
        </p>

        <!-- Icons online and my social midia -->
        <div class="icons">
            <a href="https://www.facebook.com/fabricio.schiffer" target="_blank" class="fa fa-facebook"></a>
            <a href="https://www.instagram.com/fabricio_patrocinio_/?hl=pt-br" target="_blank" class="fa fa-instagram"></a>
            <a href="https://www.youtube.com/channel/UCZSB3-asIKR4ywZTnlvbZ3Q?view_as=subscriber" target="_blank" class="fa fa-youtube"></a>
            <a href="https://github.com/FabricioPatrocinio/guitar-wars" target="_blank" class="fa fa-github"></a>
        </div>

        <p style="float: none;" ><i class="p-icon-eu"></i> Criado por Fabricio Patrocínio</p>
        <p>Experimente ser admin, aprove as publicações ou remova. <br> Usuário 'root', senha 'root'</p>
        <a href="admin.php" class="link"><i class="p-icon-admin"></i>Link pag Admin</a>
    </footer>

    <script>
        var $input    = document.querySelector('#screenshot'),
            $fileName = document.querySelector('#file-name');

        $input.addEventListener('change', function(){
            $fileName.innerHTML = this.value;
        });

        // Maxlegth = 7, input type number
        // https://jsfiddle.net/DRSDavidSoft/zb4ft1qq/2/
        function maxLengthCheck(object)
        {
            if (object.value.length > object.maxLength)
            object.value = object.value.slice(0, object.maxLength)
        }
    </script>
</body>
</html>