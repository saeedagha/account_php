<?php
  ob_start();
if(isset($_POST['user']) && !empty($_POST['user']) && isset($_POST['pass']) && !empty($_POST['pass']) ) {
	require_once('../inc/config/db.php');
	$user =addslashes(htmlentities($_POST['user']));
	$pass = addslashes(htmlentities($_POST['pass']));
	$pass = HashPassword($pass);
	
	if(isset($_POST['loc'])) {
	$loc = addslashes(htmlentities($_POST['loc']));
	}else{
	$loc = '../index.php';	
	}
	$sql = "SELECT * FROM `tbl_user` WHERE `username` = :username AND `password` = :password";
    $number = $conn->prepare($sql);
	$number->execute(array(
	'username' => $user,
	'password' => $pass
	));
	$count = $number->rowcount();
$row = $number->fetch();
if ($count ==1){
 session_start();
$_SESSION['lgn'] = $row['id'];

	  $data = array('res'=>'vorud', 'loc' =>$loc );
   
//header('location:true.php');
}else{
	$data = array('res'=>'bad');
/*<script>
	alert("Invalid Username or Password")
	window.location="index.php";
</script>*/
}
 echo json_encode($data);
}
?>