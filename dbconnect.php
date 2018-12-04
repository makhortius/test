<?php
    header('Content-Type: text/html; charset=utf-8');

    $server = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $database = "testsite"; 
 
    // Подключение к базе данный через MySQLi
    $mysqli = new mysqli($server, $username, $password, $database);

    if (mysqli_connect_errno()) { 
        echo "<p><strong>Ошибка подключения к БД</strong>. Описание ошибки: ".mysqli_connect_error()."</p>";
        exit(); 
    }

    $mysqli->set_charset('utf8');


    $address_site = "http://testsite.local";
?>