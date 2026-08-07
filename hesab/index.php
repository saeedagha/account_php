<?php
$titlepage = "همه حساب ها";
require_once '../inc/config/autoload.php';
require(get_path('header.php'));
if(isset($_POST['chk_sub'])) {
    $error=array();
    $del_id =(int) addslashes(htmlentities($_POST['del_id']));
    if($del_id ==0) {$kol_id = NULL;}
 //   $sql = "DELETE FROM `hesabha` WHERE `id` =$del_id ;";
    $sql = "DELETE FROM `hesabha` WHERE  NOT EXISTS (SELECT * from `hesabha` where `kol_id` =$del_id OR `moein_id`=$del_id OR `tafsili_id`=$del_id ) and `id` =$del_id;";
    $result = $conn->prepare($sql);
    if($result->execute()) {
        $error['color'] = 'teal';
        $error['message'] ='حساب حذف شد';
    }else{
        $error['color'] = 'pink';
        $error['message'] ='مشکلی در حذف حساب به وجود آمد شاید اطلاعات این حساب در دفتر روزنامه و یا والد حساب دیگر باشد  ';
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
                            <h2>لیست حساب ها  </h2>

                                    <?php
                                    $kols =   list_kol();
                                    $moeins =   list_moein();
                                    $tafsilis =   list_tafsili();


                                    try {
                                        $sql = "SELECT * FROM `hesabha`";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $ary= array();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $ary[] = $row;
                                        }

                                        // print_r($ary);

                                    } catch (Exception $e) {

                                        echo $e->getMessage();

                                    }

                                    $byGroup = group_by("kol_id", $ary);

                                    ?>

                        </div>
                        <div class="body">
                            <div class="table-responsive container">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_ms">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center !important;">شناسه</th>
                                        <th>نام حساب</th>
                                        <th>حساب والد کل</th>
                                        <th>حساب معین والد</th>
                                        <th style="text-align: center !important;">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="text-align: center !important;">شناسه</th>
                                        <th>نام حساب</th>
                                        <th>حساب والد کل</th>
                                        <th>حساب معین والد</th>
                                        <th style="text-align: center !important;">عملیات</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    try{
                                        $sql = "SELECT * FROM `hesabha`";

                                        $stm = $conn->prepare($sql);
                                        $stm->execute();

                                        $stm->setFetchMode(PDO::FETCH_ASSOC);

                                        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                                            ?>


                                            <tr>
                                                <td style="text-align: center !important;"><?php echo $row['id']; ?></td>
                                                <td><?php
                                                    $ar=array();
                                                    if($row['kol_id']){
                                                        array_push($ar,gethesabname($row['kol_id']));

                                                    }
                                                    if($row['moein_id']){
                                                        array_push($ar,gethesabname($row['moein_id']));
                                                    }
                                                    if($row['h_name']){
                                                        array_push($ar,$row['h_name']);
                                                    }

                                                    $List = implode(' » ', $ar);
                                                    echo $List;
                                                    ?></td>

                                                <td class="font-bold col-pink">

                                                    <?php echo gethesabname($row['kol_id']); ?>
                                                </td>
                                                <td class="font-bold col-teal">

                                                    <?php echo gethesabname($row['moein_id']); ?>
                                                </td>

                                                <td style="text-align: center !important;">

                                                 <div class="btn_edit">
                                            <ul class="list-inline">
                                            <li><a  class="edit_bb" href="edit.php?edit=<?php echo $row['id']; ?>"><i class="material-icons">edit</i></a></li>
                                            <li>
                                                <form method="post" class="del_frm">
                                                    <input type="hidden" name="del_id" value="<?php echo $row['id']; ?>">
                                                    <input type="hidden" name="chk_sub" value="chk_sub">
                                                    <button class="waves-effect delete_bj"  data-type="cancel"><i class="material-icons">delete</i></button></form>
                                            </li>
                                            </ul>
                                            </div>

                                                </td>
                                            </tr>

                                        <?php   }


                                    }catch(PDOException $e){
                                        echo $e->getMessage();
                                    }



                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="body farsi_g">
                            <div class="row">

                                <style id="compiled-css" type="text/css">
                                    .tree li {
                                        margin: 0px 0;

                                        list-style-type: none;
                                        position: relative;
                                        padding: 20px 5px 0px 5px;
                                    }

                                    .tree li::before{
                                        content: '';
                                        position: absolute;
                                        top: 0;
                                        width: 1px;
                                        height: 100%;
                                        right: auto;
                                        left: -20px;
                                        border-left: 1px solid #ccc;
                                        bottom: 50px;
                                    }
                                    .tree li::after{
                                        content: '';
                                        position: absolute;
                                        top: 30px;
                                        width: 25px;
                                        height: 20px;
                                        right: auto;
                                        left: -20px;
                                        border-top: 1px solid #ccc;
                                    }
                                    .tree li a{
                                        display: inline-block;
                                        border: 1px solid #ccc;
                                        padding: 5px 10px;
                                        text-decoration: none;
                                        color: #666;
                                        font-family: arial, verdana, tahoma;
                                        font-size: 11px;
                                        border-radius: 5px;
                                        -webkit-border-radius: 5px;
                                        -moz-border-radius: 5px;
                                    }

                                    /*Remove connectors before root*/
                                    .tree > ul > li::before, .tree > ul > li::after{
                                        border: 0;
                                    }
                                    /*Remove connectors after last child*/
                                    .tree li:last-child::before{
                                        height: 30px;
                                    }

                                    /*Time for some hover effects*/
                                    /*We will apply the hover effect the the lineage of the element also*/
                                    .tree li a:hover, .tree li a:hover+ul li a {
                                        background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
                                    }
                                    /*Connector styles on hover*/
                                    .tree li a:hover+ul li::after,
                                    .tree li a:hover+ul li::before,
                                    .tree li a:hover+ul::before,
                                    .tree li a:hover+ul ul::before{
                                        border-color:  #94a0b4;
                                    }






                                    /* EOS */
                                </style>

                                <div class="tree">
                                 <!--   <pre>
                                    <?php
/*                                  $kols =   list_kol();
                                  $moeins =   list_moein();
                                  $tafsilis =   list_tafsili();


                                    try {
                                        $sql = "SELECT * FROM `hesabha`";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $ary= array();
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $ary[] = $row;
                                        }

                                       // print_r($ary);

                                    } catch (Exception $e) {

                                        echo $e->getMessage();

                                    }

                                    $byGroup = group_by("kol_id", $ary);

                                    // Dump result
                                    echo "<pre>" . print_r($byGroup) . "</pre>";

                                    */?>
                                    </pre>

-->


                            <!--        <ul>
                                        <li>
                                            <a href="#">Parent</a>
                                            <ul>
                                                <li>
                                                    <a href="#">Child</a>
                                                    <ul>
                                                        <li>
                                                            <a href="#">Grand Child</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">Child</a>
                                                    <ul>
                                                        <li><a href="#">Grand Child</a></li>
                                                        <li>
                                                            <a href="#">Grand Child</a>
                                                            <ul>
                                                                <li>
                                                                    <a href="#">Great Grand Child</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Great Grand Child</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Great Grand Child</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li><a href="#">Grand Child</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                             -->   </div>












                            </div>

                        </div>



                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->

        </div>
    </section>

    <?php require(get_path('footer.php')); ?>