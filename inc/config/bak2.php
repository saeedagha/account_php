<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/*
require_once 'inc/config/autoload.php';
require_once ('inc/config/load.php');
global $conn; */
include('jdf.php');
// Database configuration
$host = "localhost";
$username = "saeedmir_ranked0463";
$password = "Gm7Jf1YR!wEI^Fr%OG^^!uXcMV@RfJid";
$database_name = "saeedmir_blighted4851";

// Get connection object and set the charset
$conn = mysqli_connect($host, $username, $password, $database_name);
$conn->set_charset("utf8");

// Get All Table Names From the Database
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}
$sqlScript = "";
foreach ($tables as $table) {
    // Prepare SQLscript for creating table structure
    $query = "SHOW CREATE TABLE $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    $columnCount = mysqli_num_fields($result);
    // Prepare SQLscript for dumping data for each table
    for ($i = 0; $i < $columnCount; $i ++) {
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j ++) {
                $row[$j] = $row[$j];

                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }

    $sqlScript .= "\n";
}
if(!empty($sqlScript))
{
    // Save the SQL script to a backup file
    $backup_file_name = $database_name . '_backup_' .  jdate("y-m-d" ,'','','','en') . '.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler);
    // Download the SQL backup file to the browser
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file_name));
    ob_clean();
    flush();
    readfile($backup_file_name);
    exec('rm ' . $backup_file_name);


    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';
    $mail = new PHPMailer;
    $mail->CharSet = "UTF-8";
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'mail.saeedmirzaei.ir';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'bc@saeedmirzaei.ir';                     // SMTP username
    $mail->Password   = '9fSB.Dfz(6!_';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, ssl also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('bc@saeedmirzaei.ir ', 'Backup Data');
    $mail->addAddress('saeed.fadafan@yahoo.com', 'Saeed Mirzaei');     // Add a recipient
   $mail->addAddress('yes.saeed.fadafan@gmail.com');               // Name is optional
   
    $mail->addReplyTo('bc@saeedmirzaei.ir', 'Information');
  $mail->addCC('yes.saeed.fadafan@gmail.com');
    //  $mail->addBCC('bcc@example.com');

    // Attachments
    $mail->addAttachment($backup_file_name);         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $date = jdate('l, j F , Y | ساعت : H:i:s' ,'','','','en');
    $mail->Subject = $date;
    $mail->Body    = 'پشتیبان گیری با موفقیت انجام شد</br>'.$date;
    $mail->AltBody =  'پشتیبان گیری تکمیل شد'.$date;

    $mail->send();
    echo 'Message has been sent';
  unlink($backup_file_name);
}
?>