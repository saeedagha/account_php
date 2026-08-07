<?php
$titlepage = "وام ها";
require('header.php');
$vam = sub_vam();
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
                               همه وام ها
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive container">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_col_1">
                                    <thead>
                                    <tr>

                                        <th>نام وام</th>
                                        <th>مبلغ هر قسط</th>
                                        <th>تاریخ هر قسط</th>
                                        <th>جمع پرداختی</th>
                                        <th>مبلغ کل</th>
                                        <th>مانده</th>
                                        <th>پیشرفت</th>
                                        <th>توضیحات</th>

                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>

                                        <th>نام وام</th>
                                        <th>مبلغ هر قسط</th>
                                        <th>تاریخ هر قسط</th>
                                        <th>جمع پرداختی</th>
                                        <th>مبلغ کل</th>
                                        <th>مانده</th>
                                        <th>پیشرفت</th>
                                        <th>توضیحات</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                  <?php
                                    foreach ($vam as $key=>$value) {
                                        $mande = munde($key, 0);
                                        $sums = sums($key, 0);
                                        $pay = sums($key, 1);
                                        $progress = floor(($pay / $sums) * 100);
                                        if($mande ==0) {
                                            $status ="تسویه شده - ";
                                            $cl = "green";
                                        }else{
                                            $status="";
                                            $cl = "pink";
                                        }
                                        ?>
                                      <tr>

                                          <td> <a class="font-bold col-<?php echo $cl; ?>" href="<?php echo BASE_URL; ?>/ruznameh/view.php?view=<?php echo $key; ?>"><?php echo $status.gethesabname($key); ?></a></td>
                                          <td><?php echo number_format(get_detail_hesab($key)['price']);?></td>

                                          <td><?php  if (!empty(get_detail_hesab($key)['period'])) {
                                                            echo   get_detail_hesab($key)['period'] . ' هرماه  ';
                                                        } ?></td>
                                          <td><?php echo number_format($pay); ?></td>
                                          <td><?php echo number_format($sums); ?></td>
                                          <td><?php echo number_format($mande); ?></td>
                                          <td> <?php if($progress > 70){$rang = "green";}elseif($progress <= 70 & $progress >= 30){$rang = "orange";}elseif($progress >= 30){$rang = "pink";}else{$rang="red";} ?> <div class="progress">
                                                  <div class="progress-bar bg-<?php echo $rang; ?>" role="progressbar"
                                                       aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0"
                                                       aria-valuemax="100"
                                                       style="width: <?php echo $progress; ?>%"></div>
                                              </div></td>
                                          <td><?php   echo   get_detail_hesab($key)['tozih']; ?></td>
                                      </tr>

                                   <?php }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
<?php
$sum = sum_kol(VAM);
?>
                            <div class="d-bbl clearfix">
                                <div class="pull-right" style="margin:5px 10px;">جمع بدهکار : <span class="font-16 font-bold col-pink"> <?php echo number_format(array_sum(array_column($sum,'bedehkar'))); ?></span></div>
                                <div class="pull-right" style="margin:5px 10px;">جمع بستانکار : <span class="font-16 font-bold col-teal"><?php echo number_format(array_sum(array_column($sum,'bestankar'))); ?></span></div>
                                <div class="pull-right" style="margin:5px 10px;">مانده حساب  : <span class="font-18 font-bold col-blue-grey font-underline"><?php echo number_format(array_sum(array_column($sum,'munde'))); ?></span></div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>
    </section>
<?php require('footer.php'); ?>