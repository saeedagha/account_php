<?php
$titlepage = "ویرایش حساب";
require_once '../inc/config/autoload.php';
require(get_path('header.php'));
ob_start();
if(isset($_POST['edit_lmn'])) {
  print_r($_POST);
    $error=array();

    $id =(int) addslashes(htmlentities($_POST['id_lm']));
    $kol_id =(int) addslashes(htmlentities($_POST['kol_id']));
    if($kol_id ==0) {$kol_id = NULL;}
    $moein_id =(int) addslashes(htmlentities($_POST['moein_id']));
    if($moein_id ==0) {$moein_id = NULL;}
    $tafsili =(int) addslashes(htmlentities($_POST['tafsili']));
    if($tafsili ==0) {$tafsili = NULL;}
    $h_name = addslashes(htmlentities($_POST["h_name"]));
    $ghest_price = addslashes(htmlentities($_POST["ghest_price"]));
    $ghest_price = str_replace(",", "", $ghest_price);
    $ghest_period = addslashes(htmlentities($_POST["ghest_period"]));
    $tozih = addslashes(htmlentities($_POST["tozih"]));
    //$sql = "INSERT INTO `hesabha` (`h_name`, `kol_id`, `moein_id`, `tafsili_id`, `mat`, `tozih`, `period`, `price`, `selectable`) VALUES (:h_name, :kol_id, :moein_id, :tafsili_id, :mat, :tozih, :period, :price, :selectable);";
    $sql = "UPDATE `hesabha`  SET `h_name`= :h_name, `kol_id`= :kol_id, `moein_id`= :moein_id, `tafsili_id`= :tafsili_id,  `mat`= :mat, `tozih`= :tozih, `period`= :period, `price`= :price, `selectable`= :selectable WHERE `id` = $id ";
    $result = $conn->prepare($sql);
    if($result->execute(array(
        "h_name" => $h_name,
        "kol_id" => $kol_id,
        "moein_id" => $moein_id,
        "tafsili_id" => $tafsili,
        "mat" => 1,
        "tozih" => $tozih,
        "period" => $ghest_period,
        "price" => $ghest_price,
        "selectable" => 1,
    ))) {
        $error['color'] = 'teal';
        $error['message'] =' حساب  '.$h_name.' با موفقیت ویرایش شد ';
    }else{
        $error['color'] = 'pink';
        $error['message'] ='مشکلی در ویرایش حساب به وجود آمد لطفا صفحه را مجدد بارگزاری کنید و یا در ورود مقادیر دقت نمایید';
    }




}
if(isset($_GET['edit']) ) {
//session_start();
    $_SESSION['idss'] = addslashes(htmlentities($_GET["edit"]));


    $edit = (int)addslashes(htmlentities($_GET["edit"]));
    if (!empty($edit) && isset($edit)) {
        $sql = "SELECT * FROM ";
        $sql .= "`hesabha` WHERE ";
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
                            <h2  style="line-height: 44px;">" ویرایش حساب  <?php echo $row['h_name']; ?>  " </h2>
                        </div>


                        <div class="body container farsi_g">
                            <div class="row">



                                <form class="clearfix" id="upl_ed" action="" method="post">
                                    <div class="row">
                                    <div class="col-sm-3 col-xs-12">

                                        <div class="form-group form-float">
                                            <div class="form-line input-group">
                                                <label class="form-label" for="h_name">نام حساب</label>
                                                <input type="text" id="staff_arr" name="h_name" class="form-control" value="<?php echo $row['h_name']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-12">

                                        <div class="form-group form-float">
                                            <div class="form-line input-group">
                                                <label class="form-label">حساب کل</label>
                                                <select class="form-control show-tick" name="kol_id" data-live-search="true" onchange="vamSelect()">
                                                   <option value="0" selected>--کل اصلی--</option>
                                                    <?php
                                                    $parent_kol =  list_kol();
                                                    foreach ($parent_kol as $key =>$value){ ?>

        <option value="<?php echo $key; ?>" <?php if($row['kol_id'] == $key ){echo ' selected'; } ?>><?php echo $value; ?></option>
                                                  <?php }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                   </div>
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="form-group form-float">
                                            <div class="form-line input-group">
                                                <label class="form-label" for="moein_id">حساب معین</label>
                                                <select class="form-control show-tick" id="moein_id" name="moein_id" data-live-search="true">
                                                    <option value="0" selected>--فاقد معین--</option>
                                                    <?php
                                                    $parent_moein =  list_moein();
                                                    foreach ($parent_moein as $key =>$value){ ?>
                                                        <option value="<?php echo $key; ?>" <?php if($row['moein_id'] == $key ){echo ' selected'; } ?>><?php echo display_hesab($key)[0]; ?> -> <?php echo $value; ?></option>
                                                    <?php }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-12">

                                        <div class="form-group form-float">
                                            <div class="form-line input-group">
                                                <label class="form-label" for="tafsili">حساب تفصیلی </label>
                                                <select class="form-control show-tick" name="tafsili" id="tafsili" data-live-search="true">
                                                    <option value="0" selected>--فاقد تفصیلی--</option>
                                                    <?php
                                                    $parent_taf =  list_tafsili();
                                                    foreach ($parent_taf as $key =>$value){ ?>
                                                        <option id="<?php echo $key; ?>" <?php if($row['id'] == $key ){echo ' selected'; } ?>><?php echo display_hesab($key)[0]; ?> -> <?php echo display_hesab($key)[1]; ?> -> <?php echo $value; ?></option>
                                                    <?php }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                                    <div class="row">
                                    <div class="col-sm-3 col-xs-12 " id="otherBoxVam2" style="<?php echo ($row['kol_id'] == VAM) ? "" : " display: none;"; ?>" >
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" for="ghest_price">مبلغ اقساط ماهیانه</label>
                                                <input  id="ghest_price" class="form-control" name="ghest_price" value="<?php echo number_format($row['price']); ?>" onkeyup="javascript:this.value=separate(this.value);" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-xs-12" id="otherBoxVam" style="<?php echo ($row['kol_id'] == VAM) ? "" : " display: none;"; ?>">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" for="ghest_period">تاریخ پرداختی ماهیانه</label>
                                                <input  id="ghest_period" class="form-control" name="ghest_period" value="<?php echo $row['period']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-sm-3 col-xs-12">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label class="form-label" for="tozih">توضیحات</label>
                                                    <input  id="tozihat" class="form-control" name="tozih" value="<?php echo $row['tozih']; ?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="edit_lmn" name="edit_lmn" value="edit_lmn">
                                    <input type="hidden" id="id_lm" name="id_lm" value="<?php echo $row['id']; ?>">
                                    <div class="edtlmn">
                                        <button class="btn btn-primary btn-lg  waves-effect font-bold m-l-10" data-type="ajax-loader" name="up_btn">ویرایش حساب</button>
                                    </div>

                                    </div>


                                </form>
                            </div>

                        </div>



                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->

        </div>
    </section>

    <?php require(get_path('footer.php')); ?>