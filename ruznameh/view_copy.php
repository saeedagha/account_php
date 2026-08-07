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

?>


<section class="content">
        <div class="container-fluid">
            <?php require(get_path('/inc/btn.php')); ?>
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

<?php require(get_path('footer.php')); ?>