<?php
/*
 * ==============================
 * ثبت پرداخت قسط وام
 * ==============================
 */

if(
    isset($_POST['vam_payment'])
    &&
    $_POST['vam_payment']==1
){

    include "db.php";

    $data=[
        'res'=>'bad error'
    ];


    $tarikh = trim($_POST['tarikh'] ?? '');
    $tarikh = str_replace('/','',$tarikh);


    $bed = (int)($_POST['cst'] ?? 0);
    $bes = (int)($_POST['hesab'] ?? 0);


    $price = str_replace(',','',$_POST['price'] ?? 0);
    $price = (int)$price;


    $sharh = trim($_POST['sharh'] ?? '');


    $installments = $_POST['installments'] ?? [];


    if(
        empty($installments)
        ||
        $bed<=0
        ||
        $bes<=0
        ||
        $price<=0
    ){

        echo json_encode([
            'res'=>'bad error',
            'message'=>'اطلاعات پرداخت کامل نیست'
        ]);

        exit;
    }


    try {

        $conn->beginTransaction();


        /*
         * ثبت سند روزنامه
         */

        $sql="
        INSERT INTO ruznameh
        (
            date,
            sharh,
            price,
            hesab_bed,
            hesab_bes
        )
        VALUES
        (
            :date,
            :sharh,
            :price,
            :bed,
            :bes
        )
        ";


        $stmt=$conn->prepare($sql);


        $stmt->execute([

            ':date'=>$tarikh,
            ':sharh'=>$sharh,
            ':price'=>$price,
            ':bed'=>$bed,
            ':bes'=>$bes

        ]);


        /*
         * بروزرسانی اقساط انتخاب شده
         */

        sort($installments);


        $sql="
        UPDATE vam_installments
        SET
            paid_amount = amount,
            status = 2
        WHERE id = :id
        ";


        $stmt=$conn->prepare($sql);


        foreach($installments as $id){

            $stmt->execute([
                ':id'=>(int)$id
            ]);

        }



        $conn->commit();


        $data=[
            'res'=>'registered'
        ];


    }catch(Exception $e){


        if($conn->inTransaction()){
            $conn->rollBack();
        }


        $data=[
            'res'=>'bad error',
            'message'=>$e->getMessage()
        ];

    }


    echo json_encode($data);

    exit;

}
/*
 * ==============================
 * ثبت سند چندتراکنشی
 * ==============================
 */
if (
    isset($_POST['c_multi_template'])
    && $_POST['c_multi_template'] === 'c_multi_template'
) {
    include "db.php";
    $data = array(
        'res' => 'bad error'
    );
    $templateId = (int)($_POST['template_id'] ?? 0);
    $tarikh = trim($_POST['tarikh'] ?? '');
    $tarikh = str_replace('/', '', $tarikh);
    $items = $_POST['items'] ?? array();
    /*
     * اعتبارسنجی اولیه
     */
    if (
        $templateId <= 0
        || $tarikh === ''
        || empty($items)
        || !is_array($items)
    ) {
        $data['message'] = 'اطلاعات سند کامل نیست.';
        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE
        );
        exit;
    }
    try {
        /*
         * دریافت ردیف‌های واقعی Template
         *
         * ساختار Template از دیتابیس خوانده می‌شود.
         */
        $stmt = $conn->prepare("
            SELECT
                id,
                template_id,
                sort_order,
                title,
                hesab_bed,
                hesab_bes,
                sharh,
                active
            FROM document_template_items
            WHERE template_id = :template_id
              AND active = 1
            ORDER BY sort_order ASC, id ASC
        ");
        $stmt->execute([
            ':template_id' => $templateId
        ]);
        $templateItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($templateItems)) {
            $data['message'] =
                'برای این الگو ردیفی ثبت نشده است.';
            echo json_encode(
                $data,
                JSON_UNESCAPED_UNICODE
            );
            exit;
        }
        /*
         * آماده‌سازی ردیف‌های قابل ثبت
         */
        $preparedItems = array();

        $totalBed = 0;
        $totalBes = 0;

        $skippedItems = array();

        foreach ($templateItems as $templateItem) {

            $itemId = (int)$templateItem['id'];

            /*
             * اگر ردیف از فرم ارسال نشده باشد،
             * یعنی احتمالاً توسط JavaScript به دلیل
             * مبلغ صفر از ارسال حذف شده است.
             *
             * بنابراین خطا نمی‌دهیم.
             */
            if (
                !isset($items[$itemId])
                || !is_array($items[$itemId])
            ) {
                $skippedItems[] = array(
                    'id' => $itemId,
                    'title' => $templateItem['title']
                );

                continue;
            }

            $item = $items[$itemId];

            /*
             * مبلغ
             */
            $price = $item['price'] ?? '';

            $price = str_replace(',', '', $price);
            $price = str_replace(' ', '', $price);
            $price = trim($price);

            /*
             * مبلغ عددی
             */
            $numericPrice = 0;

            if (
                $price !== ''
                && is_numeric($price)
            ) {
                $numericPrice = (int)$price;
            }

            /*
             * شرح فقط از فرم
             *
             * شرح Template اصلاً استفاده نمی‌شود.
             */
            $sharh = isset($item['sharh'])
                ? trim($item['sharh'])
                : '';

            /*
             * اگر مبلغ صفر یا خالی باشد:
             *
             * ردیف اصلاً ثبت نمی‌شود،
             * حتی اگر شرح داشته باشد.
             */
            if ($numericPrice <= 0) {

                $skippedItems[] = array(
                    'id' => $itemId,
                    'title' => $templateItem['title']
                );

                continue;
            }

            /*
             * حساب بدهکار
             */
            $hesabBed =
                (int)($item['hesab_bed'] ?? 0);

            /*
             * حساب بستانکار
             */
            $hesabBes =
                (int)($item['hesab_bes'] ?? 0);

            /*
             * حساب‌ها باید معتبر باشند.
             */
            if (
                $hesabBed <= 0
                || $hesabBes <= 0
            ) {
                throw new Exception(
                    'برای یکی از ردیف‌های قابل ثبت، حساب بدهکار یا بستانکار انتخاب نشده است.'
                );
            }

            /*
             * جمع سند
             */
            $totalBed += $numericPrice;
            $totalBes += $numericPrice;

            /*
             * آماده‌سازی INSERT
             */
            $preparedItems[] = array(
                'date' =>
                    $tarikh,

                'sharh' =>
                    $sharh,

                'price' =>
                    $numericPrice,

                'hesab_bed' =>
                    $hesabBed,

                'hesab_bes' =>
                    $hesabBes
            );
        }
        $conn->beginTransaction();
        $stmt = $conn->prepare("
            INSERT INTO ruznameh
            (
                date,
                sharh,
                price,
                hesab_bed,
                hesab_bes
            )
            VALUES
            (
                :date,
                :sharh,
                :price,
                :hesab_bed,
                :hesab_bes
            )
        ");
        foreach ($preparedItems as $item) {
            $stmt->execute([
                ':date' =>
                    $item['date'],
                ':sharh' =>
                    $item['sharh'],
                ':price' =>
                    $item['price'],
                ':hesab_bed' =>
                    $item['hesab_bed'],
                ':hesab_bes' =>
                    $item['hesab_bes']
            ]);
        }
        /*
 * هیچ ردیف قابل ثبت وجود ندارد.
 */
        if (empty($preparedItems)) {

            throw new Exception(
                'هیچ ردیفی با مبلغ بیشتر از صفر برای ثبت وجود ندارد.'
            );
        }

        /*
         * کنترل نهایی تراز
         */
        if ($totalBed !== $totalBes) {

            throw new Exception(
                'جمع بدهکار و بستانکار برابر نیست.'
            );
        }
        /*
         * همه ردیف‌ها موفق بودند.
         */
        $conn->commit();
        $data = array(
            'res' => 'registered',
            'message' => 'سند با موفقیت ثبت شد.'
        );
    } catch (Exception $e) {
        /*
         * اگر Transaction باز باشد،
         * همه تغییرات Rollback می‌شوند.
         */
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        $data = array(
            'res' => 'bad error',
            'message' => $e->getMessage()
        );
    }
    echo json_encode(
        $data,
        JSON_UNESCAPED_UNICODE
    );
    exit;
}

/*
 * ==============================
 * ثبت تراکنش‌های معمولی
 * این بخش را تغییر نمی‌دهیم.
 * ==============================
 */
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
    if(
        !empty($tarikh)
        && !empty($bes)
        && !empty($bed)
        && !empty($price)
        && !empty($bes) !==0
        && !empty($bed) !==0
    ){
        $sql = "
            INSERT INTO `ruznameh`
            (
                `date`,
                `sharh`,
                `price`,
                `hesab_bed`,
                `hesab_bes`
            )
            VALUES
            (
                :tarikh,
                :sharh,
                :price,
                :bed,
                :bes
            )
        ";
        $result = $conn->prepare($sql);
        if(
            $result->execute(array(
                "tarikh" => $tarikh,
                "sharh" => $sharh,
                "price" => $price,
                "bed" => $bed,
                "bes" => $bes,
            ))
        ){
            $data = array(
                'res'=>'registered'
            );
        }
    }else{
        $data = array(
            'res'=>'bad error'
        );
    }
    echo json_encode($data);
}
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
