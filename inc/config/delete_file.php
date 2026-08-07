<?php
require_once 'autoload.php';
if(isset($_POST["name"])) {
$fname = addslashes(htmlentities($_POST["name"]));
$joda = explode('/', $fname);
$home =BASE_URL;
$path = get_path($joda[1].'/'.$joda[2].'/'.$joda[3]);
if(unlink($path)){
	echo '1';
}
}
?>