<?php
$titlepage = "نمایش حساب";
require_once '../inc/config/autoload.php';
require(get_path('header.php'));
if(isset($_GET['view']) ) {
//session_start();
    $_SESSION['idss'] = addslashes(htmlentities($_GET["view"]));
    $view = (int)addslashes(htmlentities($_GET["view"]));
    if (!empty($view) && isset($view)) {
        $sql = "SELECT * FROM ";
        $sql .= "`hesabha` WHERE ";
        $sql .= "`id` = $view";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $row=  $stm->fetch(PDO::FETCH_ASSOC);
    }
}
/*
SELECT hesab_bed, COUNT(*) AS count, SUM(price) AS total_price FROM `ruznameh` WHERE hesab_bed=149 GROUP BY LEFT(date, 6) ORDER BY `ruznameh`.`date`;
*/

?>


<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                   <div class="card">
                         <div class="body">
                             <div class="row">
                 <div class="col-md-4">        
           <table class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_simple2">

                                    <thead>
                                    <tr>
                                        <th>حساب</th>
                                        <th>مبلغ</th>
                                         <th>تعداد</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>حساب</th>
                                        <th>مبلغ</th>
                                             <th>تعداد</th
                                    </tr>
                                    </tfoot>

                                    <tbody >

                                    <?php


                                    try {
                                     
                                        $sql = "SELECT hesab_bed, LEFT(date, 6) as month, COUNT(*) AS count, SUM(price) AS total_price FROM `ruznameh` WHERE hesab_bed=$view GROUP BY LEFT(date, 6) ORDER BY `ruznameh`.`date`";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $row4 = $stmt->fetchAll(PDO::FETCH_OBJ);
                                        $nn=0;
                                        foreach ($row4 as $gb) {
                                            // print_r($gb); ?>
                                            <tr><td><?php echo $gb->month; ?></td><td><?php echo number_format($gb->total_price); ?></td><td><?php echo number_format($gb->count); ?></td></tr>
                                         <?php   $nn += $gb->total_price;
                                        }



                                    } catch (Exception $e) {
                                        echo $e->getMessage();
                                    }
                                    ?>


                                    </tbody>
                                </table>

<p> جمع کل  : <strong class="font-bold col-pink">
                                       <?php echo number_format( $nn); ?></strong> ریال</p>
            
            </div>
               <div class="col-md-8 my-5" style="margin: 100px auto;">


                            <canvas id="line_chart" height="190" ></canvas>

                        </div>
                        
                     </div>     
         </div>
              </div>
              </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                           نمایش حساب " <?php echo $row['h_name']; ?> "
                            </h2>
                    
                        </div>
                        <div class="body">
                            <div class="table-responsive container">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable tbl_ms">
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
                                    <tbody>
                                    <?php






try{
$sql = "SELECT * FROM `ruznameh` WHERE $view IN(`hesab_bed`, `hesab_bes`) ";
    
$stm = $conn->prepare($sql);
 $stm->execute();

$stm->setFetchMode(PDO::FETCH_ASSOC);

while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {  
    ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo date_sep($row['date']) ; ?></td>
    
<td class="font-bold col-pink">
    <a href="<?php echo BASE_URL; ?>/ruznameh/view.php?view=<?php echo $row['hesab_bed']; ?>" class="col-pink">
    <?php
    $hesab = display_hesab($row['hesab_bed']);
      $List = implode(' » ', $hesab);
         echo $List;
     ?></a>
</td>
      <td class="font-bold col-teal">
        <a href="<?php echo BASE_URL; ?>/ruznameh/view.php?view=<?php echo $row['hesab_bes']; ?>" class="col-teal">
            <?php
            $hesab = display_hesab($row['hesab_bes']);
            $List = implode(' » ', $hesab);
            echo $List;
            ?></a>
    </td>
      <td><?php echo $row['sharh']; ?></td>
      <td><a href="<?php echo BASE_URL; ?>/ruznameh/edit.php?edit=<?php echo $row['id']; ?>"><?php echo number_format( $row['price']); ?></a></td>
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
                    </div>
                </div>
            </div>
            <!-- #END# Basic Examples -->
   
        </div>
    </section>
        <script src="<?php echo BASE_URL; ?>/inc/assets/js/chart.js"></script>
      <script>
            const ctx = document.getElementById('line_chart').getContext("2d");

            new Chart(ctx, {
                type: 'line',

                data: {
                    labels: [
                        <?php
                        $g =0;
  foreach ($row4 as $gb) {
        if($g !==sizeof($row4)){echo ',';}
    echo  $gb->month;
    $g++;
  }
  ?>
                       ],

                    datasets: [
                        {
                           label:  '<?php echo gethesabname($view); ?> ',
                        data: [
                           <?php
                        $g =0;
  foreach ($row4 as $gb) {
        if($g !==sizeof($row4)){echo ',';}
    echo  $gb->total_price;
    $g++;
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

<?php require(get_path('footer.php')); ?>