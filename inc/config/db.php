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
function gethesabname($vale)
{
    global $conn;

    static $cache = array();

    $vale = (int) $vale;

    if (empty($vale)) {
        return false;
    }

    if (array_key_exists($vale, $cache)) {
        return $cache[$vale];
    }

    $sql = "
        SELECT `h_name`
        FROM `hesabha`
        WHERE `id` = :id
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $vale
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $cache[$vale] = false;
        return false;
    }

    $cache[$vale] = $row['h_name'];

    return $cache[$vale];
}
function get_child_kol($val)
{
    global $conn;

    $val = (int) $val;

    if ($val <= 0) {
        return array();
    }

    try {
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` = :kol_id
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':kol_id' => $val
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
function get_child_nll($val)
{
    global $conn;

    $val = (int) $val;

    if ($val <= 0) {
        return array();
    }

    try {
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` = :kol_id
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':kol_id' => $val
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
    $childa = $child;

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
function sum_kk($value)
{
    global $conn;

    $childs = get_sum_kol_page($value);
    $accountIds = array();

    foreach ($childs as $kolId => $accounts) {
        if (!is_array($accounts)) {
            continue;
        }

        foreach ($accounts as $accountId => $name) {
            $accountIds[] = (int) $accountId;
        }
    }

    $accountIds = array_values(array_unique($accountIds));

    if (empty($accountIds)) {
        return array();
    }

    $placeholders = implode(
        ',',
        array_fill(0, count($accountIds), '?')
    );

    /*
     * Bedehkar
     */
    $sqlBed = "
        SELECT SUM(`price`) AS `total`
        FROM `ruznameh`
        WHERE `hesab_bed` IN ($placeholders)
    ";

    $stmtBed = $conn->prepare($sqlBed);
    $stmtBed->execute($accountIds);

    $rowBed = $stmtBed->fetch(PDO::FETCH_ASSOC);
    $totalBed = $rowBed['total'] ?? 0;

    /*
     * Bestankar
     */
    $sqlBes = "
        SELECT SUM(`price`) AS `total`
        FROM `ruznameh`
        WHERE `hesab_bes` IN ($placeholders)
    ";

    $stmtBes = $conn->prepare($sqlBes);
    $stmtBes->execute($accountIds);

    $rowBes = $stmtBes->fetch(PDO::FETCH_ASSOC);
    $totalBes = $rowBes['total'] ?? 0;

    return array(
        $value => array(
            'bestankar' => $totalBes,
            'bedehkar'  => $totalBed,
            'munde'     => $totalBes - $totalBed
        )
    );
}
function get_sum_kol_page($val)
{
    global $conn;

    $val = (int) $val;

    if ($val <= 0) {
        return array();
    }

    try {
        $sql = "
            SELECT `id`, `kol_id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` = :kol_id
              AND `moein_id` IS NULL
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':kol_id' => $val
        ]);

        $ar = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if (!empty($row['kol_id'])) {
                $ar[$row['kol_id']][$row['id']] = $row['h_name'];
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
function display_hesab($id)
{
    global $conn;

    $id = (int) $id;

    if ($id <= 0) {
        return array();
    }

    try {
        $sql = "
            SELECT `kol_id`, `moein_id`, `h_name`
            FROM `hesabha`
            WHERE `id` = :id
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return array();
        }

        $ar = array();

        if ($row['kol_id']) {
            $ar[] = gethesabname($row['kol_id']);
        }

        if ($row['moein_id']) {
            $ar[] = gethesabname($row['moein_id']);
        }

        if ($row['h_name']) {
            $ar[] = $row['h_name'];
        }

        return $ar;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function sub_sandugh()
{
    global $conn;

    $val = SANDUGH_ID;

    try {
        // Get direct accounts under صندوق
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` = :kol_id
              AND `moein_id` IS NULL
              AND `tafsili_id` IS NULL
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':kol_id' => $val
        ]);

        $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($parents)) {
            return array();
        }

        $parentIds = array_column($parents, 'id');

        // Get all Moein children in one query
        $placeholders = implode(
            ',',
            array_fill(0, count($parentIds), '?')
        );

        $sqlChildren = "
            SELECT `moein_id`, `id`, `h_name`
            FROM `hesabha`
            WHERE `moein_id` IN ($placeholders)
        ";

        $stmtChildren = $conn->prepare($sqlChildren);
        $stmtChildren->execute($parentIds);

        $children = array();

        while ($row = $stmtChildren->fetch(PDO::FETCH_ASSOC)) {
            $children[$row['moein_id']][$row['id']] = $row['h_name'];
        }

        $ary = array();

        foreach ($parents as $row) {
            $parentId = $row['id'];

            if (isset($children[$parentId])) {
                $ary[$parentId] = $children[$parentId];
            } else {
                $ary[$parentId] = $row['h_name'];
            }
        }

        return $ary;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function sub_ashkhas()
{
    global $conn;

    $val = ASHKHAS;

    try {
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` = :kol_id
              AND `moein_id` IS NULL
              AND `tafsili_id` IS NULL
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':kol_id' => $val
        ]);

        $ary = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function sub_income()
{
    global $conn;

    $val = DARAMAD;

    try {
        // Get direct accounts under درآمد
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` = :kol_id
              AND `moein_id` IS NULL
              AND `tafsili_id` IS NULL
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':kol_id' => $val
        ]);

        $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($parents)) {
            return array();
        }

        $parentIds = array_column($parents, 'id');

        // Get all Moein children in one query
        $placeholders = implode(
            ',',
            array_fill(0, count($parentIds), '?')
        );

        $sqlChildren = "
            SELECT `moein_id`, `id`, `h_name`
            FROM `hesabha`
            WHERE `moein_id` IN ($placeholders)
        ";

        $stmtChildren = $conn->prepare($sqlChildren);
        $stmtChildren->execute($parentIds);

        $children = array();

        while ($row = $stmtChildren->fetch(PDO::FETCH_ASSOC)) {
            $children[$row['moein_id']][$row['id']] = $row['h_name'];
        }

        $ary = array();

        foreach ($parents as $row) {
            $parentId = $row['id'];

            if (isset($children[$parentId])) {
                $ary[$parentId] = $children[$parentId];
            } else {
                $ary[$parentId] = $row['h_name'];
            }
        }

        return $ary;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function sub_vam()
{
    global $conn;

    $val = VAM;

    try {
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` = :kol_id
              AND `moein_id` IS NULL
              AND `tafsili_id` IS NULL
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':kol_id' => $val
        ]);

        $ary = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function sub_cost()
{
    global $conn;

    $val = HAZINEH;

    try {
        /*
         * Get direct accounts under هزینه
         */
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` = :kol_id
              AND `moein_id` IS NULL
              AND `tafsili_id` IS NULL
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':kol_id' => $val
        ]);

        $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($parents)) {
            return array();
        }

        /*
         * Collect parent IDs
         */
        $parentIds = array_column($parents, 'id');

        /*
         * Get all Moein children in one query
         */
        $placeholders = implode(
            ',',
            array_fill(0, count($parentIds), '?')
        );

        $sqlChildren = "
            SELECT `moein_id`, `id`, `h_name`
            FROM `hesabha`
            WHERE `moein_id` IN ($placeholders)
        ";

        $stmtChildren = $conn->prepare($sqlChildren);
        $stmtChildren->execute($parentIds);

        $children = array();

        while ($row = $stmtChildren->fetch(PDO::FETCH_ASSOC)) {
            $children[$row['moein_id']][$row['id']] = $row['h_name'];
        }

        /*
         * Build the same result structure as the old function
         */
        $ary = array();

        foreach ($parents as $row) {
            $parentId = $row['id'];

            if (isset($children[$parentId])) {
                $ary[$parentId] = $children[$parentId];
            } else {
                $ary[$parentId] = $row['h_name'];
            }
        }

        return $ary;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function null_moein($id)
{
    global $conn;

    $id = (int) $id;

    if ($id <= 0) {
        return true;
    }

    try {
        $sql = "
            SELECT `id`
            FROM `hesabha`
            WHERE `moein_id` = :moein_id
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':moein_id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) === false;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function null_tafsili($id)
{
    global $conn;

    $id = (int) $id;

    if ($id <= 0) {
        return true;
    }

    try {
        $sql = "
            SELECT `id`
            FROM `hesabha`
            WHERE `tafsili_id` = :tafsili_id
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':tafsili_id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) === false;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function list_kol()
{
    global $conn;

    try {
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` IS NULL
              AND `moein_id` IS NULL
              AND `tafsili_id` IS NULL
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $ary = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function list_moein()
{
    global $conn;

    try {
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` IS NOT NULL
              AND `moein_id` IS NULL
              AND `tafsili_id` IS NULL
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $ary = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ary[$row['id']] = $row['h_name'];
        }

        return $ary;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function list_tafsili()
{
    global $conn;

    try {
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE (`kol_id` AND `moein_id`) IS NOT NULL
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $ary = array();

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


function getSubhesabs($parent_id, &$data)
{
    global $conn;

    try {
        $sql = "
            SELECT `id`
            FROM `hesabha`
            WHERE `parent_id` = :parent_id
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':parent_id' => (int) $parent_id
        ]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row['id'];

            getSubhesabs($row['id'], $data);
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function list_sub_costs()
{
    global $conn;

    $val = HAZINEH;

    try {
        // Get direct accounts under هزینه
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `kol_id` = :kol_id
              AND `moein_id` IS NULL
              AND `tafsili_id` IS NULL
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':kol_id' => $val
        ]);

        $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($parents)) {
            return array();
        }

        $parentIds = array_column($parents, 'id');

        // Get all Moein children in one query
        $placeholders = implode(
            ',',
            array_fill(0, count($parentIds), '?')
        );

        $sqlChildren = "
            SELECT `moein_id`, `id`, `h_name`
            FROM `hesabha`
            WHERE `moein_id` IN ($placeholders)
        ";

        $stmtChildren = $conn->prepare($sqlChildren);
        $stmtChildren->execute($parentIds);

        $children = array();

        while ($row = $stmtChildren->fetch(PDO::FETCH_ASSOC)) {
            $children[$row['moein_id']][$row['id']] = $row['h_name'];
        }

        $ary = array();

        foreach ($parents as $row) {
            $parentId = $row['id'];

            if (isset($children[$parentId])) {
                $ary[$parentId] = $children[$parentId];
            } else {
                $ary[$parentId] = $row['h_name'];
            }
        }

        return $ary;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function list_all_hesab($opt)
{
    global $conn;

    $sandugh = sub_sandugh();
    $sub_ashkhas = sub_ashkhas();
    $sub_income = sub_income();
    $sub_vam = sub_vam();
    $sub_cost = list_sub_costs();

    /*
     * Collect parent account IDs that are used
     * for optgroup labels / data-tokens.
     */
    $parentIds = array();

    foreach (array($sandugh, $sub_income, $sub_cost) as $groups) {
        foreach ($groups as $key => $value) {
            if (is_array($value)) {
                $parentIds[] = (int) $key;
            }
        }
    }

    $parentNames = array();

    if (!empty($parentIds)) {
        $parentIds = array_values(array_unique($parentIds));

        $placeholders = implode(
            ',',
            array_fill(0, count($parentIds), '?')
        );

        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `id` IN ($placeholders)
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute($parentIds);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $parentNames[(int) $row['id']] = $row['h_name'];
        }
    }

    echo '<optgroup label="صندوق">';

    foreach ($sandugh as $key => $value) {

        if (is_array($value)) {

            $parentName = $parentNames[(int) $key] ?? '';

            echo '<optgroup label="' . $parentName . '">';

            foreach ($value as $keys => $values) {
                $v = '';

                if ($keys == $opt) {
                    $v = ' selected';
                }

                echo '<option value="' . $keys . '" data-tokens="' .
                    $parentName . '" ' . $v . ' >' .
                    $values .
                    '</option>';
            }

            echo '</optgroup>';

        } else {

            $v = '';

            if ($key == $opt) {
                $v = ' selected';
            }

            echo '<option value="' . $key . '" ' . $v . ' >' .
                $value .
                '</option>';
        }
    }

    echo '</optgroup>';


    echo '<optgroup label="درآمد ها">';

    foreach ($sub_income as $key => $value) {

        if (is_array($value)) {

            $parentName = $parentNames[(int) $key] ?? '';

            foreach ($value as $keys => $values) {

                $v = '';

                if ($keys == $opt) {
                    $v = ' selected';
                }

                echo '<option value="' . $keys .
                    '" data-tokens="' . $parentName .
                    '" ' . $v . '>' .
                    $values .
                    '</option>';
            }

        } else {

            $v = '';

            if ($key == $opt) {
                $v = ' selected';
            }

            echo '<option value="' . $key .
                '" ' . $v . '>' .
                $value .
                '</option>';
        }
    }

    echo '</optgroup>';


    echo '<optgroup label="اشخاص">';

    foreach ($sub_ashkhas as $key => $value) {

        if (is_array($value)) {

            $parentName = $parentNames[(int) $key] ?? '';

            foreach ($value as $keys => $values) {

                $v = '';

                if ($keys == $opt) {
                    $v = ' selected';
                }

                echo '<option value="' . $keys .
                    '" data-tokens="' . $parentName .
                    '" ' . $v . '>' .
                    $values .
                    '</option>';
            }

        } else {

            $v = '';

            if ($key == $opt) {
                $v = ' selected';
            }

            echo '<option value="' . $key .
                '" ' . $v . '>' .
                $value .
                '</option>';
        }
    }

    echo '</optgroup>';


    echo '<optgroup label="وام ها">';

    foreach ($sub_vam as $key => $value) {

        $v = '';

        if ($key == $opt) {
            $v = ' selected';
        }

        echo '<option value="' . $key .
            '" ' . $v . '>' .
            $value .
            '</option>';
    }

    echo '</optgroup>';


    echo '<optgroup label="هزینه ها">';

    foreach ($sub_cost as $key => $value) {

        if (is_array($value)) {

            $parentName = $parentNames[(int) $key] ?? '';

            echo '<optgroup label="' . $parentName . '">';

            foreach ($value as $keys => $values) {

                $v = '';

                if ($keys == $opt) {
                    $v = ' selected';
                }

                echo '<option value="' . $keys .
                    '" data-tokens="' . $parentName .
                    '" ' . $v . '>' .
                    $values .
                    '</option>';
            }

            echo '</optgroup>';

        } else {

            $v = '';

            if ($key == $opt) {
                $v = ' selected';
            }

            echo '<option value="' . $key .
                '" ' . $v . '>' .
                $value .
                '</option>';
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
function get_prn($val)
{
    global $conn;

    $val = (int) $val;

    if ($val <= 0) {
        return null;
    }

    try {
        $sql = "
            SELECT `id`, `parent_id`
            FROM `hesabha`
            WHERE `id` = :id
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':id' => $val
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return [
            'id' => $row['id'],
            'parent_id' => $row['parent_id']
        ];

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

function only_parent()
{
    global $conn;

    try {
        $sql = "
            SELECT `id`, `h_name`
            FROM `hesabha`
            WHERE `parent_id` = 0
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $array = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $array[$row['id']] = $row['h_name'];
        }

        return $array;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function is_parent_zero($id)
{
    global $conn;

    $id = (int) $id;

    if ($id <= 0) {
        return false;
    }

    try {
        $sql = "
            SELECT `parent_id`
            FROM `hesabha`
            WHERE `id` = :id
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return false;
        }

        return (int) $row['parent_id'] === 0;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function moein_parent()
{
    global $conn;

    try {
        $sql = "
            SELECT
                child.`id`,
                child.`h_name`
            FROM `hesabha` AS child
            INNER JOIN `hesabha` AS parent
                ON parent.`id` = child.`parent_id`
            WHERE child.`parent_id` != 0
              AND parent.`parent_id` = 0
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $array = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $array[$row['id']] = $row['h_name'];
        }

        return $array;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function tafsili_parent()
{
    global $conn;

    try {
        $sql = "
            SELECT
                child.`id`,
                child.`h_name`
            FROM `hesabha` AS child
            INNER JOIN `hesabha` AS parent
                ON parent.`id` = child.`parent_id`
            WHERE child.`parent_id` != 0
              AND parent.`parent_id` != 0
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $array = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $array[$row['id']] = $row['h_name'];
        }

        return $array;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function sum_period($kol_id, $time_s, $time_e)
{
    global $conn;

    $kol_id = (int) $kol_id;
    $time_s = (int) $time_s;
    $time_e = (int) $time_e;

    if ($kol_id == 2) {
        $hesab_type = 'hesab_bes';
    } else {
        $hesab_type = 'hesab_bed';
    }

    try {

        $sql = "
            SELECT COALESCE(SUM(ruznameh.price), 0) AS jame
            FROM `ruznameh`
            INNER JOIN `hesabha`
                ON ruznameh.`$hesab_type` = hesabha.`id`
            WHERE hesabha.`kol_id` = :kol_id
              AND ruznameh.`date` BETWEEN :time_s AND :time_e
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':kol_id' => $kol_id,
            ':time_s' => $time_s,
            ':time_e' => $time_e
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['jame'] ?? 0;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
function get_description_last_vam($val)
{
    global $conn;

    $val = (int) $val;

    if ($val <= 0) {
        return false;
    }

    try {
        $sql = "
            SELECT *
            FROM `ruznameh`
            WHERE `hesab_bed` = :hesab_bed
            ORDER BY `date` DESC
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':hesab_bed' => $val
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>