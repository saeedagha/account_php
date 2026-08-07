<?php
$titlepage = "افزودن حساب";
require_once '../inc/config/autoload.php';
require(get_path('header.php'));
$row['kol_id']=0;
$row['id']=0;
$row['moein_id']=0;

if(isset($_POST['insert_new'])) {
 $error=array();   
    try {
  

   // require(get_path('hesab/action.php'));

   // require_once '../inc/config/db.php';

    $kol_id =(int) addslashes(htmlentities($_POST['kol_id']));
    if($kol_id == 0) {$kol_id = NULL;}
    $moein_id =(int) addslashes(htmlentities($_POST['moein_id']));
    if($moein_id == 0) {$moein_id = NULL;}
    $tafsili =(int) addslashes(htmlentities($_POST['tafsili']));
    if($tafsili == 0) {$tafsili = NULL;}
    $h_name = addslashes(htmlentities($_POST["h_name"]));
    $ghest_price = addslashes(htmlentities($_POST["ghest_price"]));
    $ghest_price = str_replace(",", "", $ghest_price);
    $ghest_period = addslashes(htmlentities($_POST["ghest_period"]));
    $tozih = addslashes(htmlentities($_POST["tozih"]));
    $sql = "INSERT INTO `hesabha` (`h_name`, `kol_id`, `moein_id`, `tafsili_id`, `mat`, `tozih`, `period`, `price`, `selectable`, `ijad`) VALUES (:h_name, :kol_id, :moein_id, :tafsili_id, 1, :tozih, :period, :price, 1, NOW());";
    

    
    $result = $conn->prepare($sql);
    if($result->execute(array(
        "h_name" => $h_name,
        "kol_id" => $kol_id,
        "moein_id" => $moein_id,
        "tafsili_id" => $tafsili,
        "tozih" => $tozih,
        "period" => $ghest_period,
        "price" => $ghest_price,
   
    ))) {
      $error['color'] = 'teal';
      $error['message'] ='حساب با موفقیت ایجاد شد';

    }else{
       $error['color'] = 'pink';
       $error['message'] ='مشکلی در ایجاد حساب به وجود آمد لطفا صفحه را مجدد بارگزاری کنید و یا در ورود مقادیر دقت نمایید';
    }
} catch (Exception $e) {
 print_r($_POST);


}





}

?>

<section class="content">
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if(isset($error) && !empty($error)) {
                     echo ' <div class="alert bg-'. $error['color'].' alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                  '. $error['message'].'
                    </div>';

                    } ?>


                    <div class="card">
                        <div class="header clearfix">
                            <h2>ایجاد حساب جدید  </h2>
                        </div>


                        <div class="body container  farsi_g">
                            <div class="row">



                                <form class="clearfix" id="in_ed" action="" method="post">
                                    <div class="row">
                                        <div class="col-sm-3 col-xs-12">

                                            <div class="form-group form-float">
                                                <div class="form-line input-group">
                                                    <label class="form-label" for="h_name">نام حساب</label>
                                                    <input type="text" id="h_name" name="h_name" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12">

                                            <div class="form-group form-float">
                                                <div class="form-line input-group">
                                                    <label class="form-label" for="kol_id">حساب کل</label>
                                                    <select class="form-control show-tick" id="kol_id" name="kol_id"  data-live-search="true" onchange="vamSelect()">
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

                                            <?php
                                         /*
                                          <option label="انتخاب کنید"></option>
                                          $stmt = $conn->prepare("select * from hesabha where  `kol_id` is NULL");
                                            $stmt->execute();
                                            while($menu1 = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo '<option value="'.$menu1->id.'">'.$menu1->h_name.'</option>';
                                                $stmt5 = $conn->prepare("select * from hesabha where  `kol_id`= $menu1->id");
                                                $stmt5->execute();
                                                while($menu5 = $stmt5->fetch(PDO::FETCH_OBJ)) {
                                                    echo '<option value="'.$menu5->id.'"><span>'.$menu1->h_name.' 	&larr; </span>'.$menu5->h_name.'</option>';
                                                }
                                            }*/
                                            ?>

                                            <div class="form-group form-float">
                                                <div class="form-line input-group">
                                                    <label class="form-label" for="moein_id">حساب معین</label>
                                                    <select class="form-control show-tick" id="moein_id" name="moein_id" data-live-search="true">
                                                        <option value="0" selected>--فاقد معین--</option>
                                                        <?php
                                                        $parent_moein =  list_moein();
                                                        foreach ($parent_moein as $key =>$value){ ?>
                                                            <option value="<?php echo $key; ?>" <?php if($row['moein_id'] == $key ){echo ' selected'; } ?>><?php echo $value; ?></option>
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
                                                    <select class="form-control show-tick" id="tafsili" name="tafsili" data-live-search="true">
                                                        <option value="0" selected>--فاقد تفصیلی--</option>
                                                        <?php
                                                        $parent_taf =  list_tafsili();
                                                        foreach ($parent_taf as $key =>$value){ ?>
                                                            <option value="<?php echo $key; ?>" <?php if($row['id'] == $key ){echo ' selected'; } ?>><?php echo $value; ?></option>
                                                        <?php }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row">
                                        <div class="col-sm-3 col-xs-12 " id="otherBoxVam2" style="display: none;" >
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label class="form-label" for="ghest_price">مبلغ اقساط ماهیانه</label>
                                                    <input  id="ghest_price" class="form-control" name="ghest_price" value="" onkeyup="javascript:this.value=separate(this.value);" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12" id="otherBoxVam" style="display: none;">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label class="form-label" for="ghest_period">تاریخ پرداختی ماهیانه</label>
                                                    <input  id="ghest_period" class="form-control" name="ghest_period" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    <div class="col-sm-3 col-xs-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" for="tozih">توضیحات</label>
                                                <input  id="tozihat" class="form-control" id="tozih" name="tozih" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <input type="hidden" id="insert_new" name="insert_new" value="insert_new">
                                    <input type="hidden" id="id_lm" value="<?php echo $row['id']; ?>">
                                    <div class="edtlmn">
                                        <button class="btn  bg-teal  btn-lg  waves-effect font-bold m-l-10"  type="submit">ایجاد حساب</button>


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
<?php


//    $fata = tree_hesab();
// your original data as an array
$data = array(
    array(
        'id' => 1,
        'parentId' => null,
        'name' => 'item1'
    ),
    array(
        'id' => 2,
        'parentId' => null,
        'name' => 'item2'
    ),
    array(
        'id' => 3,
        'parentId' => 1,
        'name' => 'item3'
    ),
    array(
        'id' => 4,
        'parentId' => 2,
        'name' => 'item4'
    ),
    array(
        'id' => 5,
        'parentId' => 3,
        'name' => 'item5'
    ),
    array(
        'id' => 6,
        'parentId' => 3,
        'name' => 'item6'
    ),
);
function buildTree( $ar, $pid = null ) {
    $op = array();
    foreach( $ar as $item ) {
        if( $item['kol_id'] == $pid ) {
            $op[$item['id']] = array(
                'h_name' => $item['h_name'],
                'moein_id' => $item['moein_id'],
                'tafsili_id' => $item['tafsili_id'],
                'parentId' => $item['kol_id']
            );
            // using recursion
            $children =  buildTree( $ar, $item['id'] );
            if( $children ) {
                $op[$item['id']]['children'] = $children;
            }
        }
    }
    return $op;
}

//  print_r( buildTree( $data ) );

?>

    <pre>
                                      <?php   //  print_r(buildTree( $data )); ?>
                                      <?php    // print_r(buildTree( $fata )); ?>
                                      <?php // print_r(null_moein(5));
                                      //    print_r(sub_cost());
                                      ?>
                                    </pre>

    <?php require(get_path('footer.php')); ?>