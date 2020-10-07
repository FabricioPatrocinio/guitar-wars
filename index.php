<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- tags for share social midia -->
    <meta property="og:url" content="http://gamersworldrecordsandtournament.epizy.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Site dinamico criado usando PHP puro e MySQL">
    <meta property="og:description" content="Site criado apenas como portifólio.">
    <meta property="og:site_name" content="Guitar Wars">
    <meta property="og:image" itemprop="image" content="http://gamersworldrecordsandtournament.epizy.com/_img/john5-share.jpeg">
    <meta property="og:image:type" content="image/jpeg">

    <title>Guitar Wars - High Score</title>

    <link rel="stylesheet" href="_css/style.css">

    <!-- Fonts online -->
    <link href="https://fonts.googleapis.com/css?family=Chilanka|Roboto" rel="stylesheet">

    <!-- Icons online -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <header class="bac-menu">
        <div class="container">
            <img src="_img/logo.png" alt="Logo Guitar Wars" class="logo-gw">
            <nav class="menu">
                <ul class="ul-menu">
                    <li><a href="index.php">Recordes</a></li>
                    <li><a href="add-high-score.php">Add Recorde</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <audio id="demo" controls style="display: none;">
        <source src="_music/buckethead_jordan.mp3" type="audio/mpeg">
        <source src="_music/buckethead_jordan.mp3" type="audio/ogg">
        Seu navegador não suporta áudio tag.
    </audio>

    <div id="music">
        <img src="_img/music-player.png" alt="" id="music-img">
        <button id="play" onclick="document.querySelector('#demo').play()"></button>
        <button id="pause" onclick="document.querySelector('#demo').pause()"></button>
    </div>

    <div class="container-float">
        <div class="container-bac">
        <h1>Top list de recordes Guitar Hero. <br> Adicione o seu também e se torne um stars guitar!</h1>
        <?php
        // share the scripts
        require_once 'connectvars.php';
        require_once 'appvars.php';

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $query = "SELECT Year(date) as ano, MONTH(date) as mes, DAY(date) as dia, guitarwars.* FROM guitarwars WHERE approved = 1 ORDER BY score DESC, date ASC";
        $data = mysqli_query($dbc, $query);

        // array names months
        $mes = array(1 => "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

        $i = 0;
        echo '<div id="db-data">';
        while ($row = mysqli_fetch_array($data)) {
            $i++;
            if ($i == 1) {
                echo '<h2 class="top-name">Top #1 ' . $row['name'] . ', <br> Melhor pontuação de todas #'. $row['score'] .'</h2><br>';
            }
            echo '<div class="flex-container"></div>';
            echo '<div class="row-bg">';
            echo '<div class="score-inf">';
            echo '<span class="score">' . $row['score'] . '</span><br>';
            echo '<span class="name">' . $row['name'] . '</span><br>';
            echo '<span class="music">' . $row['music'] . '</span><br>';
            echo '<span class="date">Do dia ' . $row['dia'] . ' de ' . $mes[$row['mes']] . ' de ' . $row['ano'] . '</span><br></td>';
            echo '</div>';
            echo '<div class="score-inf">';
            if (is_file(GW_UPLOADPATH . $row['screenshot']) && filesize(GW_UPLOADPATH . $row['screenshot']) > 0) {
                // check if they are null
                echo '<td class="score-inf"><img src="' . GW_UPLOADPATH . $row['screenshot'] . '" class="screenshot"></td></tr>';
            } else {
                echo '<td class="score-img"><img src="" alt="Unverified score :/" class="screenshot"></td></tr>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
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
</body>
</html>