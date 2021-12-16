<?php
$host = 'localhost';
$user = 'root';
$password = '1234';
$db_name = 'manga_site_project';

$connect = new mysqli($host, $user, $password, $db_name)
or die("Ошибка подключения к базе данных.".mysqli_connect_error());

if(!mysqli_ping($connect)) {
    die("Ошибка соединения с базой данных");
}

function authorized($connect) {
    /*
     * TODO
     */
    $login = $_SESSION["login"];

    if (empty($login)) {
        return false;
    }

    $command = "select * from user where login='".$login."'";
    $query = mysqli_query($connect, $command) or die(mysqli_error($connect));

    if (!empty(mysqli_fetch_row($query))) {
        return true;
    }

    return false;
}
?>