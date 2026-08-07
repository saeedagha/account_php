<?php
require_once 'autoload.php';
require_once ('load.php');

function HashPassword($value){
	return md5("wbnj4b0ksbv".$value."rwbk420bnm");
}
function get_child_hesab($val) {
    global $conn;

    try {
        $sql = "SELECT `id`, `kol_id`, `h_name`
                FROM `hesabha`
                WHERE `kol_id` = :kol_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':kol_id' => $val
        ]);

        $ar = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($row['h_name']) {
                $ar[$row['id']] = $row['h_name'];
            } elseif ($row['kol_id']) {
                $ar[$row['id']] = gethesabname($row['kol_id']);
            }
        }

        return $ar;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function exist_key_option($val) {
    global $conn;
    try {
        $sql = "SELECT * FROM `tbl_opt` where klid = '$val'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['id'];
        }else{
            return false;
        }
    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function gethesabname($hesab){
    global $conn;

    try {
        $sql = "SELECT `h_name` FROM `hesabha` WHERE `id` = :id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $hesab]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return $row['h_name'];

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function get_child_kol($val) {
    global $conn;

    try {
        $sql = "SELECT `id`, `kol_id`, `h_name`
                FROM `hesabha`
                WHERE `kol_id` = :kol_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':kol_id' => $val
        ]);

        $ar = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($row['h_name']) {
                $ar[$row['id']] = $row['h_name'];
            } elseif ($row['kol_id']) {
                $ar[$row['id']] = gethesabname($row['kol_id']);
            }
        }

        return $ar;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function get_child_nll($val) {
    global $conn;

    try {
        $sql = "SELECT `id`, `kol_id`, `h_name`
                FROM `hesabha`
                WHERE `kol_id` = :kol_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':kol_id' => $val
        ]);

        $ar = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($row['h_name']) {
                $ar[$row['id']] = $row['h_name'];
            } elseif ($row['kol_id']) {
                $ar[$row['id']] = gethesabname($row['kol_id']);
            }
        }

        return $ar;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function get_child_moein($val) {
    global $conn;

    try {
        $sql = "SELECT child.`id`, parent.`h_name`
                FROM `hesabha` AS child
                LEFT JOIN `hesabha` AS parent
                    ON parent.`id` = child.`moein_id`
                WHERE child.`moein_id` = :moein_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':moein_id' => $val
        ]);

        $ar = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ar[$row['id']] = $row['h_name'];
        }

        return $ar;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function sum_moein($value)
{
    global $conn;

    $child = get_child_moein($value);
    $aru = array();

    if (empty($child)) {
        return $aru;
    }

    $accountIds = array_keys($child);

    foreach ($accountIds as $accountId) {
        $aru[$accountId]['bestankar'] = 0;
        $aru[$accountId]['bedehkar'] = 0;
        $aru[$accountId]['munde'] = 0;
    }

    $placeholders = implode(',', array_fill(0, count($accountIds), '?'));

    /*
     * Bedehkar
     */
    $sqlBed = "
        SELECT `hesab_bed` AS `hesab_id`,
               SUM(`price`) AS `total`
        FROM `ruznameh`
        WHERE `hesab_bed` IN ($placeholders)
        GROUP BY `hesab_bed`
    ";

    $stmtBed = $conn->prepare($sqlBed);
    $stmtBed->execute($accountIds);

    while ($row = $stmtBed->fetch(PDO::FETCH_ASSOC)) {
        $accountId = (int) $row['hesab_id'];

        if (isset($aru[$accountId])) {
            $aru[$accountId]['bedehkar'] = $row['total'];
        }
    }

    /*
     * Bestankar
     */
    $sqlBes = "
        SELECT `hesab_bes` AS `hesab_id`,
               SUM(`price`) AS `total`
        FROM `ruznameh`
        WHERE `hesab_bes` IN ($placeholders)
        GROUP BY `hesab_bes`
    ";

    $stmtBes = $conn->prepare($sqlBes);
    $stmtBes->execute($accountIds);

    while ($row = $stmtBes->fetch(PDO::FETCH_ASSOC)) {
        $accountId = (int) $row['hesab_id'];

        if (isset($aru[$accountId])) {
            $aru[$accountId]['bestankar'] = $row['total'];
        }
    }

    /*
     * Calculate balance
     */
    foreach ($aru as $accountId => &$account) {
        $account['munde'] =
            $account['bestankar'] - $account['bedehkar'];
    }

    unset($account);

    return $aru;
}
function sum_kol($value)
{
    global $conn;

    $child = get_child_kol($value);
    $childa = get_child_nll($value);

    $aru = array();

    /*
     * Collect all account IDs.
     *
     * get_child_kol() and get_child_nll() are mutually exclusive:
     * the first has moein_id and the second does not.
     */
    $accountIds = array_unique(
        array_merge(
            array_keys($child),
            array_keys($childa)
        )
    );

    if (empty($accountIds)) {
        return $aru;
    }

    /*
     * Initialize result structure.
     */
    foreach ($accountIds as $accountId) {
        $accountId = (int) $accountId;

        $aru[$accountId] = array(
            'bestankar' => 0,
            'bedehkar'  => 0,
            'munde'     => 0
        );
    }

    $placeholders = implode(
        ',',
        array_fill(0, count($accountIds), '?')
    );

    /*
     * Bedehkar
     */
    $sqlBed = "
        SELECT
            `hesab_bed` AS `hesab_id`,
            SUM(`price`) AS `total`
        FROM `ruznameh`
        WHERE `hesab_bed` IN ($placeholders)
        GROUP BY `hesab_bed`
    ";

    $stmtBed = $conn->prepare($sqlBed);
    $stmtBed->execute($accountIds);

    while ($row = $stmtBed->fetch(PDO::FETCH_ASSOC)) {
        $accountId = (int) $row['hesab_id'];

        if (isset($aru[$accountId])) {
            $aru[$accountId]['bedehkar'] = $row['total'];
        }
    }

    /*
     * Bestankar
     */
    $sqlBes = "
        SELECT
            `hesab_bes` AS `hesab_id`,
            SUM(`price`) AS `total`
        FROM `ruznameh`
        WHERE `hesab_bes` IN ($placeholders)
        GROUP BY `hesab_bes`
    ";

    $stmtBes = $conn->prepare($sqlBes);
    $stmtBes->execute($accountIds);

    while ($row = $stmtBes->fetch(PDO::FETCH_ASSOC)) {
        $accountId = (int) $row['hesab_id'];

        if (isset($aru[$accountId])) {
            $aru[$accountId]['bestankar'] = $row['total'];
        }
    }

    /*
     * Calculate balance.
     */
    foreach ($aru as $accountId => &$account) {
        $account['munde'] =
            $account['bestankar'] - $account['bedehkar'];
    }

    unset($account);

    return $aru;
}
function sum_kk($value){
    $childs = get_sum_kol_page($value);
    $aru = array();
    $total_bes = 0;
    $total_bed = 0;
    foreach ($childs as $k=>$v) {
        $total_bes = sums($v, 0);
        $total_bed = sums($v, 1);
        $munde = $total_bes - $total_bed;
        $aru[$value]['bestankar'] = $total_bes;
        $aru[$value]['bedehkar'] = $total_bed;
        $aru[$value]['munde'] =$munde;

    }
    return $aru;
}
function get_sum_kol_page($val) {
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` =$val and  `moein_id` is  NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ar=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row['kol_id']){
                $ar[$row['kol_id']][$row['id']] = gethesabname($row['id']);
                //array_push($ar[$row['id']],gethesabname($row['kol_id']));
            }
        }
        return $ar;

    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function date_sep($val1) {
    $farsi_date = substr($val1,0,4).'/'.substr($val1,4,2).'/'.substr($val1,6,2);
    return $farsi_date;
}
function display_hesab($id){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where `id` =$id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ar=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row['kol_id']){
                array_push($ar,gethesabname($row['kol_id']));

            }
            if($row['moein_id']){
                array_push($ar,gethesabname($row['moein_id']));
            }
            if($row['h_name']){
                array_push($ar,$row['h_name']);
            }
        }
        return $ar;

    } catch (Exception $e) {

        echo $e->getMessage();

    }

}
function sub_sandugh(){
    global $conn;
    $val = SANDUGH_ID;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` =$val and `moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if(null_moein($row['id'])){ // Check moein_id Null
                $ary[$row['id']] = $row['h_name'];
            }else{ //select row has row_id as moein_id
                $sc = $row['id'];
                $sql2 = "SELECT * FROM `hesabha` where `moein_id` =$sc";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();
                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $ary[$row2['moein_id']][$row2['id']] = $row2['h_name'];
                }

            }

        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }

}
function sub_ashkhas(){
    global $conn;
    $val = ASHKHAS;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` =$val and `moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function sub_income(){
    global $conn;
    $val = DARAMAD;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` =$val and `moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if(null_moein($row['id'])){ // Check moein_id Null
                $ary[$row['id']] = $row['h_name'];
            }else{ //select row has row_id as moein_id
                $sc = $row['id'];
                $sql2 = "SELECT * FROM `hesabha` where `moein_id` =$sc";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();
                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $ary[$row2['moein_id']][$row2['id']] = $row2['h_name'];
                }

            }

        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }




/*    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` =$val and `moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }*/
}

function sub_vam(){
    global $conn;
    $val = VAM;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` =$val and `moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function sub_cost(){
    global $conn;
    $val = HAZINEH;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` =$val and `moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if(null_moein($row['id'])){ // Check moein_id Null
                $ary[$row['id']] = $row['h_name'];
            }else{ //select row has row_id as moein_id
                $sc = $row['id'];
                $sql2 = "SELECT * FROM `hesabha` where `moein_id` =$sc";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();
                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $ary[$row2['moein_id']][$row2['id']] = $row2['h_name'];
                }

              //  $ary[][$row['id']][$row['id']] = $row['h_name'];
            }





           // $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function null_moein($id){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha`  where `moein_id` =$id ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            return false;
        }else{
            return true;
        }


    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function null_tafsili($id){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha`  where `tafsili_id` =$id ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            return false;
        }else{
            return true;
        }


    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function list_kol(){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` is NULL and `moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function list_moein(){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` is not NULL and `moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function list_tafsili(){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where (`kol_id` and `moein_id`  ) is not NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }
}

function tree_hesab(){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$ary[] =$row;

        }



        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }

}
function str_ends_ba($string, $substring) {
    $len = strlen($substring);
    if ($len == 0) {
        return true;
    }
    // check the string from the end by adding minus sign
    return substr($string, -$len) === $substring;
}
function search_url($string){
    $val = SANDUGH_ID;
    $url =  $_SERVER['REQUEST_URI'];
   echo  preg_replace(  BASE_URL,'',$url);

    if ( strstr( $url, $string ) ) {
      return true;
    } else {
        return false;
    }

}


function group_by($key, $data) {
    $result = array();

    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}
function display_parent_hesab ($val){
  global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where id = '$val'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
if(!$row['parent_id'] == 0) {
    $ary[] = $row['h_name'];
    $ary[] = display_parent_hesab($row['parent_id']);
}else {
    $ary[] = $row['h_name'];
}
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }

}
function prepare_array($ara){
    $dat =array();
    foreach ($ara as $item) {

        if(is_array($item)){

            $dat[] =  $item[0];
            if(isset($item[1])) {
                if (is_array($item[1]) && !empty($item[1])) {
                    $dat[] = $item[1][0];

                    if(isset($item[1][1])) {
                        if (is_array($item[1][1]) && !empty($item[1][1])) {
                            $dat[] = $item[1][1][0];

                            if(isset($item[1][1][1])) {
                                if (is_array($item[1][1][1]) && !empty($item[1][1][1])) {
                                    $dat[] = $item[1][1][1][0];

                                }
                            }


                        }

                    }


                }
            }





        }  else {
            $dat[]=$item;
        }
        //  return $dat;
    }
   // print_r($dat);

    return $dat;


//print_r($a);


}
function get_account ($val){
    $ara =   display_parent_hesab($val);
    $fd = prepare_array($ara);
    $list = implode(' » ', array_reverse($fd));
   return $list;
}


function getSubhesabs($parent_id,  &$data) {
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where parent_id = '$parent_id'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $row['id']);
         //   $data[] =  $row['h_name'];
         //   echo str_repeat("-", ($level * 4)) . $row['h_name'] . '<br>';

            getSubhesabs($row['id'],$data);

        }

    } catch (Exception $e) {

        echo $e->getMessage();

    }

}

function list_sub_costs(){
    global $conn;
    $val = HAZINEH;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` =$val and `moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if(null_moein($row['id'])){ // Check moein_id Null
                $ary[$row['id']] = $row['h_name'];
            }else{ //select row has row_id as moein_id
                $sc = $row['id'];
                $sql2 = "SELECT * FROM `hesabha` where `moein_id` =$sc";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();
                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    $ary[$row2['moein_id']][$row2['id']] = $row2['h_name'];
                }

            }

        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }

    /*
    global $conn;
    $val = HAZINEH;
    try {
        $sql = "SELECT * FROM `hesabha` where `kol_id` =$val and`moein_id` is NULL and `tafsili_id` is NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $ary= array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {

        echo $e->getMessage();

    }*/
}
function list_all_hesab($opt)
{
    $sandugh = sub_sandugh();
    $sub_ashkhas = sub_ashkhas();
    $sub_income = sub_income();
    $sub_vam = sub_vam();
    $sub_cost = list_sub_costs();
    echo '<optgroup label="صندوق">';
    foreach ($sandugh as $key => $value) {
        if (is_array($value)) {
            echo '<optgroup label="' . gethesabname($key) . '">';
            foreach ($value as $keys => $values) {
                $v=''; if($keys == $opt) {$v = ' selected';}
                echo '<option value="' . $keys . '" data-tokens="' . gethesabname($key) . '" '.$v.' >' . $values . '</option>';
            }
            echo '</optgroup>';
        } else {
         $v=''; if($key == $opt) {$v = ' selected';}
            echo '<option value="' . $key . '"  '.$v.' >' . $value . '</option>';
        }
    }
    echo '</optgroup>';
    echo '<optgroup label="درآمد ها">';
    foreach ($sub_income as $key => $value) {
        if (is_array($value)) {

            foreach ($value as $keys => $values) {
                $v=''; if($keys == $opt) {$v = ' selected';}
                echo '<option value="' . $keys . '" data-tokens="' . gethesabname($key) . '"  '.$v.'>' . $values . '</option>';
            }

        } else {
            $v=''; if($key == $opt) {$v = ' selected';}
            echo '<option value="' . $key . '"  '.$v.'>' . $value . '</option>';
        }
    }
    echo '</optgroup>';
    echo '<optgroup label="اشخاص">';
    foreach ($sub_ashkhas as $key => $value) {

        if (is_array($value)) {
            foreach ($value as $keys => $values) {
                $v=''; if($keys == $opt) {$v = ' selected';}
                echo '<option value="' . $keys . '" data-tokens="' . gethesabname($key) . '" '.$v.'>' . $values . '</option>';
            }

        } else {
            $v=''; if($key == $opt) {$v = ' selected';}
            echo '<option value="' . $key . '" '.$v.'>' . $value . '</option>';
        }

    }
    echo '</optgroup>';
    echo '<optgroup label="وام ها">';
    foreach ($sub_vam as $key => $value) {
        $v=''; if($key == $opt) {$v = ' selected';}
        echo '<option value="' . $key . '" '.$v.'>' . $value . '</option>';
    }
    echo '</optgroup>';
    echo '<optgroup label="هزینه ها">';
    foreach ($sub_cost as $key => $value) {
        if (is_array($value)) {
            echo '<optgroup label="' . gethesabname($key) . '">';
            foreach ($value as $keys => $values) {
                $v=''; if($keys == $opt) {$v = ' selected';}
                echo '<option value="' . $keys . '" data-tokens="' . gethesabname($key) . '" '.$v.'>' . $values . '</option>';
            }
            echo '</optgroup>';
        } else {
            $v=''; if($key == $opt) {$v = ' selected';}
            echo '<option value="' . $key . '" '.$v.'>' . $value . '</option>';
        }
    }
    echo '</optgroup>';


}
function get_detail_hesab($val){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where `id` =$val";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function get_prn($val){
  global $conn;
try {
    $sql = "SELECT * FROM `hesabha` where id = '$val'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$data = [];
$data['id'] = $row['id'];
$data['parent_id'] = $row['parent_id'];
        return $data;

    }

} catch (Exception $e) {

    echo $e->getMessage();

}
}
function selectable_option ($val)
{
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where id = '$val'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['selectable'] != 1) {
                return ' disabled ';
            } else {
                return '';
            }
        }


    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function hesab_lst()
{
    $aray = getParenthesabs();
    foreach ($aray as $value) {
            echo '<option '.selectable_option($value).'>' . gethesabname($value) . '</option>';

        }



}

function only_parent(){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['parent_id'] == 0) {
              $array[$row['id']] = $row['h_name'];
            }

        }

        return $array;
    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function is_parent_zero($id){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha` where id = '$id' ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $rowd = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($rowd['parent_id'] == 0) {
               return true;
            }else {
                return false;
            }




    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function moein_parent(){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['parent_id'] != 0) {

               if(is_parent_zero($row['parent_id']) ){

                   $array[$row['id']] = $row['h_name'];
               }


            }

        }

        return $array;
    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function tafsili_parent(){
    global $conn;
    try {
        $sql = "SELECT * FROM `hesabha`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $array=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['parent_id'] != 0) {

                if(!is_parent_zero($row['parent_id']) ){

                    $array[$row['id']] = $row['h_name'];
                }


            }

        }

        return $array;
    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
function sum_period($kol_id,$time_s,$time_e) {
    global $conn;
    if($kol_id==2) {
        $hesab_type = "hesab_bes";
    }else {
        $hesab_type = "hesab_bed";
    }
    try{
        $q = " AND date BETWEEN $time_s And $time_e  ";
        $sql = "SELECT ruznameh.date,ruznameh.hesab_bed,ruznameh.hesab_bes, hesabha.* , sum(ruznameh.price)as jame FROM `ruznameh` LEFT JOIN hesabha on $hesab_type=hesabha.id where kol_id=$kol_id $q GROUP by $hesab_type ORDER BY `hesabha`.`moein_id` ASC ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $glk=0;
        foreach ($row4 as $gb) {
            $glk +=$gb["jame"];
        }
        return $glk;



    } catch (Exception $e) {
    echo $e->getMessage();
}


}
function get_description_last_vam($val) {
    global $conn;
    try {
        $sql = "SELECT * FROM `ruznameh` WHERE hesab_bed=$val ORDER BY date desc";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;

    } catch (Exception $e) {

        echo $e->getMessage();

    }
}
?>