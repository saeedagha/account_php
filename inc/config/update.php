<?php
if($_POST["updt"] == "updt") {
	include "db.php";
	$tarikh = addslashes(htmlentities($_POST["tarikh"]));
	$hesab = addslashes(htmlentities($_POST["hesab"]));
	$cst = addslashes(htmlentities($_POST["cst"]));
	$price = str_replace(",", "", $_POST["price"]);
	$price = addslashes(htmlentities($price));
	$sharh = addslashes(htmlentities($_POST["sharh"]));
	$idk = addslashes(htmlentities($_POST["idk"]));
	if(!empty($tarikh) && !empty($hesab) && !empty($cst) && !empty($price) && !empty($hesab) !==0 && !empty($cst) !==0){
	$sql = "UPDATE `ruznameh`  SET `date`= :tarikh, `sharh`= :sharh, `price`= :price, `hesab_bed`= :hesab,  `hesab_bes`= :cst WHERE `id` = $idk ";
$result = $conn->prepare($sql);
if($result->execute(array(
"tarikh" => $tarikh,
"sharh" => $sharh,
"price" => $price,
"cst" => $cst,
"hesab" => $hesab,



))){
	
	echo '3030';
}


}else{
	
	echo '4040';
}






	
}

?>
