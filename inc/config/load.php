<?php
function redirect() {
@session_start();
if (!isset($_SESSION['lgn'])){
header('Location: '.BASE_URL.'/login/index.php');
exit;
}
}
require_once ('jdf.php');



define("home", "/acc/");
function sumarr($s){
	 $sum = array_map(function ($h_id) { return array_sum($h_id); }, $total);
	 return $sum[$s];
}
function sums($vale, $st){
    $vale = intval($vale);
    $st = (int)$st;
    global $conn;
    if(!empty($vale)){
        if($st ==1){
            $sql = "SELECT sum(IF(`hesab_bed`=$vale, `price`, 0)) AS `final` FROM `ruznameh` ";
        }else{

            $sql = "SELECT sum(IF(`hesab_bes`=$vale, `price`, 0)) AS `final` FROM `ruznameh` ";
        }
        $stm = $conn->prepare($sql);
        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stm->fetch();
        return $row["final"];
    }else{
        return false;
    }
}
function sums_hesab($vale, $st){
    $vale = intval($vale);
    $st = (int)$st;
    global $conn;
    if(!empty($vale)){
        if($st ==1){
            $sql = "SELECT sum(IF(`hesab_bed`=$vale, `price`, 0)) AS `final` FROM `ruznameh` ";
        }else{

            $sql = "SELECT sum(IF(`hesab_bes`=$vale, `price`, 0)) AS `final` FROM `ruznameh` ";
        }
        $stm = $conn->prepare($sql);
        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stm->fetch();
        return $row["final"];
    }else{
        return false;
    }
}

function munde($val, $bes){
	$val = intval($val);
	$bes = (int)$bes;
	if(!empty($val)){
		if($bes ==1){
	global $conn;
	$sql = "SELECT sum(IF(`hesab_bed`=$val, `price`, 0))- sum(IF(`hesab_bes`=$val, `price`, 0)) AS `final` FROM `ruznameh` ";
		}else{
				global $conn;
	$sql = "SELECT sum(IF(`hesab_bes`=$val, `price`, 0))- sum(IF(`hesab_bed`=$val, `price`, 0)) AS `final` FROM `ruznameh` ";
		}	
			$stm = $conn->prepare($sql);
			 $stm->execute();

        $stm->setFetchMode(PDO::FETCH_ASSOC);
			
		$row = $stm->fetch();
	return $row["final"];
	
	}else{
		return false;
	}
	
	
	
	
}

function munde_date($val, $bes, $date){
	$val = intval($val);
	$bes = (int)$bes;
	if(!empty($val)){
		if($bes ==1){
	global $conn;
	$sql = "SELECT sum(IF(`hesab_bed`=$val, `price`, 0))- sum(IF(`hesab_bes`=$val, `price`, 0)) AS `final` FROM `ruznameh` WHERE `date` LIKE '$date%' ";
		}else{
				global $conn;
	$sql = "SELECT sum(IF(`hesab_bes`=$val, `price`, 0))- sum(IF(`hesab_bed`=$val, `price`, 0)) AS `final` FROM `ruznameh` WHERE `date` LIKE '$date%' ";
		}	
			$stm = $conn->prepare($sql);
			 $stm->execute();

        $stm->setFetchMode(PDO::FETCH_ASSOC);
			
		$row = $stm->fetch();
	return $row["final"];
	
	}else{
		return false;
	}
	
	
	
	
}


function kods($val){
		global $conn;
		$man= array(); 
$h_id=$val;
if(strlen($h_id) == 6){
$h_id=substr($h_id, 0, 6);
$man[]=$h_id;
$h_id=substr($h_id, 0, 4);
$man[]=$h_id;
$h_id=substr($h_id, 0, 2);
$man[]=$h_id;
}elseif(strlen($h_id) == 5){
$h_id=substr($h_id, 0, 5);
$man[]=$h_id;
$h_id=substr($h_id, 0, 2);
$man[]=$h_id;
}elseif(strlen($h_id) == 4){
$h_id=substr($h_id, 0, 4);
$man[]=$h_id;
$h_id=substr($h_id, 0, 2);
$man[]=$h_id;
}elseif(strlen($h_id) == 2){
	$h_id=substr($h_id, 0, 2);
$man[]=$h_id;
}
$data= array();
foreach ($man as $key => $value){
	

	 $stmt = $conn->prepare("select * from hesabha WHERE h_id=$value");

			 $stmt->execute();
$row = $stmt->fetch();
 $data[]=$row["h_name"];   


	
}
$data = array_reverse($data,true);
  return $data; 
} 
 
 
 
 
function find_hesab($val){

	global $conn;
 $sql = "SELECT * FROM `hesabha` WHERE `h_id`= $val ";
		$stm = $conn->prepare($sql);
			 $stm->execute();

        $stm->setFetchMode(PDO::FETCH_ASSOC);
			
		while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {  
              
                echo $row["h_name"]." - ".$row["h_id"];
				  } 	

}
function get_hesab($val){

	global $conn;
 $sql = "SELECT * FROM `hesabha` WHERE `h_id`= $val ";
		$stm = $conn->prepare($sql);
			 $stm->execute();

        $stm->setFetchMode(PDO::FETCH_ASSOC);
			
		while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {  
              
               return $row["h_name"];
				  } 	

}
function get_tz($val){
	
	global $conn;
 $sql = "SELECT * FROM `hesabha` WHERE `h_id`= $val ";
		$stm = $conn->prepare($sql);
			 $stm->execute();

        $stm->setFetchMode(PDO::FETCH_ASSOC);
			
		while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {  
              
               return $row["tozih"];
				  } 	
}
		 ?>
	

