<?php
if($_POST["c_cost"] == "c_cost") {
	include "db.php";
    $error=array();
	$tarikh = addslashes(htmlentities($_POST["tarikh"]));
    $tarikh = str_replace("/", "",$tarikh );
	$bes = addslashes(htmlentities($_POST["hesab"]));
	$bed = addslashes(htmlentities($_POST["cst"]));
	$price = str_replace(",", "", $_POST["price"]);
	$price = addslashes(htmlentities($price));
	$sharh = addslashes(htmlentities($_POST["sharh"]));
	if(!empty($tarikh) && !empty($bes) && !empty($bed) && !empty($price) && !empty($bes) !==0 && !empty($bed) !==0){
	$sql = "INSERT INTO `ruznameh`(`date`, `sharh`, `price`, `hesab_bed`, `hesab_bes`) VALUES (:tarikh, :sharh, :price, :bed, :bes)";
$result = $conn->prepare($sql);
if($result->execute(array(
"tarikh" => $tarikh,
"sharh" => $sharh,
"price" => $price,
"bed" => $bed,
"bes" => $bes,
))){
    $data = array('res'=>'registered' );
}

}else{
        $data = array('res'=>'bad error');
}

    echo json_encode($data);
	
}

?>
