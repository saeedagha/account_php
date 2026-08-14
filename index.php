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
                            <?php
                            $templates = get_document_templates('cost');

                            echo '<pre>';
                            print_r($templates);
                            echo '</pre>';
                            ?>
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





                            <div class="table-responsive">
                                <table id="table_list" class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_col_1a">
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

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
<!-- Start Row -->
<script>
function sanitizing(value) {
  // Optional: format or sanitize input
  return value.replace(/[^\d.]/g, ''); // remove non-numeric except dot
}

function updateTotal() {
   
  let total = 0;
  const inputs = document.querySelectorAll('.price-input');
  inputs.forEach(input => {
    const val = parseFloat(sanitizing(input.value));
    if (!isNaN(val)) total += val;
  });
  document.getElementById('total-price').textContent = 'مجموع : ' +separate(total);
}
</script>
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>وام های جاری  - <a class="font-14 font-bold col-blue" href="<?php echo BASE_URL; ?>/vam.php">نمایش همه وام ها</a>
                            <span id="total-price" style="font-weight:bold; color:teal;font-size: 15px;margin-right: 10px;"></span>
                            </h2>

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
                                                <td style="width:50%;">
                                                    <a tabindex="-1" href="<?php echo BASE_URL; ?>/ruznameh/view.php?view=<?php echo $key; ?>"><?php echo gethesabname($key); ?></a><code style="font-family: 'iransans', Tahoma, Arial !important;margin-right: 15px;"> <?php echo get_description_last_vam($key)['sharh']; ?></code>
                                                <input type="text" class="price-input pull-left"  onchange="javascript:this.value=separate(this.value);"  onkeyup="updateTotal()" style="border:none;text-align: left;width: 120px;"  /></td>
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