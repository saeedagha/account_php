<?php

$sandugh = sub_sandugh();
$sub_ashkhas = sub_ashkhas();
$sub_income = sub_income();
$sub_vam = sub_vam();
$sub_cost = sub_cost();

/*
 * همان ساختاری که صفحه ویرایش تراکنش
 * برای نمایش تمام حساب‌ها استفاده می‌کند.
 */
$document_template_all_accounts =
    $sandugh
    + $sub_income
    + $sub_cost
    + $sub_vam
    + $sub_ashkhas;

/*
 * مدیریت ردیف‌های Template چندتراکنشی
 *
 * این فایل از داخل setting.php فراخوانی می‌شود.
 * مبلغ پیش‌فرض در Template ذخیره می‌شود،
 * ولی هنگام ثبت سند کاربر می‌تواند آن را تغییر دهد.
 */


/*
 * Template انتخاب‌شده
 */
$document_template_items_template_id = isset($_GET['template_items'])
    ? (int)$_GET['template_items']
    : 0;


/*
 * متغیرهای اولیه
 */
$document_template_item_template = null;
$document_template_items = array();


/*
 * دریافت همه حساب‌های قابل انتخاب
 *
 * برای Template چندتراکنشی عمداً هیچ فیلتری
 * بر اساس cost / income / loan_payment / transfer
 * اعمال نمی‌کنیم.
 */

/*
 * پردازش افزودن ردیف
 */
if (
    isset($_POST['save_document_template_item'])
    && isset($_POST['template_id'])
) {

    $template_id = (int)($_POST['template_id'] ?? 0);

    $title = trim(
        $_POST['item_title'] ?? ''
    );

    $operation_type = trim(
        $_POST['item_operation_type'] ?? ''
    );

    $hesab_bed = (int)(
        $_POST['item_hesab_bed'] ?? 0
    );

    $hesab_bes = (int)(
        $_POST['item_hesab_bes'] ?? 0
    );

    $sharh = trim(
        $_POST['item_sharh'] ?? ''
    );

    $default_amount = trim(
        $_POST['item_default_amount'] ?? ''
    );

    $sort_order = (int)(
        $_POST['item_sort_order'] ?? 0
    );


    /*
     * نوع عملیات‌های مجاز
     */
    $allowed_operation_types = array(
        'cost',
        'income',
        'loan_payment',
        'transfer'
    );


    /*
     * اعتبارسنجی
     */
    if (
        $template_id <= 0
        || $title === ''
        || !in_array(
            $operation_type,
            $allowed_operation_types,
            true
        )
        || $hesab_bed <= 0
        || $hesab_bes <= 0
    ) {

        echo '
        <div class="alert alert-danger">
            اطلاعات ردیف کامل نیست.
        </div>';

    } else {

        try {

            /*
             * بررسی وجود Template
             */
            $stmt = $conn->prepare("
                SELECT id
                FROM document_templates
                WHERE id = :id
                LIMIT 1
            ");

            $stmt->execute([
                ':id' => $template_id
            ]);

            $template_exists = $stmt->fetchColumn();


            if (!$template_exists) {

                echo '
                <div class="alert alert-danger">
                    الگوی انتخاب‌شده وجود ندارد.
                </div>';

            } else {

                /*
                 * مبلغ پیش‌فرض
                 *
                 * جداکننده‌های عددی حذف می‌شوند.
                 */
                if ($default_amount !== '') {

                    $default_amount = str_replace(
                        ',',
                        '',
                        $default_amount
                    );

                    $default_amount = str_replace(
                        ' ',
                        '',
                        $default_amount
                    );

                    /*
                     * فقط عدد ذخیره شود.
                     */
                    $default_amount = (float)$default_amount;

                } else {

                    $default_amount = null;

                }


                /*
                 * اگر ترتیب وارد نشده باشد،
                 * آخرین ردیف + 1
                 */
                if ($sort_order <= 0) {

                    $stmt = $conn->prepare("
                        SELECT
                            COALESCE(
                                MAX(sort_order),
                                0
                            ) + 1
                        FROM document_template_items
                        WHERE template_id = :template_id
                    ");

                    $stmt->execute([
                        ':template_id' => $template_id
                    ]);

                    $sort_order = (int)$stmt->fetchColumn();

                }


                /*
                 * ثبت ردیف
                 */
                $stmt = $conn->prepare("
                    INSERT INTO document_template_items
                    (
                        template_id,
                        sort_order,
                        title,
                        operation_type,
                        hesab_bed,
                        hesab_bes,
                        sharh,
                        default_amount,
                        active
                    )
                    VALUES
                    (
                        :template_id,
                        :sort_order,
                        :title,
                        :operation_type,
                        :hesab_bed,
                        :hesab_bes,
                        :sharh,
                        :default_amount,
                        1
                    )
                ");

                $stmt->execute([
                    ':template_id' => $template_id,
                    ':sort_order' => $sort_order,
                    ':title' => $title,
                    ':operation_type' => $operation_type,
                    ':hesab_bed' => $hesab_bed,
                    ':hesab_bes' => $hesab_bes,
                    ':sharh' => $sharh !== ''
                        ? $sharh
                        : null,
                    ':default_amount' => $default_amount
                ]);


                /*
                 * بازگشت به همان Template
                 */
                header(
                    'Location: setting.php?template_items='
                    . $template_id
                );

                exit;
            }

        } catch (Exception $e) {

            echo '
            <div class="alert alert-danger">
                خطا در ثبت ردیف.
            </div>';

        }
    }
}


/*
 * دریافت اطلاعات Template انتخاب‌شده
 */
if ($document_template_items_template_id > 0) {

    $stmt = $conn->prepare("
        SELECT
            id,
            name,
            operation_type,
            active
        FROM document_templates
        WHERE id = :id
        LIMIT 1
    ");

    $stmt->execute([
        ':id' => $document_template_items_template_id
    ]);

    $document_template_item_template = $stmt->fetch(
        PDO::FETCH_ASSOC
    );


    /*
     * دریافت ردیف‌های Template
     */
    if ($document_template_item_template) {

        $stmt = $conn->prepare("
            SELECT
                id,
                template_id,
                sort_order,
                title,
                operation_type,
                hesab_bed,
                hesab_bes,
                sharh,
                default_amount,
                active,
                created_at,
                updated_at
            FROM document_template_items
            WHERE template_id = :template_id
            ORDER BY sort_order ASC, id ASC
        ");

        $stmt->execute([
            ':template_id' =>
                $document_template_items_template_id
        ]);

        $document_template_items = $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

    }

}
?>
<?php if (
    !empty($document_template_item_template)
) { ?>
    <div class="row clearfix">
        <div class="col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ردیف‌های الگو:
                        <?php echo htmlspecialchars(
                            $document_template_item_template['name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </h2>
                </div>
                <div class="body">
                    <?php if (!empty($document_template_items)) { ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        ترتیب
                                    </th>
                                    <th>
                                        عنوان
                                    </th>
                                    <th>
                                        نوع عملیات
                                    </th>
                                    <th>
                                        حساب بدهکار
                                    </th>
                                    <th>
                                        حساب بستانکار
                                    </th>
                                    <th>
                                        شرح
                                    </th>
                                    <th>
                                        مبلغ پیش‌فرض
                                    </th>
                                    <th>
                                        وضعیت
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach (
                                    $document_template_items
                                    as $item
                                ) { ?>
                                    <tr>
                                        <td>
                                            <?php echo (int)$item['sort_order']; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars(
                                                $item['title'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch (
                                            $item['operation_type']
                                            ) {
                                                case 'cost':
                                                    echo 'هزینه';
                                                    break;
                                                case 'income':
                                                    echo 'درآمد';
                                                    break;
                                                case 'loan_payment':
                                                    echo 'پرداخت قسط';
                                                    break;
                                                case 'transfer':
                                                    echo 'انتقال وجه';
                                                    break;
                                                default:
                                                    echo htmlspecialchars(
                                                        $item['operation_type'],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars(
                                                gethesabname(
                                                    (int)$item['hesab_bed']
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars(
                                                gethesabname(
                                                    (int)$item['hesab_bes']
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars(
                                                $item['sharh'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (
                                                $item['default_amount']
                                                !== null
                                            ) {
                                                echo number_format(
                                                    (float)$item[
                                                    'default_amount'
                                                    ]
                                                );
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (
                                                (int)$item['active'] === 1
                                            ) { ?>
                                                <span class="label bg-teal">
فعال
</span>
                                            <?php } else { ?>
                                                <span class="label bg-grey">
غیرفعال
</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-info">
                            هنوز ردیفی برای این الگو تعریف نشده است.
                        </div>
                    <?php } ?>
                    <?php if (!empty($document_template_item_template)) { ?>
                        <div class="row clearfix">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="header">
                                        <h2>
                                            افزودن ردیف به الگو
                                        </h2>
                                    </div>
                                    <div class="body">
                                        <form method="post">
                                            <input
                                                type="hidden"
                                                name="template_id"
                                                value="<?php echo (int)$document_template_item_template['id']; ?>"
                                            >
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            عنوان ردیف
                                                        </label>
                                                        <div class="form-line">
                                                            <input
                                                                type="text"
                                                                name="item_title"
                                                                class="form-control"
                                                                required
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            نوع عملیات
                                                        </label>
                                                        <select
                                                            name="item_operation_type"
                                                            id="item_operation_type"
                                                            class="form-control show-tick"
                                                            required
                                                        >
                                                            <option value="">
                                                                انتخاب نوع عملیات
                                                            </option>
                                                            <option value="cost">
                                                                هزینه
                                                            </option>
                                                            <option value="income">
                                                                درآمد
                                                            </option>
                                                            <option value="loan_payment">
                                                                پرداخت قسط
                                                            </option>
                                                            <option value="transfer">
                                                                انتقال وجه
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            حساب بدهکار
                                                        </label>
                                                        <select
                                                            name="item_hesab_bed"
                                                            id="item_hesab_bed"
                                                            class="form-control show-tick"
                                                            data-live-search="true"
                                                            required
                                                        >
                                                            <?php foreach ($document_template_all_accounts as $key => $value) { ?>

                                                                <?php if (is_array($value)) { ?>

                                                                    <optgroup
                                                                        label="<?php echo htmlspecialchars(
                                                                            gethesabname($key),
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ); ?>">

                                                                        <?php foreach ($value as $id => $name) { ?>

                                                                            <option value="<?php echo (int)$id; ?>">
                                                                                <?php echo htmlspecialchars(
                                                                                    $name,
                                                                                    ENT_QUOTES,
                                                                                    'UTF-8'
                                                                                ); ?>
                                                                            </option>

                                                                        <?php } ?>

                                                                    </optgroup>

                                                                <?php } else { ?>

                                                                    <option value="<?php echo (int)$key; ?>">
                                                                        <?php echo htmlspecialchars(
                                                                            $value,
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ); ?>
                                                                    </option>

                                                                <?php } ?>

                                                            <?php } ?>    </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            حساب بستانکار
                                                        </label>
                                                        <select
                                                            name="item_hesab_bes"
                                                            id="item_hesab_bes"
                                                            class="form-control show-tick"
                                                            data-live-search="true"
                                                            required
                                                        >
                                                            <?php foreach ($document_template_all_accounts as $key => $value) { ?>

                                                                <?php if (is_array($value)) { ?>

                                                                    <optgroup
                                                                        label="<?php echo htmlspecialchars(
                                                                            gethesabname($key),
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ); ?>">

                                                                        <?php foreach ($value as $id => $name) { ?>

                                                                            <option value="<?php echo (int)$id; ?>">
                                                                                <?php echo htmlspecialchars(
                                                                                    $name,
                                                                                    ENT_QUOTES,
                                                                                    'UTF-8'
                                                                                ); ?>
                                                                            </option>

                                                                        <?php } ?>

                                                                    </optgroup>

                                                                <?php } else { ?>

                                                                    <option value="<?php echo (int)$key; ?>">
                                                                        <?php echo htmlspecialchars(
                                                                            $value,
                                                                            ENT_QUOTES,
                                                                            'UTF-8'
                                                                        ); ?>
                                                                    </option>

                                                                <?php } ?>

                                                            <?php } ?> </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            مبلغ پیش‌فرض
                                                        </label>
                                                        <div class="form-line">
                                                            <input
                                                                type="text"
                                                                name="item_default_amount"
                                                                class="form-control"
                                                                placeholder="مبلغ به ریال"
                                                                onkeyup="this.value=separate(this.value);"
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            ترتیب
                                                        </label>
                                                        <div class="form-line">
                                                            <input
                                                                type="number"
                                                                name="item_sort_order"
                                                                class="form-control"
                                                                min="1"
                                                                value="<?php
                                                                echo count(
                                                                        $document_template_items
                                                                    ) + 1;
                                                                ?>"
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>
                                                            شرح
                                                        </label>
                                                        <div class="form-line">
<textarea
    name="item_sharh"
    class="form-control"
    rows="3"
></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-left">
                                                <button
                                                    type="submit"
                                                    name="save_document_template_item"
                                                    class="btn btn-primary waves-effect"
                                                >
                                                    <i class="material-icons">
                                                        add
                                                    </i>
                                                    افزودن ردیف
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="text-left">
                        <a
                            href="setting.php"
                            class="btn btn-default waves-effect">
                            بازگشت
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


