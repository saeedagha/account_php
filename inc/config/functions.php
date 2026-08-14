<?php
function get_document_templates($operation_type)
{
    global $conn;

    try {
        $sql = "
SELECT
`id`,
`name`,
`operation_type`,
`hesab_bed`,
`hesab_bes`,
`sharh`
FROM `document_templates`
WHERE `operation_type` = :operation_type
AND `active` = 1
ORDER BY `name` ASC
";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':operation_type' => $operation_type
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        return array();
    }
}
function get_document_template($id)
{
    global $conn;

    $id = (int) $id;

    if ($id <= 0) {
        return false;
    }

    try {
        $sql = "
            SELECT
                `id`,
                `name`,
                `operation_type`,
                `hesab_bed`,
                `hesab_bes`,
                `sharh`
            FROM `document_templates`
            WHERE `id` = :id
              AND `active` = 1
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: false;

    } catch (Exception $e) {
        return false;
    }
}
function get_all_hesab_options()
{
    global $conn;

    try {
        $sql = "
            SELECT `id`, `h_name`, `kol_id`, `moein_id`, `tafsili_id`
            FROM `hesabha`
            WHERE `selectable` = 1
            ORDER BY `id` ASC
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $accounts = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accounts[$row['id']] = $row;
        }

        return $accounts;

    } catch (Exception $e) {
        return array();
    }
}
function get_document_template_accounts($operationType, $side)
{
    $operationType = (string)$operationType;
    $side = (string)$side;

    /*
     * هزینه:
     * بدهکار = هزینه
     * بستانکار = صندوق
     */
    if ($operationType === 'cost') {

        if ($side === 'bed') {
            return list_sub_costs();
        }

        if ($side === 'bes') {
            return sub_sandugh();
        }
    }

    /*
     * درآمد:
     * بدهکار = صندوق
     * بستانکار = درآمد
     */
    if ($operationType === 'income') {

        if ($side === 'bed') {
            return sub_sandugh();
        }

        if ($side === 'bes') {
            return sub_income();
        }
    }

    /*
     * انتقال وجه:
     * هر دو طرف از حساب‌های قابل انتخاب استفاده می‌کنند.
     */
    if ($operationType === 'transfer') {

        return get_all_hesab_options();
    }

    return array();
}
function get_document_template_account_options($accounts)
{
    global $conn;

    $result = array();
    $parentIds = array();

    foreach ($accounts as $key => $value) {
        if (is_array($value)) {
            $parentIds[] = (int)$key;
        }
    }

    $parentIds = array_values(array_unique($parentIds));

    $parentNames = array();

    if (!empty($parentIds)) {

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
            $parentNames[(int)$row['id']] = $row['h_name'];
        }
    }

    foreach ($accounts as $key => $value) {

        if (is_array($value)) {

            $result[] = array(
                'type' => 'group',
                'id' => (int)$key,
                'name' => $parentNames[(int)$key] ?? '',
                'items' => $value
            );

        } else {

            $result[] = array(
                'type' => 'option',
                'id' => (int)$key,
                'name' => $value
            );
        }
    }

    return $result;
}