<?php

session_start();
session_destroy();

if(isset($_GET['home'])) {
    $ref = $_GET['log'];
    $edit = addslashes(htmlentities($_GET["home"]));
    header('location: '.$edit.'/?log= '.$ref.'');
}

?>