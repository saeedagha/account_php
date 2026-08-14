<?php
/*
 * ==============================
 * الگوهای چندتراکنشی
 * ==============================
 */

$multi_document_templates = array();

try {

    $stmt = $conn->prepare("
        SELECT
            dt.id,
            dt.name,
            dt.operation_type
        FROM document_templates dt
        WHERE dt.active = 1
          AND EXISTS (
              SELECT 1
              FROM document_template_items dti
              WHERE dti.template_id = dt.id
                AND dti.active = 1
          )
        ORDER BY dt.name ASC
    ");

    $stmt->execute();

    $multi_document_templates = $stmt->fetchAll(
        PDO::FETCH_ASSOC
    );

} catch (Exception $e) {

    $multi_document_templates = array();

}
$sandugh = sub_sandugh();
$sub_ashkhas = sub_ashkhas();
$sub_income = sub_income();
$sub_vam = sub_vam();
$sub_cost = list_sub_costs();
$cost_templates = get_document_templates('cost');
$income_templates = get_document_templates('income');
$transfer_templates = get_document_templates('transfer');
$opt = setting_tbl();
$arr =array();
foreach ($opt as $key => $value) {
    switch ($key) {
        case 'bx1' :
        if($value !==0 && !empty($value)) {    $arr['one']['bx'] = $value; }
            break ;
        case 'col_bx1' :
            if($value !==0 && !empty($value)) {    $arr['one']['col_bx'] = $value; }
            break ;
        case 'bx2' :
           if($value !==0 && !empty($value)) {    $arr['two']['bx'] = $value; }
            break ;
        case 'col_bx2' :
           if($value !==0 && !empty($value)) {    $arr['two']['col_bx'] = $value; }
            break ;
        case 'bx3' :
           if($value !==0 && !empty($value)) {    $arr['three']['bx'] = $value; }
            break ;
        case 'col_bx3' :
          if($value !==0 && !empty($value)) {     $arr['three']['col_bx'] = $value; }
            break ;
        case 'bx4' :
          if($value !==0 && !empty($value)) {     $arr['four']['bx'] = $value; }
            break ;
        case 'col_bx4' :
          if($value !==0 && !empty($value)) {     $arr['four']['col_bx'] = $value; }
            break ;
        case 'bx5' :
          if($value !==0 && !empty($value)) {     $arr['five']['bx'] = $value; }
            break ;
        case 'col_bx5' :
        if($value !==0 && !empty($value)) {       $arr['five']['col_bx'] = $value; }
            break ;
        case 'bx6' :
         if($value !==0 && !empty($value)) {     $arr['six']['bx'] = $value; }
            break ;
        case 'col_bx6' :
          if($value !==0 && !empty($value)) {     $arr['six']['col_bx'] = $value; }
            break ;
        case 'bx7' :
         if($value !==0 && !empty($value)) {      $arr['seven']['bx'] = $value; }
            break ;
        case 'col_bx7' :
            if($value !==0 && !empty($value)) {   $arr['seven']['col_bx'] = $value; }
            break ;
        case 'bx8' :
          if($value !==0 && !empty($value)) {     $arr['eight']['bx'] = $value; }
            break ;
        case 'col_bx8' :
           if($value !==0 && !empty($value)) {    $arr['eight']['col_bx'] = $value; }
            break ;



    }
}

$size =  sizeof($arr)

?>

<?php
echo '<div class="row clearfix">';
foreach ($arr as $k=>$b) {
    ?>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-<?php echo $b['col_bx']; ?> hover-expand-effect">
            <div class="icon">
                <i class="material-icons">layers</i>
            </div>
            <div class="content">
                <div class="text"><?php echo gethesabname($b['bx']); ?></div>
                <div class="number"><?php echo number_format(munde($b['bx'], '1')); ?></div>
            </div>
        </div>
    </div>


<?php }
echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
    <a href="javascript:void(0);" class="calculator_bt"
       data-toggle="modal" data-target="#calc_modal">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calculator" viewBox="0 0 16 16"> <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/> <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"/> </svg>
</a>
</div>';
echo '</div>';
?>




<!-- Transfer -->
<div class="modal fade " id="calc_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <!-- modal-col-green -->
        <div class="mtient">

            <div class="mopty">


                <div class="nk_container" dir="ltr">
                    <!--- Calc Table -->
                    <table class="nk_calculator" cellpadding="0">
                        <tbody>
                        <tr>
                            <td colspan="4"> <input class="clac-display-box" type="text" id="result"> </td>
                        </tr>
                        <tr>
                            <!-- data-display will show the number on calculator screen -->
                            <!-- value will show the number on calculator buttons -->
                            <td> <input class="calc-button" type="button" value="%" data-display="%"> </td>
                            <td class="erase-cell"> <input class="calc-button erase material-icons" type="button" value="" data-action="erase"><i class="material-icons" style="position: absolute;left: 32px;top: 27px;" >backspace</i></td>
                            <td> <input class="calc-button spcl" data-action="clear" type="button" value="C"> </td>
                            <!-- &#10005; is the html entity of divide icon -->
                            <td class="divide-cell"> <input class="calc-button incon" type="button" value="÷" data-display="/"> </td>
                        </tr>
                        <tr>
                            <td> <input class="calc-button" type="button" value="1" data-display="1"> </td>
                            <td> <input class="calc-button" type="button" value="2" data-display="2"> </td>
                            <td> <input class="calc-button" type="button" value="3" data-display="3"> </td>
                            <td class="minus-cell"> <input class="calc-button" type="button" value="-" data-display="-"> </td>
                        </tr>
                        <tr>
                            <td> <input class="calc-button" type="button" value="4" data-display="4"> </td>
                            <td> <input class="calc-button" type="button" value="5" data-display="5"> </td>
                            <td> <input class="calc-button" type="button" value="6" data-display="6"> </td>
                            <td class="plus-cell"> <input class="calc-button" type="button" value="+" data-display="+"> </td>
                        </tr>
                        <tr>
                            <td> <input class="calc-button" type="button" value="7" data-display="7"> </td>
                            <td> <input class="calc-button" type="button" value="8" data-display="8"> </td>
                            <td> <input class="calc-button" type="button" value="9" data-display="9"> </td>
                            <!-- &#10005; is the html entity of multiply icon -->
                            <td class="multiply-cell"> <input class="calc-button" type="button" value="✕" data-display="*"> </td>
                        </tr>
                        <tr>
                            <td class="dot-cell"> <input class="calc-button incon" type="button" value="000" data-display="000"> </td>
                            <td> <input class="calc-button" type="button" value="0" data-display="0"> </td>
                            <td> <input class="calc-button" type="button" value="00" data-display="00"> </td>
                            <td class="equal-cell"> <input class="calc-button incon spcl" type="button" value="=" data-action="total"> </td>

                        </tr>
                        <tr class="morerows">
                            <td class="dot-cell"> <input class="calc-button incon" type="button" value="." data-display="."> </td>
                            <td class="square-cell"> <input class="calc-button" type="button" value="√" data-action="squareroot"> </td>
                            <td class="lpar-cell"> <input class="calc-button" type="button" value="(" data-display="("> </td>
                            <td class="rpar-cell"> <input class="calc-button" type="button" value=")" data-display=")"> </td>
                        </tr>
                        <tr class="morerows">
                            <td> <input class="calc-button" type="button" value="cos" data-action="cos"> </td>
                            <td> <input class="calc-button" type="button" value="sin" data-action="sin"> </td>
                            <td> <input class="calc-button" type="button" value="tan" data-action="tan"> </td>
                            <td> <input class="calc-button" type="button" value="ln" data-action="log"> </td>

                        </tr>
                        <tr>
                            <td colspan="4"><input class="calc-button long spcl" type="button" value="History" data-action="history"></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="nk_moreitems">
                        <a href="javascript:void(0);"><i class="material-icons">keyboard_arrow_down</i></a>
                    </div>
                    <div class="nk_calc_history" style="right: -3000px;">
                        <!-- &#10006; is the html entity of cross icon. -->
                        <a href="javascript:void(0);" class="closehistory">✖</a>
                        <h2>History</h2>
                        <div></div>
                    </div>
                </div>



            </div>


        </div>
    </div>
</div>




<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="btn-groups">
                            <button type="button" class="btn bg-pink btn-block btn-lg dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                ثبت هزینه <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block"
                                       data-toggle="modal" data-target="#cost_modal">ثبت هزینه</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block"
                                       data-toggle="modal" data-target="#pay_modal">پرداخت قسط</a></li>

                                <li role="separator" class="divider"></li>
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block"
                                       data-toggle="modal" data-target="#debt_modal">قرض دادن</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="btn-groups">
                            <button type="button" class="btn bg-teal btn-block btn-lg  dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ثبت درآمد <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" data-toggle="modal" data-target="#income_modal"
                                       class=" waves-effect waves-block">ثبت درآمد</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block"
                                       data-toggle="modal" data-target="#debt_on_modal">دریافت از دیگران</a></li>

                                <li role="separator" class="divider"></li>
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block"
                                       data-toggle="modal" data-target="#loan_modal">دریافت وام</a></li>


                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="btn-groups">
                            <button type="button" class="btn bg-cyan btn-block btn-lg  dropdown-toggle"
                                    data-toggle="modal" data-target="#transfer_modal">
                                جابجایی
                            </button>

                        </div>
                    </div>

                </div>

                <div class="row clearfix" style="margin-top: 15px;">
                    <div class="col-xs-12 text-center">

                        <?php if (!empty($multi_document_templates)) { ?>

                            <button
                                    type="button"
                                    class="btn bg-indigo btn-lg waves-effect"
                                    data-toggle="modal"
                                    data-target="#multi_document_template_modal">

                                <i class="material-icons">playlist_add</i>

                                ثبت سند چندتراکنشی

                            </button>

                        <?php } ?>

                    </div>
                </div>


                <div class="row clearfix">
                    <!-- Visitors -->
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="card">
                            <div class="body bg-pink">
                                <div class="m-b--35 font-bold">هزینه ها</div>
                                <ul class="dashboard-stat-list">
                                    <?php $munde =0; foreach($sub_cost as $key=>$value){
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
                                            echo '<li>'  . gethesabname($key) . ' <span class="pull-left"><b>'  .number_format($bed). '</b> <small>ریال</small></span>
                                    </li>';
                                        }else {
                                            echo '<li>'  . gethesabname($key) . ' <span class="pull-left"><b>'  .number_format(sums($key, 1)). '</b> <small>ریال</small></span>
                                    </li>';
                                        }
                                    }
                                    ?>

                                </ul>
                                <div class="dashboard-stat-list clearfix ">
                                    <div class="font-bold m-b--35 font-17">جمع کل : <span class="pull-left"><b
                                                    class="font-17">
                                                <?php
                                              $kol = sum_kol(HAZINEH);
                                                $sums = 0;
                                                foreach ($kol as $item) {
                                                    $sums += $item['munde'];
                                                }
                                                 echo number_format(str_replace('-', '', $sums))
                                                ?></b> <small>ریال</small></span></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Visitors -->
                    <!-- Latest Social Trends -->
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="card">
                            <div class="body bg-teal" style="min-height:402px;">
                                <div class="m-b--35 font-bold">درآمد ها</div>
                                <ul class="dashboard-stat-list">

                                    <?php $munde =0; foreach($sub_income as $key=>$value){
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
                                            echo '<li>'  . gethesabname($key) . ' <span class="pull-left"><b>'  .number_format($bes). '</b> <small>ریال</small></span>
                                    </li>';
                                        }else {
                                            echo '<li>'  . gethesabname($key) . ' <span class="pull-left"><b>'  .number_format(sums($key, 0)). '</b> <small>ریال</small></span>
                                    </li>';
                                        }
                                    }
                                    ?>
                                </ul>
                                <div class="dashboard-stat-list clearfix ">
                                    <div class="font-bold m-b--35 font-17">جمع کل : <span class="pull-left"><b
                                                    class="font-17">  <?php
                                                $kol = sum_kol(DARAMAD);
                                                $sums = 0;
                                                foreach ($kol as $item) {
                                                    $sums += $item['munde'];
                                                }
                                                echo number_format(str_replace('-', '', $sums));
                                                ?></b> <small>ریال</small></span></div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- #END# Latest Social Trends -->
                    <!-- Answered Tickets -->
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="card">
                            <div class="body bg-cyan">
                                <div class="font-bold m-b--35">اشخاص</div>
                                <ul class="dashboard-stat-list">

                                    <?php $munde =0; foreach($sub_ashkhas as $key=>$value){
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
                                            echo '<li>'  . gethesabname($key) . ' <span class="pull-left"><b>'  .number_format($mu). '</b> <small>ریال</small></span>
                                    </li>';
                                        }else {
                                            echo '<li>'  . gethesabname($key) . ' <span class="pull-left"><b>'  .number_format($munde). '</b> <small>ریال</small></span>
                                    </li>';
                                        }
                                    }
                                    ?>

                                </ul>
                                <div class="dashboard-stat-list clearfix ">
                                    <div class="font-bold m-b--35 font-17">جمع کل : <span class="pull-left"><b
                                                    class="font-17"><?php
                                                $kol = sum_kol(ASHKHAS);
                                                $sums = 0;
                                                foreach ($kol as $item) {
                                                    $sums += $item['munde'];
                                                }
                                                echo number_format($sums);
                                                ?></b> <small>ریال</small></span></div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- #END# Answered Tickets -->
                </div>


            </div>
        </div>
    </div>
</div>


<!-- Transfer -->
<div class="modal fade " id="transfer_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <!-- modal-col-green -->
        <div class="modal-content modal-col-teal">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-right" id="defaultModalLabel">انتقال وجه</h4>
                <button class="close pull-left" data-dismiss="modal">×</button>
            </div>
            <hr style="border-top: 1px solid #008477;"/>
            <div class="modal-body" style="padding-bottom: 0;">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="mg-b-10">الگوی ثبت سند</p>

                        <select
                                class="form-control show-tick"
                                data-live-search="true"
                                id="document_template_transfer">

                            <option value="">-- بدون الگو --</option>

                            <?php foreach ($transfer_templates as $template) { ?>

                                <option
                                        value="<?php echo (int)$template['id']; ?>"
                                        data-hesab-bed="<?php echo (int)$template['hesab_bed']; ?>"
                                        data-hesab-bes="<?php echo (int)$template['hesab_bes']; ?>"
                                        data-sharh="<?php echo htmlspecialchars(
                                            $template['sharh'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>"
                                >
                                    <?php echo htmlspecialchars(
                                        $template['name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>
                                </option>

                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>

            <hr style="border-top: 1px solid #008477;"/>
            <div class="modal-body">


                <div class="row">
                    <div class="col-lg-6">
                        <p class="mg-b-10">تاریخ</p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div>
                            <input type="text" id="tarikh8" class="form-control fc-datepicker datep"
                                   placeholder="MM/DD/YYYY">
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-6 ">
                        <p class="mg-b-10">مبلغ</p>
                        <div class="input-group">
                            <div class="form-line">
                                <input type="tel" class="form-control" id="price8" aria-label="مبلغ به ریال"
                                       placeholder="مبلغ به ریال" onkeyup="javascript:this.value=separate(this.value);">
                            </div>

                        </div>

                    </div><!-- col-3 -->
                    <div class="col-lg-6 " style="margin-bottom: 20px;">
                        <p class="mg-b-10">از </p>
                        <select class="form-control show-tick" data-live-search="true" id="hesab8">
                            <option value="0" selected>--حساب را انتخاب نمایید--</option>
                            <?php
                            foreach ($sandugh as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '" data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>

                        </select>

                    </div><!-- col-3 -->
                    <div class="col-lg-6 ">
                        <p>
                            <b>واریز به</b>
                        </p>
                        <select class="form-control show-tick" data-live-search="true" id="cst8">

                            <option value="0" selected>--حساب را انتخاب نمایید--</option>
                            <?php
                            foreach ($sandugh as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '"  data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>

                        </select>

                    </div><!-- col-3 -->

                    <div class="clearfix"></div>
                    <br/>
                    <div class="col-lg-12">
                        <textarea rows="3" class="form-control" id="sharh8" placeholder="شرح سند"></textarea>
                    </div><!-- col -->

                </div><!-- row -->
            </div>
            <div class="modal-footer ">
                <div class="js-sweetalert pull-right">
                    <input type="hidden" name="c_cost" id="c_cost8" value="c_cost"/>
                    <button type="button" data-type="ajax-loader" class="sabt_cost8 btn bg-light-green waves-effect">
                        جابجایی
                    </button>

                </div>
                <button type="button" class="btn btn-link waves-effect pull-left" data-dismiss="modal">بستن</button>
            </div>

        </div>
    </div>
</div>


<!-- Income -->
<div class="modal fade " id="income_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <!-- modal-col-green -->
        <div class="modal-content modal-col-teal">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-right" id="income_modal">درآمد</h4>
                <button class="close pull-left" data-dismiss="modal">×</button>
            </div>
            <hr style="border-top: 1px solid #008477;"/>
            <div class="modal-body">
                <div class="modal-body" style="padding-bottom: 0;">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="mg-b-10">الگوی ثبت سند</p>

                            <select
                                    class="form-control show-tick"
                                    data-live-search="true"
                                    id="document_template_income">

                                <option value="">-- بدون الگو --</option>

                                <?php foreach ($income_templates as $template) { ?>

                                    <option
                                            value="<?php echo (int)$template['id']; ?>"
                                            data-hesab-bed="<?php echo (int)$template['hesab_bed']; ?>"
                                            data-hesab-bes="<?php echo (int)$template['hesab_bes']; ?>"
                                            data-sharh="<?php echo htmlspecialchars(
                                                $template['sharh'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                    >
                                        <?php echo htmlspecialchars(
                                            $template['name'],
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </option>

                                <?php } ?>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <p class="mg-b-10">تاریخ</p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div>
                            <input type="text" id="tarikh1" class="form-control fc-datepicker datep"
                                   placeholder="MM/DD/YYYY">
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p class="mg-b-10">مبلغ</p>
                        <div class="input-group">
                            <div class="form-line">
                                <input type="tel" class="form-control" id="price1" aria-label="مبلغ به ریال"
                                       placeholder="مبلغ به ریال" onkeyup="javascript:this.value=separate(this.value);">
                            </div>

                        </div>

                    </div><!-- col-3 -->
                    <div class="col-lg-6" style="margin-bottom: 20px;">
                        <p class="mg-b-10">بابت</p>
                        <select class="form-control show-tick" data-live-search="true" id="hesab1">
                            <option value="0" selected>--درآمد را انتخاب نمایید--</option>

                            <?php
                            foreach ($sub_income as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '"  data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>
                        </select>

                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p>
                            <b>واریز به حساب</b>
                        </p>
                        <select class="form-control show-tick" data-live-search="true" id="cst1">
                            <option value="0" selected>--حساب را انتخاب نمایید--</option>

                            <?php
                            foreach ($sandugh as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '"  data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>

                        </select>
                    </div><!-- col-3 -->

                    <div class="clearfix"></div>
                    <br/>
                    <div class="col-lg-12">
                        <textarea rows="3" class="form-control" id="sharh1" placeholder="شرح سند"></textarea>
                    </div><!-- col -->

                </div><!-- row -->
            </div>
            <div class="modal-footer ">
                <div class="js-sweetalert pull-right">
                    <input type="hidden" name="c_cost" id="c_cost1" value="c_cost"/>
                    <button type="button" data-type="ajax-loader" class="sabt_cost1 btn bg-light-green waves-effect">ثبت
                        درآمد
                    </button>

                </div>
                <button type="button" class="btn btn-link waves-effect pull-left" data-dismiss="modal">بستن</button>
            </div>

        </div>
    </div>
</div>


<!-- Debt_on -->
<div class="modal fade " id="debt_on_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <!-- modal-col-green -->
        <div class="modal-content modal-col-teal">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-right" id="income_modal">دریافت از اشخاص</h4>
                <button class="close pull-left" data-dismiss="modal">×</button>
            </div>
            <hr style="border-top: 1px solid #008477;"/>
            <div class="modal-body">


                <div class="row">
                    <div class="col-lg-6">
                        <p class="mg-b-10">تاریخ</p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div>
                            <input type="text" id="tarikh2" class="form-control fc-datepicker datep"
                                   placeholder="MM/DD/YYYY">
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p class="mg-b-10">مبلغ</p>
                        <div class="input-group">
                            <div class="form-line">
                                <input type="tel" class="form-control" id="price2" aria-label="مبلغ به ریال"
                                       placeholder="مبلغ به ریال" onkeyup="javascript:this.value=separate(this.value);">
                            </div>

                        </div>

                    </div><!-- col-3 -->
                    <div class="col-lg-6" style="margin-bottom: 20px;">
                        <p>
                            <b>به حساب</b>
                        </p>
                        <select class="form-control show-tick" data-live-search="true" id="cst2">
                            <option value="0" selected>--حساب را انتخاب نمایید--</option>

                            <?php
                            foreach ($sandugh as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '"  data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>

                        </select>

                        </select>

                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p class="mg-b-10">از کی</p>
                        <select class="form-control show-tick" data-live-search="true" id="hesab2">
                            <option value="0" selected>--شخص را انتخاب نمایید--</option>

                            <?php

                            foreach ($sub_ashkhas as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </div><!-- col-3 -->

                    <div class="clearfix"></div>
                    <br/>
                    <div class="col-lg-12">
                        <textarea rows="3" class="form-control" id="sharh2" placeholder="شرح سند"></textarea>
                    </div><!-- col -->

                </div><!-- row -->
            </div>
            <div class="modal-footer ">
                <div class="js-sweetalert pull-right">
                    <input type="hidden" name="c_cost" id="c_cost2" value="c_cost"/>
                    <button type="button" data-type="ajax-loader" class="sabt_cost2 btn bg-light-green waves-effect">
                        دریافت از اشخاص
                    </button>

                </div>
                <button type="button" class="btn btn-link waves-effect pull-left" data-dismiss="modal">بستن</button>
            </div>

        </div>
    </div>
</div>


<!-- Loan -->
<div class="modal fade " id="loan_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <!-- modal-col-green -->
        <div class="modal-content modal-col-teal">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-right">دریافت وام</h4>
                <button class="close pull-left" data-dismiss="modal">×</button>
            </div>
            <hr style="border-top: 1px solid #008477;"/>
            <div class="modal-body">


                <div class="row">
                    <div class="col-lg-6">
                        <p class="mg-b-10">تاریخ</p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div>
                            <input type="text" id="tarikh3" class="form-control fc-datepicker datep"
                                   placeholder="MM/DD/YYYY">
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p class="mg-b-10">مبلغ</p>
                        <div class="input-group">
                            <div class="form-line">
                                <input type="tel" class="form-control" id="price3" aria-label="مبلغ به ریال"
                                       placeholder="مبلغ به ریال" onkeyup="javascript:this.value=separate(this.value);">
                            </div>

                        </div>

                    </div><!-- col-3 -->
                    <div class="col-lg-6" style="margin-bottom: 20px;">
                        <p class="mg-b-10">بابت</p>
                        <select class="form-control show-tick" data-live-search="true" id="hesab3">
                            <option value="0" selected>--وام را انتخاب نمایید--</option>
                            <?php
                            foreach ($sub_vam as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            }
                            ?>
                        </select>

                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p>
                            <b>واریز به</b>
                        </p>
                        <select class="form-control show-tick" data-live-search="true" id="cst3">
                            <option value="0" selected>--حساب را انتخاب نمایید--</option>

                            <?php
                            foreach ($sandugh as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '" data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>

                        </select>
                    </div><!-- col-3 -->

                    <div class="clearfix"></div>
                    <br/>
                    <div class="col-lg-12">
                        <textarea rows="3" class="form-control" id="sharh3" placeholder="شرح سند"></textarea>
                    </div><!-- col -->

                </div><!-- row -->
            </div>
            <div class="modal-footer ">
                <div class="js-sweetalert pull-right">
                    <input type="hidden" name="c_cost" id="c_cost3" value="c_cost"/>
                    <button type="button" data-type="ajax-loader" class="sabt_cost3 btn bg-light-green waves-effect">
                        دریافت از اشخاص
                    </button>

                </div>
                <button type="button" class="btn btn-link waves-effect pull-left" data-dismiss="modal">بستن</button>
            </div>

        </div>
    </div>
</div>


<!-- Cost -->
<div class="modal fade " id="cost_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <!-- modal-col-green -->
        <div class="modal-content modal-col-pink">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-right">ثبت هزینه</h4>
                <button class="close pull-left" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body" style="padding-bottom: 0;">
                <div class="row">
                    <div class="col-lg-12">
                        <p class="mg-b-10">الگوی ثبت سند</p>

                        <select
                                class="form-control show-tick"
                                data-live-search="true"
                                id="document_template_cost"
                        >
                            <option value="">-- بدون الگو --</option>

                            <?php foreach ($cost_templates as $template) { ?>
                                <option
                                        value="<?php echo (int) $template['id']; ?>"
                                        data-hesab-bed="<?php echo (int) $template['hesab_bed']; ?>"
                                        data-hesab-bes="<?php echo (int) $template['hesab_bes']; ?>"
                                        data-sharh="<?php echo htmlspecialchars($template['sharh'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                >
                                    <?php echo htmlspecialchars($template['name'], ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>
            <hr style="border-top: 1px solid #008477;"/>
            <div class="modal-body">


                <div class="row">
                    <div class="col-lg-6">
                        <p class="mg-b-10">تاریخ</p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div>
                            <input type="text" id="tarikh4" class="form-control fc-datepicker datep"
                                   placeholder="MM/DD/YYYY">
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p class="mg-b-10">مبلغ</p>
                        <div class="input-group">
                            <div class="form-line">
                                <input type="tel" class="form-control" id="price4" aria-label="مبلغ به ریال"
                                       placeholder="مبلغ به ریال" onkeyup="javascript:this.value=separate(this.value);">
                            </div>

                        </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-6" style="margin-bottom: 20px;">
                        <p class="mg-b-10">حساب</p>
                        <select class="form-control show-tick" data-live-search="true" id="hesab4">
                            <option value="0" selected>--حساب را انتخاب نمایید--</option>
                            <?php
                            foreach ($sandugh as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '"  data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>

                        </select>

                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p>
                            <b>هزینه</b>
                        </p>
                        <select class="form-control show-tick" data-live-search="true" id="cst4">
                            <option value="0" selected>--هزینه را انتخاب نمایید--</option>
                            <?php
                            foreach ($sub_cost as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '" data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>


                        </select>
                    </div><!-- col-3 -->

                    <div class="clearfix"></div>
                    <br/>
                    <div class="col-lg-12">
                        <textarea rows="3" class="form-control" id="sharh4" placeholder="شرح سند"></textarea>
                    </div><!-- col -->

                </div><!-- row -->
            </div>
            <div class="modal-footer ">
                <div class="js-sweetalert pull-right">
                    <input type="hidden" name="c_cost" id="c_cost4" value="c_cost"/>
                    <button type="button" data-type="ajax-loader" class="sabt_cost4 btn bg-light-green waves-effect">ثبت
                        هزینه
                    </button>

                </div>
                <button type="button" class="btn btn-link waves-effect pull-left" data-dismiss="modal">بستن</button>
            </div>

        </div>
    </div>
</div>


<!-- ِDebt -->
<div class="modal fade " id="debt_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <!-- modal-col-green -->
        <div class="modal-content modal-col-pink">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-right">قرض دادن</h4>
                <button class="close pull-left" data-dismiss="modal">×</button>
            </div>
            <hr style="border-top: 1px solid #008477;"/>
            <div class="modal-body">


                <div class="row">
                    <div class="col-lg-6">
                        <p class="mg-b-10">تاریخ</p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div>
                            <input type="text" id="tarikh6" class="form-control fc-datepicker datep"
                                   placeholder="MM/DD/YYYY">
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p class="mg-b-10">مبلغ</p>
                        <div class="input-group">
                            <div class="form-line">
                                <input type="tel" class="form-control" id="price6" aria-label="مبلغ به ریال"
                                       placeholder="مبلغ به ریال" onkeyup="javascript:this.value=separate(this.value);">
                            </div>

                        </div>

                    </div><!-- col-3 -->
                    <div class="col-lg-6" style="margin-bottom: 20px;">
                        <p class="mg-b-10">از حساب</p>
                        <select class="form-control show-tick" data-live-search="true" id="hesab6">
                            <option value="0" selected>--حساب را انتخاب نمایید--</option>

                            <?php
                            foreach ($sandugh as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '" data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>

                        </select>

                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p>
                            <b>به کی</b>
                        </p>
                        <select class="form-control show-tick" data-live-search="true" id="cst6">

                            <option value="0" selected>--شخص را انتخاب نمایید--</option>
                            <?php

                            foreach ($sub_ashkhas as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            }
                            ?>

                        </select>
                    </div><!-- col-3 -->

                    <div class="clearfix"></div>
                    <br/>
                    <div class="col-lg-12">
                        <textarea rows="3" class="form-control" id="sharh6" placeholder="شرح سند"></textarea>
                    </div><!-- col -->

                </div><!-- row -->
            </div>
            <div class="modal-footer ">
                <div class="js-sweetalert pull-right">
                    <input type="hidden" name="c_cost" id="c_cost6" value="c_cost"/>
                    <button type="button" data-type="ajax-loader" class="sabt_cost6 btn bg-light-green waves-effect">قرض
                        دادن
                    </button>

                </div>
                <button type="button" class="btn btn-link waves-effect pull-left" data-dismiss="modal">بستن</button>
            </div>

        </div>
    </div>
</div>


<!-- Payment -->
<div class="modal fade " id="pay_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <!-- modal-col-green -->
        <div class="modal-content modal-col-pink">
            <div class="modal-header clearfix">
                <h4 class="modal-title pull-right">پرداخت قسط</h4>
                <button class="close pull-left" data-dismiss="modal">×</button>
            </div>
            <hr style="border-top: 1px solid #008477;"/>
            <div class="modal-body">


                <div class="row">
                    <div class="col-lg-6">
                        <p class="mg-b-10">تاریخ</p>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div>
                            <input type="text" id="tarikh7" class="form-control fc-datepicker datep"
                                   placeholder="MM/DD/YYYY">
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p class="mg-b-10">مبلغ</p>
                        <div class="input-group">
                            <div class="form-line">
                                <input type="tel" class="form-control" id="price7" aria-label="مبلغ به ریال"
                                       placeholder="مبلغ به ریال" onkeyup="javascript:this.value=separate(this.value);">
                            </div>

                        </div>

                    </div><!-- col-3 -->
                    <div class="col-lg-6" style="margin-bottom: 20px;">
                        <p class="mg-b-10">حساب</p>
                        <select class="form-control show-tick" data-live-search="true" id="hesab7">
                            <option value="0" selected>--حساب را انتخاب نمایید--</option>

                            <?php
                            foreach ($sandugh as $key => $value) {
                                if (is_array($value)) {
                                    echo '<optgroup label="' . gethesabname($key) . '">';
                                    foreach ($value as $keys => $values) {
                                        echo '<option value="' . $keys . '" data-tokens="' . gethesabname($keys) . '">' . $values . '</option>';
                                    }
                                    echo '</optgroup>';
                                } else {
                                    echo '<option value="' . $key . '" data-tokens="' . gethesabname($key) . '">' . $value . '</option>';
                                }
                            }
                            ?>

                        </select>

                    </div><!-- col-3 -->
                    <div class="col-lg-6">
                        <p>
                            <b>وام</b>
                        </p>
                        <select class="form-control show-tick" data-live-search="true" id="cst7">
                            <option value="0" selected>--وام را انتخاب نمایید--</option>

                            <?php
                            foreach ($sub_vam as $key => $value) {
                                echo '<option value="' . $key . '">' . $value . '</option>';
                            }
                            ?>

                        </select>
                    </div><!-- col-3 -->

                    <div class="clearfix"></div>
                    <br/>
                    <div class="col-lg-12">
                        <textarea rows="3" class="form-control" id="sharh7" placeholder="شرح سند"></textarea>
                    </div><!-- col -->

                </div><!-- row -->
            </div>
            <div class="modal-footer ">
                <div class="js-sweetalert pull-right">
                    <input type="hidden" name="c_cost" id="c_cost7" value="c_cost"/>
                    <button type="button" data-type="ajax-loader" class="sabt_cost7 btn bg-light-green waves-effect">
                        پرداخت قسط

                    </button>

                </div>
                <button type="button" class="btn btn-link waves-effect pull-left" data-dismiss="modal">بستن</button>
            </div>

        </div>
    </div>
</div>


<!-- Multi Transaction Template -->
<div
        class="modal fade"
        id="multi_document_template_modal"
        tabindex="-1"
        role="dialog"
        style="display: none;">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content modal-col-indigo">

            <div class="modal-header clearfix">

                <h4 class="modal-title pull-right">
                    ثبت سند چندتراکنشی
                </h4>

                <button
                        type="button"
                        class="close pull-left"
                        data-dismiss="modal">
                    ×
                </button>

            </div>

            <hr style="border-top: 1px solid #3F51B5;"/>

            <div class="modal-body">

                <div class="row">

                    <div class="col-lg-6">

                        <p class="mg-b-10">
                            الگوی ثبت سند
                        </p>

                        <select
                                class="form-control show-tick"
                                data-live-search="true"
                                id="multi_document_template">

                            <option value="">
                                -- الگو را انتخاب نمایید --
                            </option>

                            <?php foreach (
                                $multi_document_templates
                                as $template
                            ) { ?>

                                <option
                                        value="<?php echo (int)$template['id']; ?>">

                                    <?php echo htmlspecialchars(
                                        $template['name'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <div class="col-lg-6">

                        <p class="mg-b-10">
                            تاریخ
                        </p>

                        <div class="input-group">

                            <div class="input-group-prepend">

                                <div class="input-group-text">

                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>

                                </div>

                            </div>

                            <input
                                    type="text"
                                    id="multi_document_date"
                                    class="form-control fc-datepicker datep"
                                    placeholder="MM/DD/YYYY">

                        </div>

                    </div>

                </div>


                <hr>


                <div id="multi_document_template_items">

                    <div class="alert alert-info text-center">

                        ابتدا یک الگو را انتخاب نمایید.

                    </div>

                </div>


                <div
                        id="multi_document_template_balance"
                        style="display:none; margin-top:15px;">

                    <div class="row">

                        <div class="col-md-4">

                            <div class="alert alert-info text-center">

                                <strong>
                                    جمع بدهکار
                                </strong>

                                <br>

                                <span
                                        id="multi_total_bed">
                                    0
                                </span>

                                ریال

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="alert alert-info text-center">

                                <strong>
                                    جمع بستانکار
                                </strong>

                                <br>

                                <span
                                        id="multi_total_bes">
                                    0
                                </span>

                                ریال

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div
                                    id="multi_balance_status"
                                    class="alert alert-warning text-center">

                                در انتظار ورود مبلغ

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                        type="button"
                        id="save_multi_document_template"
                        data-type="ajax-loader"
                        class="btn bg-light-green waves-effect">

                    ثبت سند

                </button>


                <button
                        type="button"
                        class="btn btn-link waves-effect pull-left"
                        data-dismiss="modal">

                    بستن

                </button>

            </div>

        </div>

    </div>

</div>
							
 