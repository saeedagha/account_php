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