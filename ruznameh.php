<?php
  ob_start();
  $titlepage = "خانه";
require('header.php'); 
?>
<section class="content">
        <div class="container-fluid">
            <?php require('inc/btn.php'); ?>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                             دفتر روزنامه
                            </h2>
                    
                        </div>
                        <div class="body">

                            <button class="btn btn-danger btn-sm my-3" style=" margin-bottom: 15px;" id="search_bx">جستجوی پیشرفته</button>
                            <div id="bx_s" style="display: none;border: 1px solid #D0CECE;" class="row mb-5 mt-1 pb-5">
                                <div class="col-sm-3 mt-3">
                                    <div class="form-gp" id="filter_global">
                                        <label>جستجوی کلی</label><input type="text" class="global_filter form-control" id="global_filter">
                                    </div>
                                </div>
                                <div class="col-sm-3 mt-3">

                                    <div class="form-gp" data-column="0">
                                        <label>شناسه</label><input type="text" class="column_filter form-control" id="col0_filter">
                                    </div>

                                </div>

                                <div class="col-sm-3 mt-3">

                                    <div class="form-gp msk" data-column="1">
                                        <label>تاریخ</label><input  type="text" class="column_filter form-control" id="col1_filter">
                                    </div>

                                </div>
                                <div class="col-sm-3 mt-3">




                                    <div class="form-gp" data-column="2">
                                        <label>بدهکار</label><input type="text" class="column_filter form-control" id="col2_filter">
                                    </div>
                                </div>

                                <div class="col-sm-3 mt-3">


                                    <div class="form-gp" data-column="3">
                                        <label>بستانکار</label><input type="text"   class="column_filter form-control" id="col3_filter">
                                    </div>
                                </div>
                                <div class="col-sm-3 mt-3">



                                    <div class="form-gp" data-column="4">
                                        <label>شرح</label><input type="text" class="column_filter form-control" id="col4_filter">
                                    </div>

                                </div>
                                <div class="col-sm-3 mt-3">


                                    <div class="form-gp" data-column="5">
                                        <label>مبلغ</label><input type="text" class="column_filter form-control" onkeyup="javascript:this.value=separate(this.value);" id="col5_filter">
                                    </div>
                                </div>



                            </div>





                            <div class="table-responsive container">
                                <table id="table_list" class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_col_1">
                                    <thead>
                                        <tr>
                                            <th>شناسه</th>
                                            <th>تاریخ</th>
                                            <th>بدهکار</th>
                                            <th>بستانکار</th>
                                            <th>شرح</th>
                                            <th>مبلغ</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>شناسه</th>
                                            <th>تاریخ</th>
                                            <th>بدهکار</th>
                                            <th>بستانکار</th>
                                            <th>شرح</th>
                                            <th>مبلغ</th>
                                        </tr>
                                    </tfoot>

                                    <tbody id="coocl">
                                    <?php

                                    try {

                                        $sql = "SELECT * FROM `ruznameh` ORDER BY `id`";

                                        $stm = $conn->prepare($sql);
                                        $stm->execute();

                                        $stm->setFetchMode(PDO::FETCH_ASSOC);

                                        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {

                                            //   echo '<option value="'.$row['h_id'].'">'.$row['h_name'].'</option>';
                                            ?>


                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo date_sep($row['date']); ?></td>

                                                <td class="font-bold col-pink"><?php echo '<a href="'.BASE_URL.'/ruznameh/view.php?view='.$row["hesab_bed"].'" class="col-pink">';
    $hesab = display_hesab($row['hesab_bed']);
      $List = implode(' » ', $hesab);
      echo $List.'</a>'; ?></td>
                                                <td class="font-bold col-teal"><?php echo '<a href="'.BASE_URL.'/ruznameh/view.php?view='.$row["hesab_bes"].'" class="col-teal">';
                                                    $hesab = display_hesab($row['hesab_bes']);
                                                    $List = implode(' » ', $hesab);
                                                    echo $List.'</a>'; ?></a></td>
                                                <td><?php echo $row['sharh']; ?></td>
                                                <td>
                                                    <?php echo '<a href="'.BASE_URL.'/ruznameh/edit.php?edit='.$row['id'].'">'.number_format( $row['price']).'</a>'; ?>

                                                </td>
                                            </tr>
                                        <?php }
                                    } catch (PDOException $e) {
                                        echo $e->getMessage();
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
<!-- Start Row -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>وام های جاری  - <a class="font-14 font-bold col-blue" href="<?php echo BASE_URL; ?>/vam.php">نمایش همه وام ها</a></h2>

                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                    <tr>
                                        <th class="text-center">وام</th>
                                        <th class="text-center">مبلغ هر قسط</th>
                                        <th class="text-center">پرداختی</th>
                                        <th class="text-center">مانده</th>
                                        <th class="text-center">مبلغ کل</th>
                                        <th class="text-center">پیشرفت</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $vam = sub_vam();
                                    foreach ($vam as $key=>$value) {
                                        $mande = munde($key, 0);
                                        $sums = sums($key, 0);
                                        $pay = sums($key, 1);
                                        $progress = floor(($pay / $sums) * 100);
                                        if ($mande != 0) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo BASE_URL; ?>/ruznameh/view.php?view=<?php echo $key; ?>"><?php echo gethesabname($key); ?></a>
                                                </td>
                                                <td><span class="label bg-green">
                                                        <?php echo number_format(get_detail_hesab($key)['price']);
                                                        if (!empty(get_detail_hesab($key)['period'])) {
                                                            echo ' - ( ' . get_detail_hesab($key)['period'] . ' هرماه  )';
                                                        } ?>
                                                    </span></td>
                                                <td>
                                                    <span class="label bg-primary"><?php echo number_format($pay); ?></span>
                                                </td>

                                                <td><?php echo number_format($mande); ?></td>
                                                <td><?php echo number_format($sums); ?> </td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-green" role="progressbar"
                                                             aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0"
                                                             aria-valuemax="100"
                                                             style="width: <?php echo $progress; ?>%"></div>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php }
                                    }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<!-- End Row -->



        </div>
    </section>

    <?php require('footer.php'); 
     
      ?>