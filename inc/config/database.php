<?php
$db ="account_php"; //saeedmir_blighted4851
$user ="root"; //saeedmir_ranked0463
$pass=""; //Gm7Jf1YR!wEI^Fr%OG^^!uXcMV@RfJid
try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=$db",
        $user,
        $pass,
        array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        )
    );
} catch (PDOException $e) {
    echo $e->__toString();
}