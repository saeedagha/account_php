<?php

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


	$templateId =
		(int)($_POST['template_id'] ?? 0);


	$tarikh =
		trim($_POST['tarikh'] ?? '');

	$tarikh =
		str_replace('/', '', $tarikh);


	$items =
		$_POST['items'] ?? array();


	/*
     * اعتبارسنجی اولیه
     */
	if (
		$templateId <= 0
		|| $tarikh === ''
		|| empty($items)
	) {

		$data['message'] =
			'اطلاعات سند کامل نیست.';

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
         * حساب‌ها از دیتابیس خوانده می‌شوند
         * و به اطلاعات ارسال‌شده از مرورگر اعتماد نمی‌کنیم.
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
			':template_id' =>
				$templateId
		]);


		$templateItems =
			$stmt->fetchAll(
				PDO::FETCH_ASSOC
			);


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
         * تعداد ردیف‌های ارسالی
         * باید دقیقاً با Template برابر باشد.
         */
		if (
			count($items)
			!== count($templateItems)
		) {

			$data['message'] =
				'تعداد ردیف‌های ارسال‌شده با الگو مطابقت ندارد.';

			echo json_encode(
				$data,
				JSON_UNESCAPED_UNICODE
			);

			exit;
		}


		/*
         * آماده‌سازی اطلاعات
         */
		$preparedItems = array();

		$totalBed = 0;
		$totalBes = 0;


		foreach ($templateItems as $templateItem) {

			$itemId =
				(int)$templateItem['id'];


			if (
				!isset($items[$itemId])
				|| !is_array($items[$itemId])
			) {

				throw new Exception(
					'یکی از ردیف‌های الگو ارسال نشده است.'
				);
			}


			$price =
				$items[$itemId]['price'] ?? '';


			/*
             * حذف جداکننده مبلغ
             */
			$price =
				str_replace(',', '', $price);

			$price =
				str_replace(' ', '', $price);


			if (
				$price === ''
				|| !is_numeric($price)
			) {

				throw new Exception(
					'مبلغ یکی از ردیف‌ها معتبر نیست.'
				);
			}


			$price =
				(int)$price;


			if ($price <= 0) {

				throw new Exception(
					'مبلغ همه ردیف‌ها باید بیشتر از صفر باشد.'
				);
			}


			/*
             * شرح:
             *
             * اگر کاربر شرح را تغییر داده باشد
             * همان ذخیره می‌شود.
             *
             * در غیر این صورت شرح Template.
             */
			$sharh =
				isset(
					$items[$itemId]['sharh']
				)
					? trim(
					$items[$itemId]['sharh']
				)
					: '';


			if ($sharh === '') {

				$sharh =
					$templateItem['sharh'] ?? '';

			}


			$hesabBed =
				(int)$templateItem['hesab_bed'];

			$hesabBes =
				(int)$templateItem['hesab_bes'];


			if (
				$hesabBed <= 0
				|| $hesabBes <= 0
			) {

				throw new Exception(
					'یکی از حساب‌های الگو معتبر نیست.'
				);
			}


			/*
             * چون هر ردیف یک ثبت دوطرفه است:
             *
             * مبلغ بدهکار = مبلغ بستانکار
             */
			$totalBed += $price;
			$totalBes += $price;


			$preparedItems[] = array(

				'date' =>
					$tarikh,

				'sharh' =>
					$sharh,

				'price' =>
					$price,

				'hesab_bed' =>
					$hesabBed,

				'hesab_bes' =>
					$hesabBes

			);

		}


		/*
         * کنترل نهایی تراز
         *
         * حتی اگر JavaScript دستکاری شده باشد،
         * سرور اجازه ثبت سند نامتوازن نمی‌دهد.
         */
		if ($totalBed !== $totalBes) {

			throw new Exception(
				'جمع بدهکار و بستانکار برابر نیست.'
			);
		}


		/*
         * همه ردیف‌ها باید با هم ثبت شوند.
         *
         * اگر حتی یکی از INSERTها خطا کند،
         * هیچ‌کدام ثبت نخواهند شد.
         */
		$conn->beginTransaction();


		$stmt =
			$conn->prepare("
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
         * همه INSERTها موفق بودند.
         */
		$conn->commit();


		$data = array(
			'res' =>
				'registered'
		);


	} catch (Exception $e) {


		/*
         * اگر transaction باز باشد،
         * همه تغییرات برگردانده می‌شوند.
         */
		if (
			$conn->inTransaction()
		) {

			$conn->rollBack();

		}


		$data = array(

			'res' =>
				'bad error',

			'message' =>
				$e->getMessage()

		);

	}


	echo json_encode(
		$data,
		JSON_UNESCAPED_UNICODE
	);


	exit;
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
