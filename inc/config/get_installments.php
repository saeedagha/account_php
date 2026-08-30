<?php

include "db.php";

$hesab_id=(int)$_POST['vam_id'];


/*
 بررسی وجود وام در جدول vams
 */

$sql="
SELECT id
FROM vams
WHERE hesab_id=:hesab_id
LIMIT 1
";


$stmt=$conn->prepare($sql);

$stmt->execute([
    ':hesab_id'=>$hesab_id
]);


$vam=$stmt->fetch(PDO::FETCH_ASSOC);



if(!$vam){

    exit;

}


$vam_id=$vam['id'];



/*
 گرفتن اقساط پرداخت نشده
 */

$sql="
SELECT
id,
installment_no,
due_date

FROM vam_installments

WHERE vam_id=:vam_id
AND status<>2

ORDER BY installment_no
";


$stmt=$conn->prepare($sql);

$stmt->execute([
    ':vam_id'=>$vam_id
]);



while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

    $date=$row['due_date'];

    $year=substr($date,0,4);

    $month=substr($date,4,2);


    $months=[
        '01'=>'فروردین',
        '02'=>'اردیبهشت',
        '03'=>'خرداد',
        '04'=>'تیر',
        '05'=>'مرداد',
        '06'=>'شهریور',
        '07'=>'مهر',
        '08'=>'آبان',
        '09'=>'آذر',
        '10'=>'دی',
        '11'=>'بهمن',
        '12'=>'اسفند'
    ];


    echo '
    <option value="'.$row['id'].'">
    قسط '.$row['installment_no'].' - '.$months[$month].' '.$year.'
    </option>';

}

?>