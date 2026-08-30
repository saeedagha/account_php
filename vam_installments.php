<!-- Start Loan Installments Dashboard -->
<div class="row clearfix">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2>
                    وضعیت اقساط وام‌ها
                    <small style=" margin: 15px auto;">گزارش وضعیت پرداخت و قسط بعدی</small>
                    <span id="total-price2" style="font-weight:bold; color:teal;font-size: 15px;margin-right: 10px;"></span>
                </h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dashboard-task-infos">
                        <thead>
                        <tr>
                            <th>وام</th>
                            <th class="text-center">مبلغ قسط</th>
                            <th class="text-center">اقساط</th>
                            <th class="text-center">مبلغ پرداختی</th>
                            <th class="text-center">قسط بعدی</th>
                            <th class="text-center">کل مبلغ</th>
                            <th class="text-center">پیشرفت</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        global $conn;
                        $sql = "SELECT
    v.id AS vam_id,
    v.hesab_id,
    v.title,
    v.loan_amount,
    v.term_count,
    v.sort_order,
    COUNT(vi.id) AS total_installments,
    SUM(
        CASE
            WHEN vi.status = 2 THEN 1
            ELSE 0
        END
    ) AS paid_installments,
    SUM(vi.paid_amount) AS total_paid_amount,
    MIN(
        CASE
            WHEN vi.status <> 2 THEN vi.installment_no
            ELSE NULL
        END
    ) AS next_installment_no,
    MIN(
        CASE
            WHEN vi.status <> 2 THEN vi.due_date
            ELSE NULL
        END
    ) AS next_due_date,
    (
        SELECT amount
        FROM vam_installments vi_first
        WHERE vi_first.vam_id = v.id
        ORDER BY vi_first.installment_no ASC
        LIMIT 1
    ) AS installment_amount,
    (
        SELECT due_date
        FROM vam_installments vi_first
        WHERE vi_first.vam_id = v.id
        ORDER BY vi_first.installment_no ASC
        LIMIT 1
    ) AS first_due_date
FROM vams v
LEFT JOIN vam_installments vi
    ON vi.vam_id = v.id
WHERE v.status = 1
GROUP BY
    v.id,
    v.hesab_id,
    v.title,
    v.loan_amount,
    v.term_count,
    v.sort_order
ORDER BY v.sort_order ASC, v.id ASC";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($loans as $loan) {
                            $total = (int)$loan['total_installments'];
                            $paid  = (int)$loan['paid_installments'];
                            $totalPaidAmount = (float)$loan['total_paid_amount'];
                            $progress = $total > 0
                                ? floor(($paid / $total) * 100)
                                : 0;
                            /*
                             * روز پرداخت
                             */
                            $paymentDay = '-';
                            if (!empty($loan['first_due_date'])) {
                                $paymentDay = (int)substr(
                                    $loan['first_due_date'],
                                    -2
                                );
                            }
                            /*
                             * تاریخ قسط بعدی
                             */
                            $nextDueDate = '-';
                            if (!empty($loan['next_due_date'])) {
                                $date = (string)$loan['next_due_date'];
                                if (strlen($date) === 8) {
                                    $nextDueDate =
                                        substr($date, 0, 4) . '/' .
                                        substr($date, 4, 2) . '/' .
                                        substr($date, 6, 2);
                                }
                            }
                            /*
                             * آخرین شرح سند مرتبط با وام
                             */
                            $lastDescription = '';
                            $lastDescriptionSql = "
            SELECT sharh
            FROM ruznameh
            WHERE hesab_bed = :hesab_id
               OR hesab_bes = :hesab_id
            ORDER BY id DESC
            LIMIT 1
        ";
                            $lastDescriptionStmt = $conn->prepare($lastDescriptionSql);
                            $lastDescriptionStmt->execute([
                                ':hesab_id' => $loan['hesab_id']
                            ]);
                            $lastDescription = $lastDescriptionStmt->fetchColumn();
                            /*
                             * تعیین کلاس وضعیت ردیف
                             */
                            $rowClass = '';
                            if (empty($loan['next_installment_no'])) {
                                // وام تسویه شده
                                $rowClass = 'loan-paid';
                            } else {
                                $todayJalali = function_exists('jdate')
                                    ? jdate('Ymd')
                                    : '';
                                if (
                                    !empty($todayJalali) &&
                                    $loan['next_due_date'] < $todayJalali
                                ) {
                                    // قسط معوق
                                    $rowClass = 'loan-overdue';
                                } elseif (
                                    !empty($todayJalali) &&
                                    $loan['next_due_date'] == $todayJalali
                                ) {
                                    // سررسید امروز
                                    $rowClass = 'loan-due-today';
                                } else {
                                    // قسط آینده
                                    $rowClass = 'loan-pending';
                                }
                            }
                            ?>
                            <tr class="<?php echo $rowClass; ?>">
                                <!-- وام -->
                                <td>
                                    <a tabindex="-1"  href="<?php echo BASE_URL; ?>/ruznameh/view.php?view=<?php echo (int)$loan['hesab_id']; ?>"
                                            style="font-weight:bold;"
                                    >
                                        <?php
                                        echo htmlspecialchars(
                                            $loan['title'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                        ?>
                                    </a>
                                    <input
                                            type="text"
                                            class="price-input2 pull-left"
                                            onchange="javascript:this.value=separate(this.value);"
                                            onkeyup="updateTotal2()"
                                            style="
        border:none;
        text-align:left;
        width:120px;
        margin-top:5px;
    "
                                    >
                                    <?php if (!empty($lastDescription)): ?>

                                        <code
                                                style="
                                                line-height: 23px;
                            font-family: 'iransans', Tahoma, Arial !important;
                            font-size: 11px;
                        "
                                        >
                                            <?php
                                            echo htmlspecialchars(
                                                $lastDescription,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                            ?>
                                        </code>
                                    <?php endif; ?>



                                </td>
                                <!-- مبلغ قسط -->
                                <td class="text-center">
                                    <span class="label bg-green">
                                        <?php  echo number_format( (float)$loan['installment_amount']
                                        );
                                        ?>
                                          <small>
                                        (<?php echo $paymentDay; ?> هر ماه)
                                    </small>
                                    </span>
                                </td>
                                <!-- تعداد اقساط -->
                                <td class="text-center" style="

white-space: nowrap;">
                                    <span class="col-teal font-bold">
                                        <?php echo $paid; ?>
                                    </span>
                                    از
                                    <span class="col-blue-grey">
                                        <?php echo $total; ?>
                                    </span>
                                </td>
                                <!-- مبلغ پرداختی کل وام -->
                                <td class="text-center">
                                    <strong>
                                        <?php
                                        echo number_format($totalPaidAmount);
                                        ?>
                                    </strong>
                                </td>
                                <!-- قسط بعدی -->
                                <td class="text-center" style="

                                        white-space: nowrap;>
                                    <?php if (!empty($loan['next_installment_no'])): ?>
                                        <?php
                                        $jalaliMonths = [
                                            '01' => 'فروردین',
                                            '02' => 'اردیبهشت',
                                            '03' => 'خرداد',
                                            '04' => 'تیر',
                                            '05' => 'مرداد',
                                            '06' => 'شهریور',
                                            '07' => 'مهر',
                                            '08' => 'آبان',
                                            '09' => 'آذر',
                                            '10' => 'دی',
                                            '11' => 'بهمن',
                                            '12' => 'اسفند'
                                        ];
                                        $nextDate = (string) $loan['next_due_date'];
                                        $nextYear  = substr($nextDate, 0, 4);
                                        $nextMonth = substr($nextDate, 4, 2);
                                        $nextDueText = $jalaliMonths[$nextMonth] . ' ' . $nextYear;
                                        ?>
                                        <?php echo $nextDueText; ?>
                                    <?php else: ?>
                                        <span class="label bg-green">تسویه شده</span>
                                    <?php endif; ?>
                                </td>
<td>  <?php
    echo number_format($loan['loan_amount']);
    ?></td>
                                <!-- پیشرفت -->
                                <td
                                        class="text-center"
                                        title="<?php echo $paid . ' از ' . $total; ?>"
                                        style="min-width:150px;"
                                >
                                    <div style="font-weight:bold;">
                                        <?php echo $progress; ?>%
                                       <span class="col-teal font-bold" style="font-weight: normal; font-size: 10px;">
                                       ( <?php echo $paid; ?>
                                    </span>
                                        از
                                        <span class="col-blue-grey" style="font-weight: normal; font-size: 10px;">
                                        <?php echo $total; ?> )
                                    </span>
                                    </div>
                                    <div
                                            class="progress"
                                            style="
                        margin-top:5px;
                        margin-bottom:0;
                    "
                                    >
                                        <div
                                                class="progress-bar bg-green"
                                                role="progressbar"
                                                style="width: <?php echo $progress; ?>%;"
                                                aria-valuenow="<?php echo $progress; ?>"
                                                aria-valuemin="0"
                                                aria-valuemax="100"
                                        ></div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Loan Installments Dashboard -->