<?php
$titlepage = "ویرایش تراکنش";
require_once '../inc/config/autoload.php';
require(get_path('header.php'));
require_once '../inc/config/db.php';
    $sandugh = sub_sandugh();
    $sub_ashkhas = sub_ashkhas();
    $sub_income = sub_income();
    $sub_vam = sub_vam();
    $sub_cost = sub_cost();
    $hesabha=array();
    //$hesabha = array_merge($sandugh, $sub_income, $sub_cost,$sub_vam, $sub_ashkhas);
    $hesabha = $sandugh+ $sub_income+ $sub_cost+$sub_vam+ $sub_ashkhas;

if(isset($_POST['edit_ruz'])) {
    $error=array();
    $id =(int) addslashes(htmlentities($_POST['id_lm']));
    $hesab_bed = addslashes(htmlentities($_POST['hesab_bed']));
    $hesab_bes =addslashes(htmlentities($_POST['hesab_bes']));
    $tarikh = addslashes(htmlentities($_POST["tarikh"]));
    $tarikh = str_replace("/", "",$tarikh );
    $price = addslashes(htmlentities($_POST["price"]));
   $price = str_replace(",", "",$price );
    $sharh = addslashes(htmlentities($_POST["sharh"]));
    if(!empty($tarikh) && !empty($hesab_bed) && !empty($hesab_bes) && !empty($price) && !empty($hesab_bed) !==0 && !empty($hesab_bes) !==0){
    $sql = "UPDATE `ruznameh`  SET `date`= :tarikh, `sharh`= :sharh,  `price`= :price, `hesab_bed`= :hesab_bed, `hesab_bes`= :hesab_bes WHERE `id` = $id ";
    echo $sql;
    $result = $conn->prepare($sql);
    if($result->execute(array(
        "tarikh" => $tarikh,
        "sharh" => $sharh,
        "price" => $price,
        "hesab_bed" => $hesab_bed,
        "hesab_bes" => $hesab_bes

    ))) {
        $error['color'] = 'teal';
        $error['message'] =' حساب  '.$h_name.' با موفقیت ویرایش شد ';
    }else{
        $error['color'] = 'pink';
        $error['message'] ='مشکلی در ویرایش تراکنش به وجود آمد لطفا صفحه را مجدد بارگزاری کنید و یا در ورود مقادیر دقت نمایید';
    }


}else{
        $error['color'] = 'pink';
        $error['message'] ='مشکلی در ورود مقادیر یرای ویرایش تراکنش پیش آمد';
    }

}
ob_start();
if(isset($_GET['edit']) ) {
//session_start();
    $_SESSION['idss'] = addslashes(htmlentities($_GET["edit"]));


    $edit = (int)addslashes(htmlentities($_GET["edit"]));
    if (!empty($edit) && isset($edit)) {
        $sql = "SELECT * FROM ";
        $sql .= "`ruznameh` WHERE ";
        $sql .= "`id` = $edit";

        $stm = $conn->prepare($sql);
        $stm->execute();

        $row=  $stm->fetch(PDO::FETCH_ASSOC);
    }
}

?>

<section class="content">
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header clearfix">
                            <h2  style="line-height: 44px;">ویرایش تراکنش</h2>
                        </div>


                        <div class="body container farsi_g">
                            <div class="row">



                                <form class="clearfix" id="upl_ruz" action="" method="post">
                                    <div class="row">
                                    <div class="col-sm-3 col-xs-12">

                                        <div class="form-group form-float">
                                            <div class="form-line input-group">
                                                <label class="form-label" for="tarikh">تاریخ</label>
                                                <input type="text" id="tarikh" name="tarikh" class="form-control fc-datepicker datep" placeholder="MM/DD/YYYY" value="<?php echo date_sep($row['date']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-12">

                                        <div class="form-group form-float">
                                            <div class="form-line input-group">
                                                <label class="form-label" for="hesab_bed">بدهکار</label>
                                                <select class="form-control show-tick" name="hesab_bed" data-live-search="true">
                                                   <option value="0" selected>--حساب بدهکار را انتخاب نمایید--</option>
                                                    <?php
                                                    foreach ($hesabha as $key =>$value){
                                                        if(is_array($value)){
                                                            echo '<optgroup label="'.gethesabname($key).'">';
                                                            foreach ($value as $keys=>$values) {
                                                                if($row['hesab_bed'] == $keys){
                                                                    $select = " selected";
                                                                }else{
                                                                    $select = "";
                                                                }
                                                                echo '<option value="'.$keys.'" '.$select.' data-tokens="'.gethesabname($key).'">'.$values.'</option>';
                                                            }
                                                            echo '</optgroup>';
                                                        }else {
                                                            if($row['hesab_bed'] == $key){
                                                                $select = " selected";
                                                            }else{
                                                                $select = "";
                                                            }
                                                            echo '<option value="'.$key.'" '.$select.' >'.$value.'</option>';
                                                        }
                                                       }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                   </div>
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="form-group form-float">
                                            <div class="form-line input-group">
                                                <label class="form-label" for="hesab_bes">حساب بستانکار</label>
                                                <select class="form-control show-tick" id="hesab_bes" name="hesab_bes" data-live-search="true">
                                                    <option value="0" selected>--حساب بستانکار را انتخاب نمایید--</option>

                                                    <?php
                                                    foreach ($hesabha as $key =>$value){
                                                        if(is_array($value)){
                                                            echo '<optgroup label="'.gethesabname($key).'">';
                                                            foreach ($value as $keys=>$values) {
                                                                if($row['hesab_bes'] == $keys){
                                                                    $select = " selected";
                                                                }else{
                                                                    $select = "";
                                                                }
                                                                echo '<option value="'.$keys.'" '.$select.' data-tokens="'.gethesabname($key).'">'.$values.'</option>';
                                                            }
                                                            echo '</optgroup>';
                                                        }else {
                                                            if($row['hesab_bes'] == $key){
                                                                $select = " selected";
                                                            }else{
                                                                $select = "";
                                                            }
                                                            echo '<option value="'.$key.'" '.$select.' >'.$value.'</option>';
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-12">

                                        <div class="form-group form-float">


                                            <div class="form-line input-group">
                                                <label class="form-label" for="price">مبلغ </label>

                                                    <input type="text" class="form-control" id="price" name="price" aria-label="مبلغ به ریال" value="<?php echo   number_format($row['price']); ?>"  onkeyup="javascript:this.value=separate(this.value);">

                                                <span class="input-group-addon">ریال</span>
                                            </div>



                                            </div>
                                        </div>
                                    </div>
                            </div>
                                    <div class="row">
                                   <div class="col-sm-3 col-xs-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label class="form-label" for="sharh">توضیحات</label>
                                                    <input  id="sharh" class="form-control" name="sharh" value="<?php echo $row['sharh']; ?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="edit_ruz" name="edit_ruz" value="edit_ruz">
                                    <input type="hidden" id="id_lm" name="id_lm" value="<?php echo $row['id']; ?>">
                                    <div class="edtlmn">
                                        <button class="btn btn-primary btn-lg  waves-effect font-bold m-l-10" data-type="ajax-loader" name="up_btn">ویرایش تراکنش</button>
                                    </div>

                                    </div>


                                </form>
                            </div>

                        </div>



                    </div>
                </div>










            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>بارگزاری اسناد </h2>
                        </div>
                        <div class="body">


                            <form action="<?php echo BASE_URL; ?>/inc/config/upload.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data" style="overflow: hidden;">

                                <input type="hidden" name="st_is" class="ihk" value="<?php echo $row['id']; ?>" />
                                <div class="dz-message">
                                    <div class="drag-icon-cph">
                                        <i class="material-icons">touch_app</i>
                                    </div>

                                    <h3>فایل را کشیده و اینجا رها کنید</h3>
                                </div>
                                <div class="fallback">
                                    <input name="file" type="file" multiple />

                                </div>
                            </form>

                            <br/>
                            <div class="row">
                                <?php
                                if($row['id']!="") {
                                 //   $fi= get_path('uploads/'.$row['id'].'/*');
                                   $fi= '../uploads/'.$row['id'].'/*';

                                    $fileList = glob($fi);

                                    foreach($fileList as $filename){

                                            $print= '\''.$filename.'\'';
                                            echo "<div class='col-md-6'><div class='card'>";
                                            echo '<embed src="'.$filename.'" width="100%" />';
                                            echo '<div class="header clearfix"><button class="delete_is btn btn-danger btn-circle-lg waves-effect waves-circle waves-float pull-right" value="'.$filename.'" ><i class="material-icons">delete</i></button>';
                                            echo '<a href="'.$filename.'" target="_blank"><button class="view_is pull-left btn btn-primary btn-circle-lg waves-effect waves-circle waves-float"  value="'.$filename.'" ><i class="material-icons">remove_red_eye</i></button></a>';
                                            echo '<button type="button" style="display:block;" onclick="printJS('.$print.')" class="btn center-block bg-green btn-circle-lg waves-effect waves-circle waves-float">
                                    <i class="material-icons">print</i>
                                </button></div></div></div>';


                                    }




                                }
                                ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
            <!-- #END# Basic Examples -->

        </div>
    </section>

    <?php require(get_path('footer.php')); ?>