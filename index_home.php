<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta property="og:url" content="http://gamersworldrecordsandtournament.epizy.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Site dinamico criado usando PHP puro e MySQL">
    <meta property="og:description" content="Site criado apenas como portifólio.">
    <meta property="og:site_name" content="Guitar Wars">
    <meta property="og:image" content="http://gamersworldrecordsandtournament.epizy.com/_img/john5.jpeg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">

    <title>Guitar Wars - High Score</title>

    <link rel="stylesheet" href="_css/style.css">

    <!-- Fonts online-->
    <link href="https://fonts.googleapis.com/css?family=Chilanka|Roboto" rel="stylesheet">

    <!-- Icons online-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
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

    <img src="_img/logo.png" alt="" id="logo">

    <div class="content">
        <nav id="menu">
            <ul>
                <a href="index_home.php"><li>Lista Recordes</li></a>
                <a href="add-high-score.php"><li>Adicionar Recorde</li></a>
            </ul>
        </nav>
        <p class="icon-top">Top list de recordes Guitar Hero. Adicione o seu! <br> Link para Admin no radapé da pagina.</p>
        <?php
// compartiha os scripts
require_once 'connectvars.php';
require_once 'appvars.php';

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$query = "SELECT * FROM guitarwars WHERE approved = 1 ORDER BY score DESC, date ASC";
$data = mysqli_query($dbc, $query);

$i = 0;
echo '<div id="db-data">';
while ($row = mysqli_fetch_array($data)) {
    $i++;
    if ($i == 1) {
        echo '<h1 id="top-score">Melhor de todos #' . $row['score'] . '</h1>';
        echo '<span class="top-name">Top #1 ' . $row['name'] . '</span><br>';
    }
    echo '<div class="row-bg">';
    echo '<div class="score-inf">';
    echo '<span class="score">' . $row['score'] . '</span><br>';
    echo '<span class="name">' . $row['name'] . '</span><br>';
    echo '<span class="music">' . $row['music'] . '</span><br>';
    echo '<span class="date">Record de ' . $row['date'] . '</span><br></td>';
    echo '</div>';
    echo '<div class="score-inf">';
    if (is_file(GW_UPLOADPATH . $row['screenshot']) && filesize(GW_UPLOADPATH . $row['screenshot']) > 0) {
        // verifica se não estão vazios
        echo '<td class="score-inf"><img src="' . GW_UPLOADPATH . $row['screenshot'] . '" class="screenshot"></td></tr>';
    } else {
        echo '<td class="score-img"><img src="" alt="Unverified score :/" class="screenshot"></td></tr>';
    }
    echo '</div>';
    echo '</div>';
}
echo '</div>';

mysqli_close($dbc);
?>
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
            <a href="https://github.com/FabricioPatrocinio" target="_blank" class="fa fa-github"></a>
        </div>

        <p style="float: none;" ><i class="p-icon-eu"></i> Criado por Fabricio Patrocínio</p>
        <p>Experimente ser admin, aprove as publicações ou remova.</p>
        <a href="admin.php" class="link"><i class="p-icon-admin"></i>Link pag Admin</a>
    </footer>

    <!-- JQuery for menu only -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/jquery-menu.js"></script>
</body>
</html>