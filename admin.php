<?php
require_once 'authorize.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin - Guitar Wars</title>
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

    <div class="container-float">
        <div class="container-bac">
        <div id="brinks">
            Ou você está aqui por ser ADMIN, ou eu fui Hackeado.
        </div>

        <h1 class="display-1">Pagina admin, Aprove ou remova.</h1>
        <p class="meng-cell text-center">Deslize para direita para aprovar ou remover.</p>

        <?php
            require_once 'appvars.php';
            require_once 'connectvars.php';

            //conecta-se ao banco de dados
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Erro ao conectar ao banco de dados.');

            //obtém os dados das pontuações a partir do MySQL
            $query = "SELECT * FROM guitarwars ORDER BY score DESC, date ASC";
            $data = mysqli_query($dbc, $query);

            //faz um loop através do array contendo os dados das pontuações, formatando-os como HTML
            echo '<div class="scroll">';
            echo '<table class="tab-admin">';
            while ($row = mysqli_fetch_array($data)) {
                //Exibe os dados das pontuações
                echo '<tr class="score-row-remove"><td><strong>' . $row['name'] . '</strong></td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>' . $row['score'] . '</td>';

                // show option for not approved
                if ($row['approved'] == 0) {
                    echo '<td class="approved"><a href="approved-score.php?id=' . $row['id'] .
                        '&amp;date=' . $row['date'] . '&amp;name=' . $row['name'] .
                        '&amp;score=' . $row['score'] . '&amp;screenshot='
                        . $row['screenshot'] . '">Aprovar</a></td>';
                }
                echo '<td class="remove"><a href="removescore.php?id=' . $row['id'] .
                    '&amp;date=' . $row['date'] . '&amp;name=' . $row['name'] .
                    '&amp;score=' . $row['score'] . '&amp;screenshot='
                    . $row['screenshot'] . '">Remover</a></td></tr>';
            }
            echo '</table>';
            echo '</div>';

            mysqli_close($dbc);
        ?>
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

    <script>
        // Little animation in the page admin
        setInterval(function() {
            document.querySelector('#brinks').style.top = '-100%'
        }, 4000);
    </script>
    <script src="js/menu.js"></script>
</body>
</html>