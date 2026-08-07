<?php
//include "../inc/config/db.php";

$kol_id =(int) addslashes(htmlentities($_POST['kol_id']));
$moein_id =(int) addslashes(htmlentities($_POST['moein_id']));
$tafsili =(int) addslashes(htmlentities($_POST['tafsili']));
$h_name = addslashes(htmlentities($_POST["h_name"]));
$tozih = addslashes(htmlentities($_POST["tozih"]));


	$sql = "INSERT INTO `hesabha` (`h_name`, `kol_id`, `moein_id`, `tafsili_id`, `mat`, `tozih`, `selectable`) VALUES (:h_name, :kol_id, :moein_id, :tafsili_id, :mat, :tozih, :selectable);";
	$result = $conn->prepare($sql);
	if($result->execute(array(
	"h_name" => $h_name,
	"kol_id" => $kol_id,
	"moein_id" => $moein_id,
	"tafsili_id" => $tafsili,
	"mat" => 1,
	"tozih" => $tozih,
	"selectable" => 1,
	))) {
		echo 'OKOKOKOKOKOKOKOKOKOKOKOKOKOKOKOK';
	}

?>

