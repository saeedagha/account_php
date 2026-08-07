<?php
$titlepage = "دفتر معین";
require('header.php');
$hesab_moein =list_moein();
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
                             دفتر معین
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
                                    <?php $munde =0; foreach($hesab_moein as $key=>$value){
                                        // get child and sum val
                                        $total_bes = sums($key, 0);
                                        $total_bed = sums($key, 1);
                                        $munde = $total_bes - $total_bed;
                                        $sum = sum_moein($key);
                                        if((count($sum) !== 0) ) {
                                            $bes= 0;
                                            $bed= 0;
                                            $mu= 0;
                                            foreach ($sum as $k=>$v){
                                             $bes += $sum[$k]['bestankar'];
                                             $bed += $sum[$k]['bedehkar'];
                                             $mu += $sum[$k]['munde'];
                                            }
                                               echo '<tr>';
                                                echo '<td>'.$key.'</td>';
                                                echo '<td>'.gethesabname($key).'</td>';
                                                echo '<td>'.number_format($bed).'</td>';
                                                echo '<td>'.number_format($bes).'</td>';
                                                echo '<td>'.number_format($mu).'</td>';
                                                echo '</tr>';
                                        }else {
                                            echo '<tr>';
                                            echo '<td>'.$key.'</td>';
                                            echo '<td>'.gethesabname($key).'</td>';
                                            echo '<td>'.number_format(sums($key, 0)).'</td>';
                                            echo '<td>'.number_format(sums($key, 1)).'</td>';
                                            echo '<td>'.number_format($munde).'</td>';
                                            echo '</tr>';
                                            $munde =0;
                                        }
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