<?php
include('jdf.php');
include( 'db.php' );
$pl = $_POST['st_is'];


					$target_dir1 = "../../uploads/".$pl;
					$target_dir = $target_dir1."/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}
    $fileName = $_FILES['file']['name'];
    $targetFile = $target_dir.jdate('Y-m-d-His','', '','', 'en').'---'.$fileName;
              if(move_uploaded_file($_FILES['file']['tmp_name'],$targetFile)){
		  echo "فایل ". basename( $_FILES["file"]["name"]). " با موفقیت بارگزاری شد.";

    }

?>

