<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include('jdf.php');
// -------------------- تنظیمات --------------------
$host = "localhost";
$username = "saeedmir_ranked0463";
$password = "Gm7Jf1YR!wEI^Fr%OG^^!uXcMV@RfJid";
$database_name = "saeedmir_blighted4851";

// مسیر و نام فایل بکاپ
$backup_file_name = $database_name . '_backup_' . jdate("Y-m-d_H-i-s") . '.sql';

// لیست جداولی که نباید بکاپ گرفته شوند
//$exclude_tables = ['logs', 'sessions', 'tmp_data']; 
$exclude_tables = []; 
// تنظیمات ایمیل
$mail_host      = 'mail.saeedmirzaei.ir';
$mail_username  = 'bc@saeedmirzaei.ir';
$mail_password  = '9fSB.Dfz(6!_';
$mail_port      = 587;
$mail_from      = 'bc@saeedmirzaei.ir';
$mail_from_name = 'Backup Data';  //Backup Data
$mail_recipients = [
    ['email' => 'saeed.fadafan@yahoo.com', 'name' => 'Saeed Mirzaei'],
    ['email' => 'yes.saeed.fadafan@gmail.com', 'name' => '']
];
// -------------------- پایان تنظیمات --------------------


// اتصال به دیتابیس
$conn = mysqli_connect($host, $username, $password, $database_name);
$conn->set_charset("utf8");

// گرفتن لیست جدول‌ها
$tables = [];
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    if (!in_array($row[0], $exclude_tables)) {
        $tables[] = $row[0];
    }
}

// ساخت اسکریپت SQL
$sqlScript = "SET FOREIGN_KEY_CHECKS=0;\n\n";
foreach ($tables as $table) {
    // ساختار جدول
    $result = mysqli_query($conn, "SHOW CREATE TABLE $table");
    $row = mysqli_fetch_row($result);
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";

    // داده‌ها
    $result = mysqli_query($conn, "SELECT * FROM $table");
    $columnCount = mysqli_num_fields($result);

    while ($row = mysqli_fetch_row($result)) {
        $sqlScript .= "INSERT INTO $table VALUES(";
        for ($j = 0; $j < $columnCount; $j++) {
            $row[$j] = mysqli_real_escape_string($conn, $row[$j]);
            $sqlScript .= isset($row[$j]) ? '"' . $row[$j] . '"' : 'NULL';
            if ($j < ($columnCount - 1)) {
                $sqlScript .= ',';
            }
        }
        $sqlScript .= ");\n";
    }
    $sqlScript .= "\n";
}
$sqlScript .= "SET FOREIGN_KEY_CHECKS=1;\n";

// ذخیره فایل
file_put_contents($backup_file_name, $sqlScript);

// دانلود مستقیم
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($backup_file_name));
readfile($backup_file_name);

// ارسال ایمیل
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

$mail = new PHPMailer(true);
$mail->CharSet = "UTF-8";
$mail->isSMTP();
$mail->Host       = $mail_host;
$mail->SMTPAuth   = true;
$mail->Username   = $mail_username;
$mail->Password   = $mail_password;
$mail->SMTPSecure = 'tls';
$mail->Port       = $mail_port;

$mail->setFrom($mail_from, $mail_from_name);
foreach ($mail_recipients as $recipient) {
    $mail->addAddress($recipient['email'], $recipient['name']);
}
$mail->addReplyTo($mail_from, 'Information');

$mail->addAttachment($backup_file_name);

 $date = jdate('l, j F , Y | ساعت : H:i:s' ,'','','','en');
$mail->isHTML(true);
$mail->Subject = $date;
$mail->Body    = "پشتیبان گیری با موفقیت انجام شد.<br>{$date}";
$mail->AltBody = "پشتیبان گیری تکمیل شد - {$date}";

$mail->send();

// پاک کردن فایل
unlink($backup_file_name);
?>