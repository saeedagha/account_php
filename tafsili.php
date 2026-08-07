<?php
$titlepage = "دفتر تفصیلی";
require('header.php');
$hesab_tafsili =list_tafsili();
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
                             دفتر تفصیلی
                            </h2>
                    
                        </div>
                        <div class="body">
                            <div class="table-responsive container">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_ms">
                                    <thead>
                                    <tr>
                                        <th>کد حساب</th>
                                        <th>نام حساب</th>
                                        <th>جمع بدهکار</th>
                                        <th>جمع بستانکار</th>
                                        <th>مانده</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>کد حساب</th>
                                        <th>نام حساب</th>
                                        <th>جمع بدهکار</th>
                                        <th>جمع بستانکار</th>
                                        <th>مانده</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>

                                    <?php $total =0; foreach($hesab_tafsili as $key=>$value){
                                        // get child and sum val
                                        $total_bes = sums($key, 0);
                                        $total_bed = sums($key, 1);
                                        $munde = $total_bes - $total_bed;
                                        echo '<tr>';
                                        echo '<td>' . $key . '</td>';
                                        echo '<td>' . gethesabname($key) . '</td>';
                                        echo '<td>' . number_format($total_bed) . '</td>';
                                        echo '<td>' . number_format($total_bes) . '</td>';
                                        echo '<td>' . number_format($munde) . '</td>';
                                        echo '</tr>';
                                        $total = 0;
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
   
        </div>
    </section>

    <?php require('footer.php'); ?>