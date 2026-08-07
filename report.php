<?php
$titlepage = "گزارشات";
require('header.php');
$sub_income = sub_income();
$vam = sub_vam();
$sub_cost = list_sub_costs();
$current_date = jdate("Ym",'','','','en');
$start_date="";
$end_date="";
$query_start="";
$query_end="";
$q="";
if(isset($_GET['start_date'])) {
    $start_date = addslashes(htmlentities(trim($_GET['start_date'])));
    $query_start = str_replace('/', '', $start_date);
}
if(isset($_GET['end_date'])) {
    $end_date = addslashes(htmlentities(trim($_GET['end_date'])));
    $query_end = str_replace('/', '', $end_date);
}
?>
<?php // echo jdate("Y/m",'','','','en'); ?>
    <section class="content">
        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12" id="bombom">
                    <div class="card">



                        <div class="col-md-6 col-md-push-3 my-5" style="margin: 100px auto;">


                            <canvas id="line_chart" height="190" ></canvas>

                        </div>






                        <div class="header">
                            <h2>گردش حساب  <?php if($start_date){echo " از $start_date ";}if($end_date) {echo " تا $end_date";} ?>  </h2>
                        </div>
                        <div class="body claer clearfix">
                            <div class="col-md-12">

                                <form action="" method="get">
                                    <div class="row">

                                        <div class="col-md-3">
                                            <b>تاریخ شروع</b>
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">date_range</i>
                                            </span>
                                                <div class="form-line">
                                                    <input type="text" id="tarikh5" name="start_date" autocomplete="off" <?php if($start_date){echo 'value="'.$start_date.'"'; } ?> class="form-control fc-datepicker " placeholder="MM/DD/YYYY" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <b>تاریخ پایان</b>
                                            <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">date_range</i>
                                            </span>
                                                <div class="form-line">
                                                    <input type="text" id="tarikh4" name="end_date" autocomplete="off" <?php if($end_date){echo 'value="'.$end_date.'"'; } ?> class="form-control fc-datepicker" placeholder="MM/DD/YYYY" required="">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <b id="dfg" style="font-size: 12px;">&nbsp;</b>
                                            <div class="inputoup">
                                                <button type="submit" id="btn_sub" class="btn bg-teal  waves-effect" style="line-height: 31px;">
                                                    <i class="material-icons" style="top: 7px;position: relative;">save</i>
                                                    <span>گزارش گیری</span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>



                                </form>




                            </div>
                            <!--start Income -->
                            <div class="col-md-4">
                                <h3 style="font-size: 20px;margin-bottom: 20px;color: #f44336;width: 75px;">هزینه ها</h3>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_simple2" width="100%" >
                                    <thead>
                                    <tr>
                                        <th>حساب</th>
                                        <th>مبلغ</th>
                                        <th>درصد</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>حساب</th>
                                        <th>مبلغ</th>
                                        <th>درصد</th>
                                    </tr>
                                    </tfoot>

                                    <tbody>

                                    <?php
                                    try {
                                        if($query_start && $query_end && $query_end >$query_start) {
                                            $q = " AND date BETWEEN $query_start And $query_end  ";
                                        }
                                        $costi = HAZINEH ;
                                        $sql = "SELECT ruznameh.date,ruznameh.hesab_bed,ruznameh.hesab_bes, hesabha.* , sum(ruznameh.price)as jame FROM `ruznameh` LEFT JOIN hesabha on hesab_bed=hesabha.id where kol_id=$costi $q GROUP by hesab_bed ORDER BY `hesabha`.`moein_id` ASC ";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $row4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        $glk=0;
                                        $glk2=0;
                                        foreach ($row4 as $gbi) {

                                            $glk2 +=$gbi["jame"];
                                        }

                                        foreach ($row4 as $gb) {
                                            // print_r($gb);
                                            echo '<tr><td>'.$gb["h_name"].'</td><td>'.number_format($gb["jame"]).'</td><td>% '.ceil(($gb["jame"]*100)/$glk2).'</td></tr>';
                                            $glk +=$gb["jame"];
                                        }




                                    } catch (Exception $e) {
                                        echo $e->getMessage();
                                    }
                                    ?>





                                    </tbody>
                                </table>





                                <p> جمع کل  : <strong class="font-bold col-pink">
                                        <?php
                                        echo number_format(str_replace('-', '', $glk))
                                        ?></strong> ریال</p>

                            </div>

                            <!--End Income-->

                            <div class="col-md-4">
                                <h3 style="font-size: 20px;margin-bottom: 20px;color: #FF9800 ;">اقساط پرداختی</h3>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_simple2"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th>حساب</th>
                                        <th>مبلغ</th>
                                        <th>درصد</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>حساب</th>
                                        <th>مبلغ</th>
                                        <th>درصد</th>
                                    </tr>
                                    </tfoot>

                                    <tbody>

                                    <?php
                                    try {

                                        $vam = VAM ;
                                        $sql2 = "  SELECT ruznameh.date,ruznameh.hesab_bed,ruznameh.hesab_bes, hesabha.* , sum(ruznameh.price)as jame FROM `ruznameh` LEFT JOIN hesabha on hesab_bed=hesabha.id where kol_id=$vam $q GROUP by hesab_bed ORDER BY `hesabha`.`moein_id` ASC";
                                        $stmt2 = $conn->prepare($sql2);
                                        $stmt2->execute();
                                        $row5 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                        $nutt=0;
                                        foreach ($row5 as $gbur) {

                                            $nutt += (int) $gbur["jame"];
                                        }
                                        $nu=0;
                                        foreach ($row5 as $gbu) {
                                            // print_r($gb);
                                            echo '<tr><td>'.$gbu["h_name"].'</td><td>'.number_format($gbu["jame"]).'</td><td>% '.ceil(($gbu["jame"]*100)/$nutt).'</td></tr>';
                                            $nu += (int) $gbu["jame"];
                                        }


                                    } catch (Exception $e) {
                                        echo $e->getMessage();
                                    }
                                    ?>
                                    </tbody>
                                </table>


                                <p> جمع کل  : <strong class="font-bold col-orange">  <?php

                                        echo number_format(str_replace('-', '',    $nu ))
                                        ?></strong> ریال</p>







                            </div>

                            <div class="col-md-4">
                                <h3 style="font-size: 20px;margin-bottom: 20px;color: #089058;width: 75px;">درآمدها</h3>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_simple2">

                                    <thead>
                                    <tr>
                                        <th>حساب</th>
                                        <th>مبلغ</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>حساب</th>
                                        <th>مبلغ</th>
                                    </tr>
                                    </tfoot>

                                    <tbody >

                                    <?php


                                    try {
                                        $daramad = DARAMAD ;
                                        $sql = "  SELECT ruznameh.date,ruznameh.hesab_bed,ruznameh.hesab_bes,ruznameh.price, hesabha.* , sum(ruznameh.price)as jame FROM `ruznameh` LEFT JOIN hesabha on hesab_bes=hesabha.id where kol_id=$daramad $q GROUP by hesab_bes ORDER BY `hesabha`.`moein_id` ASC";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $row4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        $nn=0;
                                        foreach ($row4 as $gb) {
                                            // print_r($gb);
                                            echo '<tr><td>'.$gb["h_name"].'</td><td>'.number_format($gb["jame"]).'</td></tr>';
                                            $nn += $gb["jame"];
                                        }



                                    } catch (Exception $e) {
                                        echo $e->getMessage();
                                    }
                                    ?>


                                    </tbody>
                                </table>


                                <p> جمع کل  : <strong class="font-bold col-teal">  <?php

                                        echo number_format(str_replace('-', '', $nn))
                                        ?></strong> ریال</p>


                            </div>

                        </div>

                    </div>



                </div>
            </div>
            <!-- #END# Basic Examples -->
        </div>

        <script src="<?php echo BASE_URL; ?>/inc/assets/js/chart.js"></script>
        <script>
            const ctx = document.getElementById('line_chart').getContext("2d");

            new Chart(ctx, {
                type: 'line',

                data: {
                    labels: [
                        <?php

                            for ($i =12; $i >= 1; $i--) {
                               if($i !==12){echo ',';}
                                echo "'".jdate("Y-m", strtotime( date( 'Y-m' )." -$i months" ),"","","en")."'";
                            }
                            ?>
                       ],

                    datasets: [{
                        label: 'درآمد  ',
                        fill: true,
                        data: [
                            <?php for ($i = 12; $i >=1; $i--) {
                            if ($i !== 12) {
                                echo ',';
                            }
                            echo sum_period(2, jdate("Ym", strtotime( date( 'Ym' )." -$i months" ),"","","en").'00', jdate("Ym", strtotime( date( 'Ym' )." -$i months" ),"","","en").'31' );
                        }
                        ?>
                        ],
                        borderColor: '#009789',
                        backgroundColor: 'rgba(0,151,137,0.2)',
                        pointBorderColor: 'rgba(233, 30, 99, 0)',
                        pointBackgroundColor: '#009789',
                        pointBorderWidth: 9,
                        borderWidth: 3,
                        tension: 0.3,
                        responsive: true,
                        legend: false,
                    }, {
                        label: 'هزینه ',
                        data: [
                            <?php for ($i = 12; $i >=1; $i--) {
                            if ($i !== 12) {
                                echo ',';
                            }
                            echo sum_period(3, jdate("Ym", strtotime( date( 'Ym' )." -$i months" ),"","","en").'00', jdate("Ym", strtotime( date( 'Ym' )." -$i months" ),"","","en").'31');
                        }
                            ?>
                        ],
                        fill: true,
                        borderColor: 'rgba(233, 30, 99, 0.75)',
                        backgroundColor: 'rgba(233, 30, 99, 0.3)',
                        pointBorderColor: 'rgba(233, 30, 99, 0)',
                        pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                        pointBorderWidth: 10,
                        borderWidth: 3,
                        tension: 0.3,

                    }, {
                        label: 'اقساط و هزینه ',
                        data: [
                            <?php for ($i = 12; $i >=1; $i--) {
                            if ($i !== 12) {
                                echo ',';
                            }
                            echo sum_period(3, jdate("Ym", strtotime( date( 'Ym' )." -$i months" ),"","","en").'00', jdate("Ym", strtotime( date( 'Ym' )." -$i months" ),"","","en").'31')+sum_period(4, jdate("Ym", strtotime( date( 'Ym' )." -$i months" ),"","","en").'00', jdate("Ym", strtotime( date( 'Ym' )." -$i months" ),"","","en").'31');
                        }
                            ?>
                        ],
                        fill: true,
                        borderColor: '#00BCD4',
                        backgroundColor: 'rgba(0,188,212,0.30)',
                        pointBorderColor: 'rgba(233, 30, 99, 0)',
                        pointBackgroundColor: '#00BCD4',
                        pointBorderWidth: 10,
                        borderWidth: 3,
                        tension: 0.3,

                    }]
                },
                options: {
                    responsive: true,
                    legend: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },

                },

            });
        </script>


    </section>
<?php require('footer.php'); ?>