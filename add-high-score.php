<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Guitar Wars -Add Your High Score</title>

    <link rel="stylesheet" href="_css/style.css">

    <!-- Fonts online -->
    <link href="https://fonts.googleapis.com/css?family=Chilanka|Roboto" rel="stylesheet">

    <!-- Icons online -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <header class="bac-menu">
        <div class="container">
            <!-- Logo -->
            <img src="_img/logo.png" alt="Logo Guitar Wars" class="logo-gw">
            <!-- Large acreen menu -->
            <a href="#menu" class="btn-menu"></a>
            <nav class="menu">
                <ul class="ul-menu">
                    <li><a href="index.php">Recordes</a></li>
                    <li><a href="add-high-score.php">Adicionar</a></li>
                    <li><a href="admin.php">Admin</a></li>
                </ul>
            </nav>            
        </div>
        <div class="container-menu-reponsive">
            <img src="_img/logo.png" alt="Logo Guitar Wars" class="logo-gw-mobile">
            <!-- Menu mobile -->
            <nav class="menu-mobile">
                <ul class="ul-menu-mobile">
                    <li><a href="index.php">Recordes</a></li>
                    <li><a href="add-high-score.php">Adicionar</a></li>
                    <li><a href="admin.php">Admin</a></li>
                    <li><a href="#" class="btn-close">Fechar</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div id="content-form">
        <div id="container-form">
        <h2>Adicione seu recorde e faça seu nome atravessar gerações como Guitar God!</h2>
        <?php
            date_default_timezone_set('America/Sao_Paulo');
            $date = date('Y-m-d H:i');
            // compartiha os scripts
            require_once 'connectvars.php';
            require_once 'appvars.php';

            // Login facebook
            require_once __DIR__ . "/vendor/autoload.php";
            
            // Login social with facebook
            if(empty($_SESSION["userLogin"])){
                echo "<p class='erro erro-yellow'>Faça login com o facebook para adicionar seu recorde.</p>";

                /**
                 * AUTH FACEBOOK
                 */
                $facebook = new \League\OAuth2\Client\Provider\Facebook([
                    'clientId'          => FACEBOOK["app_id"],
                    'clientSecret'      => FACEBOOK["app_secret"],
                    'redirectUri'       => FACEBOOK["app_redirect"],
                    'graphApiVersion'   => FACEBOOK["app_version"]
                ]);

                $authUrl = $facebook->getAuthorizationUrl([
                    "scope" => ["email"]
                ]);

                $error = filter_input(INPUT_GET, "error", FILTER_SANITIZE_STRIPPED);
                if($error){
                    echo "<p class='erro erro-yellow'>Você precisa autorizar para adicionar seu recorde!</p>";
                }

                $code = filter_input(INPUT_GET, "code", FILTER_SANITIZE_STRIPPED);
                if($code){
                    $token = $facebook->getAccessToken("authorization_code", [
                        "code" => $code
                    ]);
                    
                    $_SESSION["userLogin"] = $facebook->getResourceOwner($token);
                    header("Refresh: 0");
                }

                // Link login
                echo "<a title='Facebook login' class='btn-small btn-blue btn-log' href='{$authUrl}'>Entrar com facebook</a>";
            }else{
                /**
                 * @var user \League\OAuth2\Client\Provider\FacebookUser
                 */
                $user = $_SESSION["userLogin"];
                echo "<img src='{$user->getPictureUrl()}' class='log-img' />";
                echo "<p class='log-name'>{$user->getName()}</p>";

                // Link logout
                echo "<a title='Sair' class='btn-small btn-log btn-red' href='?off=true'>Sair da conta</a>";
                $off = filter_input(INPUT_GET, "off", FILTER_VALIDATE_BOOLEAN);
                
                if($off){
                    unset($_SESSION["userLogin"]);
                    header("Refresh: 0");
                }
            }

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
                        // Move the files to folder
                        if (($screenshot_type == 'image/png') || ($screenshot_type == 'image/gif') || ($screenshot_type == 'image/jpeg') || ($screenshot_type == 'image/jpg') && ($screenshot_size <= GW_MAXFILESIZE)) {
                            // Now connect database
                            if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $target)) {
                                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                                $query = "INSERT INTO guitarwars VALUES (DEFAULT, '$date', '$name', '$score', '$music', '$screenshot_newname', 0)";
                                mysqli_query($dbc, $query);
                                echo '<p class="erro confirmacao">Parabéns! <br> Seu recorde foi adicionado com sucesso!</p>';

                                // Clear the values of the vars
                                $name = "";
                                $score = "";
                                $music = "";
                                $screenshot = "";

                                mysqli_close($dbc);
                            } else {
                                echo '<p class="erro erro-red">Erro ao enviar.</p>';
                            }
                        } else {
                            echo '<p class="erro erro-yellow">Formato invalido ou imagem muito grande! <br> Por favor, envie uma imagem em um dos seguintes formatos PNG, JPG, PJEPG ou GIF ou reduza sua imagem para 32KB. Para reduzir sua imagem acesse: <a href="https://www.easy-resize.com/pt/" target="_blank">easy-resize</a></p>';
                        }
                    } else {
                        echo '<p class="erro erro-yellow">A imagem precisa ser do tipo GIF, JPEG, ou PNG com menos de ' . (GW_MAXFILESIZE / 1024) . 'KB de tamanho. Para reduzir sua imagem acesse. <a href="https://www.easy-resize.com/pt/" target="_blank">easy-resize</a></p>';

                        // Try file graphic temporary
                        @unlink($_FILES['screenshot']['tmp_name']);
                    }
                } else {
                    echo '<p class="erro erro-red">Por favor, insira todas as informações para adicionar seu recorde.</p>';
                }
            }
        ?>

        <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="MAX_FILE_SIZE" value="320000">
            <input type="text" id="name" name="name" placeholder="Nome do guitar hero" value="<?php if (!empty($user->getName())) { echo $user->getName(); }?>"><label>
            <input type="number" id="score" name="score" maxlength="7" max="9999999" oninput="maxLengthCheck(this)" placeholder="EX: 1000000" value="<?php if (!empty($score)) { echo $score; }?>">
            <input type="text" id="add-music" name="music" placeholder="Musica - (Banda)" value="<?php if (!empty($music)) { echo $music; }?>">
            <label for="score"><strong>Cadê a prova?</strong> selecione uma foto</label><br>
            <div id="file">
                <input type="file" accept="image/jpeg, image/jpg, image/png, image/gif" id="screenshot" name="screenshot" enctype="multipart/form-data" placeholder="Selecionar arquivo">
                <span id="file-name">Selecione uma imagem</span>
            </div>
            <input type="submit" class="btn-medium btn-green" value="Adicionar recorde" name="submit">
        </form>
        </div>
    </div>

    <footer>
        <p id="copy" style="float: none;">
            &reg; Guitar Wars High Score- 2019
        </p>
        <p>Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a></p>

        <!-- Icons online and my social midia -->
        <div class="icons">
            <p>Siga-me nas redes sociais</p>
            <a href="https://www.facebook.com/fabricio.schiffer" target="_blank" class="fa fa-facebook"></a>
            <a href="https://www.instagram.com/fabricio_patrocinio_/?hl=pt-br" target="_blank" class="fa fa-instagram"></a>
            <a href="https://www.youtube.com/channel/UCZSB3-asIKR4ywZTnlvbZ3Q?view_as=subscriber" target="_blank" class="fa fa-youtube"></a>
            <a href="https://github.com/FabricioPatrocinio/guitar-wars" target="_blank" class="fa fa-github"></a>
        </div>
    </footer>

    <script src="js/menu.js"></script>
</body>
</html>