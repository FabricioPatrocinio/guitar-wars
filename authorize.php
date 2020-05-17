<?php
// Name Usename / Password
$username = 'root';
$password = 'admin';

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || ($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password) ) {
    // Name User/Password so send header for authenticate
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Guitar Wars"');
    exit('<h2>Guitar Wars</h2> Desculpe, você precisa digitar uma senha válida par acessar esta página..');
}

?>