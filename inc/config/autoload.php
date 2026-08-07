<?php
$db ="saeedmir_blighted4851"; //saeedmir_blighted4851
$user ="saeedmir_ranked0463"; //saeedmir_ranked0463
$pass="Gm7Jf1YR!wEI^Fr%OG^^!uXcMV@RfJid"; //Gm7Jf1YR!wEI^Fr%OG^^!uXcMV@RfJid
$base ="https://saeedmirzaei.ir/account"; // https://saeedmirzaei.ir/account
try {
    $conn =  new PDO("mysql:host=localhost;dbname=$db", $user, $pass , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
}catch(PDOException $e) {
    echo $e->__toString ();
}
function setting_tbl(){
    global $conn;
    try {
        $sql = "SELECT * FROM `tbl_opt`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['klid']] = $row['val'];
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
$option = setting_tbl();
if(array_key_exists('sandugh_id', $option)){
    define('SANDUGH_ID', $option['sandugh_id']);
}else{
    define('SANDUGH_ID', "0");
}
if(array_key_exists('ashkhas_id', $option)){
    define('ASHKHAS', $option['ashkhas_id']);
}else{
    define('ASHKHAS', "0");
}
if(array_key_exists('income_id', $option)){
    define('DARAMAD', $option['income_id']);
}else{
    define('DARAMAD', "0");
}
if(array_key_exists('vam_id', $option)){
    define('VAM', $option['vam_id']);
}else{
    define('VAM', "0");
}
if(array_key_exists('cost_id', $option)){
    define('HAZINEH', $option['cost_id']);
}else{
    define('HAZINEH', "0");
}
if(array_key_exists('col_tsk', $option)){
    define('COLOR', $option['col_tsk']);
}else{
    define('COLOR', "purple");
}
$base_dir = $_SERVER['DOCUMENT_ROOT'].'/account/';
define('BASE_URL', $base);
define('BASE_PATH', $base_dir);
function get_path($val) {
    return BASE_PATH.$val;

}
