  <!-- Jquery Core Js -->
  <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery/jquery.min.js"></script>
 
<script src="<?php echo BASE_URL; ?>/inc/assets/js/jalali_fix_date_picker.js"></script>
<!-- Bootstrap Core Js -->
<script src="<?php echo BASE_URL; ?>/inc/plugins/bootstrap/js/bootstrap.js"></script>
<!-- Select Plugin Js -->
<script src="<?php echo BASE_URL; ?>/inc/plugins/bootstrap-select/js/bootstrap-select.js"></script>
  <script src="<?php echo BASE_URL; ?>/inc/assets/js/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/inc/assets/js/bootstrap-datepicker.fa.min.js"></script>
<!-- Slimscroll Plugin Js -->
<script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
<!-- Waves Effect Plugin Js -->
<script src="<?php echo BASE_URL; ?>/inc/plugins/node-waves/waves.js"></script>
 <!-- Jquery DataTable Plugin Js -->
 <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
  <script src="<?php echo BASE_URL; ?>/inc/plugins/sweetalert/sweetalert.min.js"></script><!-- ADD-User.php -->
  <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-validation/jquery.validate.js"></script>
  <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
  <script src="<?php echo BASE_URL; ?>/inc/assets/js/print.min.js"></script>
  <!-- Dropzone Plugin Js -->
  <script src="<?php echo BASE_URL; ?>/inc/plugins/dropzone/dropzone.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/assets/js/jquery.readall.min.js"></script>
<!-- Custom Js -->
<script src="<?php echo BASE_URL; ?>/inc/assets/js/admin.js"></script>
<!-- Custom Js -->
<script src="<?php echo BASE_URL; ?>/inc/assets/js/script.js"></script>
  <script src="<?php echo BASE_URL; ?>/inc/assets/js/demo.js"></script>
<!-- Demo Js -->
<script src="<?php  echo BASE_URL;  ?>/inc/assets/js/script-min.js"></script>
<style>
    .readall{
        position:relative;
        box-sizing:border-box
        
    }
    .readall-wrapper{}
    .readall-button{
     display:inline-block;
        width:100%;
        padding: 10px 0;
        border: 1px solid #0000000f;
        background: #6c6c6c7a;
        text-align:center;
        cursor:pointer;
  
         -webkit-box-shadow: 0px -30px 109px -34px rgb(0,0,0,1);
        -moz-box-shadow: 0px -30px 109px -34px rgb(0,0,0,1);
        box-shadow: 0px -30px 109px -34px rgb(0,0,0,1);
    }
    .readall-button:hover{
        color:#fff;
        background:silver
        
    }
    .readall-hide:after{
        content:"";
        display:inline-block;
        position:absolute;
        bottom:0;
        right:0;
        width:100%;
        height:25px;
        
    }
 .readall-hide {
  opacity: 0.8;
}
div.dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200px;
    margin-left: -100px;
    margin-top: -26px;
    text-align: center;
    padding: 2px;
    z-index: 10;
}
div.dataTables_processing>div:last-child {
    position: relative;
    width: 80px;
    height: 15px;
    margin: 1em auto;
}
div.dataTables_processing>div:last-child>div {
    position: absolute;
    top: 0;
    width: 13px;
    height: 13px;
    border-radius: 50%;
    background: rgb(13, 110, 253);
    animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
div.dataTables_processing>div:last-child>div:nth-child(1) {
    left: 8px;
    animation: datatables-loader-1 .6s infinite;
}
div.dataTables_processing>div:last-child>div:nth-child(2) {
    left: 8px;
    animation: datatables-loader-2 .6s infinite;
}
div.dataTables_processing>div:last-child>div:nth-child(3) {
    left: 32px;
    animation: datatables-loader-2 .6s infinite;
}
div.dataTables_processing>div:last-child>div:nth-child(4) {
    left: 56px;
    animation: datatables-loader-3 .6s infinite;
}
@keyframes datatables-loader-1{0%{transform:scale(0)}100%{transform:scale(1)}}
@keyframes datatables-loader-3{0%{transform:scale(1)}100%{transform:scale(0)}}
@keyframes datatables-loader-2{0%{transform:translate(0, 0)}100%{transform:translate(24px, 0)}}
</style>
<script>
    $('#document_template_cost').on('change', function () {
        var option = $(this).find('option:selected');
        var hesabBed = option.data('hesab-bed');
        var hesabBes = option.data('hesab-bes');
        var sharh = option.data('sharh');
        // بدون الگو
        if (!this.value) {
            return;
        }
        // حساب بدهکار
        if (hesabBed) {
            $('#cst4').val(hesabBed).trigger('change');
        }
        // حساب بستانکار
        if (hesabBes) {
            $('#hesab4').val(hesabBes).trigger('change');
        }
        // شرح
        if (sharh) {
            $('#sharh4').val(sharh);
        }
    });
        $(document).ready(function () {
            $('.dashboard-stat-list').readall({
                // Default values
                showheight: 220,                         // height to show
                showrows: null,                         // rows to show (overrides showheight)
                animationspeed: 200,                    // speed of transition
                btnTextShowmore: 'بازکردن',           // text shown on button to show more
                btnTextShowless: 'بستن',           // text shown on button to show less
                btnClassShowmore: 'readall-button',     // class(es) on button to show more
                btnClassShowless: 'readall-button'      // class(es) on button to show less
            });
        });
    </script>
  <script>
      $('.delete_bj').on('click',function(e){
          e.preventDefault();
          var form = $(this).parents('form');
          swal({
              title: "ایا مطمئنید؟",
              text: " عملیات حذف حساب غیرقابل بازگشت می باشد",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "حذف کن بره!",
              cancelButtonText: "نه منصرف شدم",
              closeOnConfirm: false,
              closeOnCancel: false
          }, function (isConfirm) {
              if (isConfirm) {
                  swal("حذف شد!", "حساب حذف شد.", "success");
                  if (isConfirm) form.submit();
              } else {
                  swal("لغو شد", "تعییری در حساب ایجاد نشد :)", "error");
              }
          });
      });
  <?php if(isset($error) && !empty($error)) { ?>
      swal({
          title: "<?php echo $error['message']; ?>",
          timer: 3000,
          <?php if($error['color'] == 'teal') {
             echo '  type: "success",';
          }else{
            echo   'type: "warning",';
          } ?>
          showConfirmButton: true
      },
          function(){
              location.reload();
          });
<?php } ?>
  </script>
  <script>
      //Prevent Submit Form Reload Page
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }
      jQuery('.sabt_cost4').on('click', function () {
          var x = document.getElementById("tarikh4").value;
          if (x == "") {
              swal({
                  title: "خطا",
                  text: "تاریخ را وارد نمایید",
                  icon: "warning",
              });
              return false;
          }
          var y = document.getElementById("hesab4").value;
          var z = document.getElementById("cst4").value;
          var w = document.getElementById("price4").value;
          if (w == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (z == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (y == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          var type = $(this).data('type');
          if (type === 'ajax-loader') {
              var hesab = $("#hesab4").val();
              var tarikh = $("#tarikh4").val();
              var cst = $("#cst4").val();
              var price = $("#price4").val();
              var sharh = $("#sharh4").val();
              var c_cost = $("#c_cost4").val();
              swal({
                  title: "افزودن تراکنش جدید",
                  text: "بر روی افزودن کلیک نمایید",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "افزودن",
                  confirmButtonColor: "#1EA64A",
                  cancelButtonColor: "#E4A220",
                  cancelButtonText: "لغو",
                  showLoaderOnConfirm: true,
              }, function () {
                  $.post( "<?php echo BASE_URL; ?>/inc/config/create.php",{
                          tarikh: tarikh,
                          hesab: hesab,
                          cst: cst,
                          price: price,
                          sharh: sharh,
                          c_cost: c_cost,
                      },
                      function( data ) {
                          var result = jQuery.parseJSON(data);
                          if(result.res=="registered") {
                              //  $("input[type=text], textarea").val("");
                              swal("موفق", "تراکنش جدید ثبت شد", "success");
                              setTimeout(function(){
                                  location.reload();
                              }, 1000);
                          }else if(result.res=="bad error") {
                              swal("ناموفق", "مشکلی در ثبت پیش آمد", "error");
                          }else {
                              swal("نا موفق", "مشکلی در ثبت پیش آمد با مدیر سیستم تماس بگیرید", "error");
                          }
                      });
              });
          }
      });
      jQuery('.sabt_cost').on('click', function () {
          var x = document.getElementById("tarikh").value;
          if (x == "") {
              swal({
                  title: "خطا",
                  text: "تاریخ را وارد نمایید",
                  icon: "warning",
              });
              return false;
          }
          var y = document.getElementById("hesab").value;
          var z = document.getElementById("cst").value;
          var w = document.getElementById("price").value;
          if (w == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (z == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (y == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          var type = $(this).data('type');
          if (type === 'ajax-loader') {
              var hesab = $("#hesab").val();
              var tarikh = $("#tarikh").val();
              var cst = $("#cst").val();
              var price = $("#price").val();
              var sharh = $("#sharh").val();
              var c_cost = $("#c_cost").val();
              swal({
                  title: "افزودن تراکنش جدید",
                  text: "بر روی افزودن کلیک نمایید",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "افزودن",
                  confirmButtonColor: "#1EA64A",
                  cancelButtonColor: "#E4A220",
                  cancelButtonText: "لغو",
                  showLoaderOnConfirm: true,
              }, function () {
                  $.post( "<?php echo BASE_URL; ?>/inc/config/create.php",{
                          tarikh: tarikh,
                          hesab: hesab,
                          cst: cst,
                          price: price,
                          sharh: sharh,
                          c_cost: c_cost,
                      },
                      function( data ) {
                          var result = jQuery.parseJSON(data);
                          if(result.res=="registered") {
                              //  $("input[type=text], textarea").val("");
                              swal("موفق", "تراکنش جدید ثبت شد", "success");
                              setTimeout(function(){
                                  location.reload();
                              }, 1000);
                          }else if(result.res=="bad error") {
                              swal("ناموفق", "مشکلی در ثبت پیش آمد", "error");
                          }else {
                              swal("نا موفق", "مشکلی در ثبت پیش آمد با مدیر سیستم تماس بگیرید", "error");
                          }
                      });
              });
          }
      });
      jQuery('.sabt_cost1').on('click', function () {
          var x = document.getElementById("tarikh1").value;
          if (x == "") {
              swal({
                  title: "خطا",
                  text: "تاریخ را وارد نمایید",
                  icon: "warning",
              });
              return false;
          }
          var y = document.getElementById("hesab1").value;
          var z = document.getElementById("cst1").value;
          var w = document.getElementById("price1").value;
          if (w == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (z == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (y == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          var type = $(this).data('type');
          if (type === 'ajax-loader') {
              var hesab = $("#hesab1").val();
              var tarikh = $("#tarikh1").val();
              var cst = $("#cst1").val();
              var price = $("#price1").val();
              var sharh = $("#sharh1").val();
              var c_cost = $("#c_cost1").val();
              swal({
                  title: "افزودن تراکنش جدید",
                  text: "بر روی افزودن کلیک نمایید",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "افزودن",
                  confirmButtonColor: "#1EA64A",
                  cancelButtonColor: "#E4A220",
                  cancelButtonText: "لغو",
                  showLoaderOnConfirm: true,
              }, function () {
                  $.post( "<?php echo BASE_URL; ?>/inc/config/create.php",{
                          tarikh: tarikh,
                          hesab: hesab,
                          cst: cst,
                          price: price,
                          sharh: sharh,
                          c_cost: c_cost,
                      },
                      function( data ) {
                          var result = jQuery.parseJSON(data);
                          if(result.res=="registered") {
                              //  $("input[type=text], textarea").val("");
                              swal("موفق", "تراکنش جدید ثبت شد", "success");
                              setTimeout(function(){
                                  location.reload();
                              }, 1000);
                          }else if(result.res=="bad error") {
                              swal("ناموفق", "مشکلی در ثبت پیش آمد", "error");
                          }else {
                              swal("نا موفق", "مشکلی در ثبت پیش آمد با مدیر سیستم تماس بگیرید", "error");
                          }
                      });
              });
          }
      });
      jQuery('.sabt_cost2').on('click', function () {
          var x = document.getElementById("tarikh2").value;
          if (x == "") {
              swal({
                  title: "خطا",
                  text: "تاریخ را وارد نمایید",
                  icon: "warning",
              });
              return false;
          }
          var y = document.getElementById("hesab2").value;
          var z = document.getElementById("cst2").value;
          var w = document.getElementById("price2").value;
          if (w == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (z == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (y == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          var type = $(this).data('type');
          if (type === 'ajax-loader') {
              var hesab = $("#hesab2").val();
              var tarikh = $("#tarikh2").val();
              var cst = $("#cst2").val();
              var price = $("#price2").val();
              var sharh = $("#sharh2").val();
              var c_cost = $("#c_cost2").val();
              swal({
                  title: "افزودن تراکنش جدید",
                  text: "بر روی افزودن کلیک نمایید",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "افزودن",
                  confirmButtonColor: "#1EA64A",
                  cancelButtonColor: "#E4A220",
                  cancelButtonText: "لغو",
                  showLoaderOnConfirm: true,
              }, function () {
                  $.post( "<?php echo BASE_URL; ?>/inc/config/create.php",{
                          tarikh: tarikh,
                          hesab: hesab,
                          cst: cst,
                          price: price,
                          sharh: sharh,
                          c_cost: c_cost,
                      },
                      function( data ) {
                          var result = jQuery.parseJSON(data);
                          if(result.res=="registered") {
                              //  $("input[type=text], textarea").val("");
                              swal("موفق", "تراکنش جدید ثبت شد", "success");
                              setTimeout(function(){
                                  location.reload();
                              }, 1000);
                          }else if(result.res=="bad error") {
                              swal("ناموفق", "مشکلی در ثبت پیش آمد", "error");
                          }else {
                              swal("نا موفق", "مشکلی در ثبت پیش آمد با مدیر سیستم تماس بگیرید", "error");
                          }
                      });
              });
          }
      });
      jQuery('.sabt_cost3').on('click', function () {
          var x = document.getElementById("tarikh3").value;
          if (x == "") {
              swal({
                  title: "خطا",
                  text: "تاریخ را وارد نمایید",
                  icon: "warning",
              });
              return false;
          }
          var y = document.getElementById("hesab3").value;
          var z = document.getElementById("cst3").value;
          var w = document.getElementById("price3").value;
          if (w == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (z == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (y == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          var type = $(this).data('type');
          if (type === 'ajax-loader') {
              var hesab = $("#hesab3").val();
              var tarikh = $("#tarikh3").val();
              var cst = $("#cst3").val();
              var price = $("#price3").val();
              var sharh = $("#sharh3").val();
              var c_cost = $("#c_cost3").val();
              swal({
                  title: "افزودن تراکنش جدید",
                  text: "بر روی افزودن کلیک نمایید",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "افزودن",
                  confirmButtonColor: "#1EA64A",
                  cancelButtonColor: "#E4A220",
                  cancelButtonText: "لغو",
                  showLoaderOnConfirm: true,
              }, function () {
                  $.post( "<?php echo BASE_URL; ?>/inc/config/create.php",{
                          tarikh: tarikh,
                          hesab: hesab,
                          cst: cst,
                          price: price,
                          sharh: sharh,
                          c_cost: c_cost,
                      },
                      function( data ) {
                          var result = jQuery.parseJSON(data);
                          if(result.res=="registered") {
                              //  $("input[type=text], textarea").val("");
                              swal("موفق", "تراکنش جدید ثبت شد", "success");
                              setTimeout(function(){
                                  location.reload();
                              }, 1000);
                          }else if(result.res=="bad error") {
                              swal("ناموفق", "مشکلی در ثبت پیش آمد", "error");
                          }else {
                              swal("نا موفق", "مشکلی در ثبت پیش آمد با مدیر سیستم تماس بگیرید", "error");
                          }
                      });
              });
          }
      });
      jQuery('.sabt_cost5').on('click', function () {
          var x = document.getElementById("tarikh5").value;
          if (x == "") {
              swal({
                  title: "خطا",
                  text: "تاریخ را وارد نمایید",
                  icon: "warning",
              });
              return false;
          }
          var y = document.getElementById("hesab5").value;
          var z = document.getElementById("cst5").value;
          var w = document.getElementById("price5").value;
          if (w == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (z == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (y == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          var type = $(this).data('type');
          if (type === 'ajax-loader') {
              var hesab = $("#hesab5").val();
              var tarikh = $("#tarikh5").val();
              var cst = $("#cst5").val();
              var price = $("#price5").val();
              var sharh = $("#sharh5").val();
              var c_cost = $("#c_cost5").val();
              swal({
                  title: "افزودن تراکنش جدید",
                  text: "بر روی افزودن کلیک نمایید",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "افزودن",
                  confirmButtonColor: "#1EA64A",
                  cancelButtonColor: "#E4A220",
                  cancelButtonText: "لغو",
                  showLoaderOnConfirm: true,
              }, function () {
                  $.post( "<?php echo BASE_URL; ?>/inc/config/create.php",{
                          tarikh: tarikh,
                          hesab: hesab,
                          cst: cst,
                          price: price,
                          sharh: sharh,
                          c_cost: c_cost,
                      },
                      function( data ) {
                          var result = jQuery.parseJSON(data);
                          if(result.res=="registered") {
                              //  $("input[type=text], textarea").val("");
                              swal("موفق", "تراکنش جدید ثبت شد", "success");
                              setTimeout(function(){
                                  location.reload();
                              }, 1000);
                          }else if(result.res=="bad error") {
                              swal("ناموفق", "مشکلی در ثبت پیش آمد", "error");
                          }else {
                              swal("نا موفق", "مشکلی در ثبت پیش آمد با مدیر سیستم تماس بگیرید", "error");
                          }
                      });
              });
          }
      });
      jQuery('.sabt_cost6').on('click', function () {
          var x = document.getElementById("tarikh6").value;
          if (x == "") {
              swal({
                  title: "خطا",
                  text: "تاریخ را وارد نمایید",
                  icon: "warning",
              });
              return false;
          }
          var y = document.getElementById("hesab6").value;
          var z = document.getElementById("cst6").value;
          var w = document.getElementById("price6").value;
          if (w == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (z == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (y == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          var type = $(this).data('type');
          if (type === 'ajax-loader') {
              var hesab = $("#hesab6").val();
              var tarikh = $("#tarikh6").val();
              var cst = $("#cst6").val();
              var price = $("#price6").val();
              var sharh = $("#sharh6").val();
              var c_cost = $("#c_cost6").val();
              swal({
                  title: "افزودن تراکنش جدید",
                  text: "بر روی افزودن کلیک نمایید",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "افزودن",
                  confirmButtonColor: "#1EA64A",
                  cancelButtonColor: "#E4A220",
                  cancelButtonText: "لغو",
                  showLoaderOnConfirm: true,
              }, function () {
                  $.post( "<?php echo BASE_URL; ?>/inc/config/create.php",{
                          tarikh: tarikh,
                          hesab: hesab,
                          cst: cst,
                          price: price,
                          sharh: sharh,
                          c_cost: c_cost,
                      },
                      function( data ) {
                          var result = jQuery.parseJSON(data);
                          if(result.res=="registered") {
                              //  $("input[type=text], textarea").val("");
                              swal("موفق", "تراکنش جدید ثبت شد", "success");
                              setTimeout(function(){
                                  location.reload();
                              }, 1000);
                          }else if(result.res=="bad error") {
                              swal("ناموفق", "مشکلی در ثبت پیش آمد", "error");
                          }else {
                              swal("نا موفق", "مشکلی در ثبت پیش آمد با مدیر سیستم تماس بگیرید", "error");
                          }
                      });
              });
          }
      });
      jQuery('.sabt_cost7').on('click', function () {
          var x = document.getElementById("tarikh7").value;
          if (x == "") {
              swal({
                  title: "خطا",
                  text: "تاریخ را وارد نمایید",
                  icon: "warning",
              });
              return false;
          }
          var y = document.getElementById("hesab7").value;
          var z = document.getElementById("cst7").value;
          var w = document.getElementById("price7").value;
          if (w == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (z == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (y == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          var type = $(this).data('type');
          if (type === 'ajax-loader') {
              var hesab = $("#hesab7").val();
              var tarikh = $("#tarikh7").val();
              var cst = $("#cst7").val();
              var price = $("#price7").val();
              var sharh = $("#sharh7").val();
              var c_cost = $("#c_cost7").val();
              swal({
                  title: "افزودن تراکنش جدید",
                  text: "بر روی افزودن کلیک نمایید",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "افزودن",
                  confirmButtonColor: "#1EA64A",
                  cancelButtonColor: "#E4A220",
                  cancelButtonText: "لغو",
                  showLoaderOnConfirm: true,
              }, function () {
                  $.post( "<?php echo BASE_URL; ?>/inc/config/create.php",{
                          tarikh: tarikh,
                          hesab: hesab,
                          cst: cst,
                          price: price,
                          sharh: sharh,
                          c_cost: c_cost,
                      },
                      function( data ) {
                          var result = jQuery.parseJSON(data);
                          if(result.res=="registered") {
                              //  $("input[type=text], textarea").val("");
                              swal("موفق", "تراکنش جدید ثبت شد", "success");
                              setTimeout(function(){
                                  location.reload();
                              }, 1000);
                          }else if(result.res=="bad error") {
                              swal("ناموفق", "مشکلی در ثبت پیش آمد", "error");
                          }else {
                              swal("نا موفق", "مشکلی در ثبت پیش آمد با مدیر سیستم تماس بگیرید", "error");
                          }
                      });
              });
          }
      });
      jQuery('.sabt_cost8').on('click', function () {
          var x = document.getElementById("tarikh8").value;
          if (x == "") {
              swal({
                  title: "خطا",
                  text: "تاریخ را وارد نمایید",
                  icon: "warning",
              });
              return false;
          }
          var y = document.getElementById("hesab8").value;
          var z = document.getElementById("cst8").value;
          var w = document.getElementById("price8").value;
          if (w == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (z == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          if (y == "") {
              swal({
                  title: "خطا",
                  text: "تمامی اطلاعات باید وارد شوند",
                  icon: "warning",
              });
              return false;
          }
          var type = $(this).data('type');
          if (type === 'ajax-loader') {
              var hesab = $("#hesab8").val();
              var tarikh = $("#tarikh8").val();
              var cst = $("#cst8").val();
              var price = $("#price8").val();
              var sharh = $("#sharh8").val();
              var c_cost = $("#c_cost8").val();
              swal({
                  title: "افزودن تراکنش جدید",
                  text: "بر روی افزودن کلیک نمایید",
                  type: "info",
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "افزودن",
                  confirmButtonColor: "#1EA64A",
                  cancelButtonColor: "#E4A220",
                  cancelButtonText: "لغو",
                  showLoaderOnConfirm: true,
              }, function () {
                  $.post( "<?php echo BASE_URL; ?>/inc/config/create.php",{
                          tarikh: tarikh,
                          hesab: hesab,
                          cst: cst,
                          price: price,
                          sharh: sharh,
                          c_cost: c_cost,
                      },
                      function( data ) {
                          var result = jQuery.parseJSON(data);
                          if(result.res=="registered") {
                              //  $("input[type=text], textarea").val("");
                              swal("موفق", "تراکنش جدید ثبت شد", "success");
                              setTimeout(function(){
                                  location.reload();
                              }, 1000);
                          }else if(result.res=="bad error") {
                              swal("ناموفق", "مشکلی در ثبت پیش آمد", "error");
                          }else {
                              swal("نا موفق", "مشکلی در ثبت پیش آمد با مدیر سیستم تماس بگیرید", "error");
                          }
                      });
              });
          }
      });
  </script>
  <script>
          $(function () {
          /*
           * ==========================================================
           * اطلاعات حساب‌ها
           * از همان منابع موجود سیستم استفاده می‌کنیم
           * ==========================================================
           */
          <?php
          $template_account_options = array();
          foreach (
              array(
                  $sandugh,
                  $sub_income,
                  $sub_cost,
                  $sub_vam,
                  $sub_ashkhas
              ) as $accountGroup
          ) {
              if (!is_array($accountGroup)) {
                  continue;
              }
              foreach ($accountGroup as $key => $value) {
                  if (is_array($value)) {
                      foreach ($value as $id => $name) {
                          $template_account_options[] = array(
                              'id'    => (int)$id,
                              'name'  => $name,
                              'group' => gethesabname($key)
                          );
                      }
                  } else {
                      $template_account_options[] = array(
                          'id'    => (int)$key,
                          'name'  => $value,
                          'group' => ''
                      );
                  }
              }
          }
          ?>
          var templateAccounts = <?php
          echo json_encode(
              $template_account_options,
              JSON_UNESCAPED_UNICODE
          );
          ?>;
          /*
           * ==========================================================
           * عناصر فرم
           * ==========================================================
           */
          var $operationType = $('#template_operation_type');
          var $hesabBed      = $('#template_hesab_bed');
          var $hesabBes      = $('#template_hesab_bes');
          var $templateForm  = $('#document_template_form');
          /*
           * ==========================================================
           * نمایش حساب‌ها
           * ==========================================================
           */
          function renderAccounts($select, accounts) {
          if (!$select.length) {
          return;
      }
          $select.empty();
          $select.append(
          $('<option>', {
          value: '',
          text: 'انتخاب حساب'
      })
          );
          if (!accounts || !accounts.length) {
          $select.selectpicker('refresh');
          return;
      }
          $.each(accounts, function (_, account) {
          $select.append(
          $('<option>', {
          value: account.id,
          text: account.name
      })
          );
      });
          /*
           * اگر select قبلاً selectpicker شده باشد
           */
          if ($select.hasClass('selectpicker')) {
          $select.selectpicker('refresh');
      } else {
          $select.addClass('selectpicker');
          $select.attr('data-live-search', 'true');
          $select.selectpicker();
      }
      }
          /*
           * ==========================================================
           * بروزرسانی حساب‌های فرم Template
           *
           * این قسمت را فعلاً بدون وابستگی به
           * $template_accounts نگه می‌داریم.
           * ==========================================================
           */
          function updateTemplateAccounts() {
          /*
           * در صورت وجود ساختار قدیمی templateAccounts
           * آن را پشتیبانی می‌کنیم.
           */
          var operationType = $operationType.val();
          if (
          templateAccounts &&
          !Array.isArray(templateAccounts) &&
          templateAccounts[operationType]
          ) {
          renderAccounts(
          $hesabBed,
          templateAccounts[operationType].bed
          );
          renderAccounts(
          $hesabBes,
          templateAccounts[operationType].bes
          );
          return;
      }
          /*
           * اگر ساختار بالا وجود نداشت،
           * تمام حساب‌ها را نمایش می‌دهیم.
           *
           * این حالت باعث می‌شود فرم از کار نیفتد.
           */
          renderAccounts(
          $hesabBed,
          templateAccounts
          );
          renderAccounts(
          $hesabBes,
          templateAccounts
          );
      }
          /*
           * ==========================================================
           * حالت ویرایش
           * ==========================================================
           */
          function setEditMode() {
          $templateForm
          .addClass('template-edit-mode');
          $('#save_document_template')
          .text('ویرایش')
          .removeClass('btn-primary')
          .addClass('btn-warning');
          $('#document_template_form_title')
          .text('ویرایش الگوی ثبت سند');
      }
          /*
           * ==========================================================
           * حالت ایجاد
           * ==========================================================
           */
          function setCreateMode() {
          $templateForm
          .removeClass('template-edit-mode');
          $('#save_document_template')
          .text('ذخیره')
          .removeClass('btn-warning')
          .addClass('btn-primary');
          $('#document_template_form_title')
          .text('افزودن الگوی ثبت سند')
          .css('color', '');
      }
          /*
           * ==========================================================
           * تغییر نوع عملیات
           * ==========================================================
           */
          $operationType.on('change', function () {
          updateTemplateAccounts();
      });
          /*
           * ==========================================================
           * ویرایش Template
           * ==========================================================
           */
          $('.edit-document-template').on('click', function () {
          var $button = $(this);
          var operation = $button.data('operation');
          var hesabBed = String(
          $button.data('bed')
          );
          var hesabBes = String(
          $button.data('bes')
          );
          /*
           * حالت ویرایش
           */
          setEditMode();
          /*
           * اطلاعات Template
           */
          $('#template_id').val(
          $button.data('id')
          );
          $('#template_name').val(
          $button.data('name')
          );
          $('#template_sharh').val(
          $button.data('sharh')
          );
          $('#template_active').prop(
          'checked',
          parseInt(
          $button.data('active'),
          10
          ) === 1
          );
          /*
           * نوع عملیات
           */
          $operationType
          .val(operation)
          .trigger('change');
          /*
           * انتخاب حساب‌های ذخیره‌شده
           */
          setTimeout(function () {
          $hesabBed
          .val(hesabBed)
          .selectpicker('refresh');
          $hesabBes
          .val(hesabBes)
          .selectpicker('refresh');
      }, 100);
          /*
           * باز کردن فرم
           */
          if (!$templateForm.hasClass('in')) {
          $templateForm.collapse('show');
      }
          /*
           * اسکرول
           */
          $('html, body').animate({
          scrollTop:
          $templateForm.offset().top - 30
      }, 300);
      });
          /*
           * ==========================================================
           * افزودن Template جدید
           * ==========================================================
           */
          $('#add-document-template').on('click', function () {
          setCreateMode();
          $('#template_id').val('');
          $('#template_name').val('');
          $('#template_sharh').val('');
          $('#template_active').prop(
          'checked',
          true
          );
          $operationType
          .val('cost')
          .trigger('change');
          if (!$templateForm.hasClass('in')) {
          $templateForm.collapse('show');
      }
      });
          /*
           * ==========================================================
           * انصراف
           * ==========================================================
           */
          $('#cancel-document-template').on('click', function () {
          setCreateMode();
          $('#template_id').val('');
          $('#template_name').val('');
          $('#template_sharh').val('');
          $('#template_active').prop(
          'checked',
          true
          );
          $operationType
          .val('cost')
          .trigger('change');
      });
          /*
           * ==========================================================
           * مقداردهی اولیه
           * ==========================================================
           */
          if ($operationType.length) {
          updateTemplateAccounts();
      }
      });
  </script>
  <script>
      $(function () {
          $('#document_template_income').on('changed.bs.select', function () {
              var $selected = $(this).find('option:selected');
              if (!$(this).val()) {
                  $('#hesab1')
                      .val('0')
                      .selectpicker('refresh');
                  $('#cst1')
                      .val('0')
                      .selectpicker('refresh');
                  $('#sharh1').val('');
                  return;
              }
              /*
               * در درآمد:
               *
               * بدهکار = صندوق
               * بستانکار = درآمد
               *
               * بنابراین:
               *
               * hesab_bed -> cst1
               * hesab_bes -> hesab1
               */
              var hesabBed = $selected.data('hesab-bed');
              var hesabBes = $selected.data('hesab-bes');
              var sharh = $selected.data('sharh') || '';
              $('#cst1')
                  .val(String(hesabBed))
                  .selectpicker('refresh');
              $('#hesab1')
                  .val(String(hesabBes))
                  .selectpicker('refresh');
              $('#sharh1').val(sharh);
          });
      });
  </script>
  <script>
      $(function () {
          $('#document_template_transfer').on('changed.bs.select', function () {
              var $selected = $(this).find('option:selected');
              /*
               * بدون الگو
               */
              if (!$(this).val()) {
                  $('#hesab8')
                      .val('0')
                      .selectpicker('refresh');
                  $('#cst8')
                      .val('0')
                      .selectpicker('refresh');
                  $('#sharh8').val('');
                  return;
              }
              var hesabBed = $selected.data('hesab-bed');
              var hesabBes = $selected.data('hesab-bes');
              var sharh = $selected.data('sharh') || '';
              /*
               * انتقال وجه:
               *
               * بدهکار = حساب مقصد
               * بستانکار = حساب مبدا
               *
               * اما در فرم فعلی:
               *
               * #hesab8 = از حساب
               * #cst8   = واریز به
               *
               * بنابراین:
               *
               * hesab_bed -> cst8
               * hesab_bes -> hesab8
               */
              $('#cst8')
                  .val(String(hesabBed))
                  .selectpicker('refresh');
              $('#hesab8')
                  .val(String(hesabBes))
                  .selectpicker('refresh');
              $('#sharh8').val(sharh);
          });
      });
  </script>
  <script>
      $(function () {
          <?php
          $multi_document_account_options = array();
          foreach (
              array(
                  $sandugh,
                  $sub_income,
                  $sub_cost,
                  $sub_vam,
                  $sub_ashkhas
              ) as $accountGroup
          ) {
              foreach ($accountGroup as $key => $value) {
                  if (is_array($value)) {
                      foreach ($value as $id => $name) {
                          $multi_document_account_options[] = array(
                              'id' => (int)$id,
                              'name' => $name,
                              'group' => gethesabname($key)
                          );
                      }
                  } else {
                      $multi_document_account_options[] = array(
                          'id' => (int)$key,
                          'name' => $value,
                          'group' => ''
                      );
                  }
              }
          }
          ?>
          var multiDocumentAccounts = <?php
              echo json_encode(
                  $multi_document_account_options,
                  JSON_UNESCAPED_UNICODE
              );
              ?>;
          var multiTemplateData = <?php
              $multiTemplateItems = array();
              try {
                  $stmt = $conn->prepare("
                SELECT
                    dti.id,
                    dti.template_id,
                    dti.sort_order,
                    dti.title,
                    dti.operation_type,
                    dti.hesab_bed,
                    dti.hesab_bes,
                    dti.sharh,
                    dti.default_amount
                FROM document_template_items dti
                WHERE dti.active = 1
                ORDER BY
                    dti.template_id ASC,
                    dti.sort_order ASC,
                    dti.id ASC
            ");
                  $stmt->execute();
                  while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
                      $templateId = (int)$item['template_id'];
                      if (!isset($multiTemplateItems[$templateId])) {
                          $multiTemplateItems[$templateId] = array();
                      }
                      $multiTemplateItems[$templateId][] = array(
                          'id' => (int)$item['id'],
                          'title' => $item['title'],
                          'operation_type' => $item['operation_type'],
                          'hesab_bed' => (int)$item['hesab_bed'],
                          'hesab_bes' => (int)$item['hesab_bes'],
                          'sharh' => $item['sharh'] ?? '',
                          'default_amount' =>
                              $item['default_amount'] !== null
                                  ? (float)$item['default_amount']
                                  : null
                      );
                  }
              } catch (Exception $e) {
                  $multiTemplateItems = array();
              }
              echo json_encode(
                  $multiTemplateItems,
                  JSON_UNESCAPED_UNICODE
              );
              ?>;
          var $template = $('#multi_document_template');
          var $itemsContainer =
              $('#multi_document_template_items');
          /*
           * نام نوع عملیات
           */
          function getOperationName(type) {
              switch (type) {
                  case 'cost':
                      return 'هزینه';
                  case 'income':
                      return 'درآمد';
                  case 'loan_payment':
                      return 'پرداخت قسط';
                  case 'transfer':
                      return 'انتقال وجه';
                  default:
                      return type;
              }
          }
          function buildAccountSelect(
              name,
              itemId,
              selectedId
          ) {
              var html = '';
              html += '<select ' +
                  'name="' + name + '" ' +
                  'class="form-control multi-item-account" ' +
                  'data-live-search="true" ' +
                  'data-item-id="' + itemId + '">';
              html += '<option value="">';
              html += 'انتخاب حساب';
              html += '</option>';
              $.each(
                  multiDocumentAccounts,
                  function (index, account) {
                      var selected =
                          String(account.id) ===
                          String(selectedId)
                              ? ' selected'
                              : '';
                      html += '<option ' +
                          'value="' + account.id + '"' +
                          selected +
                          '>';
                      html += $('<div>')
                          .text(account.name)
                          .html();
                      html += '</option>';
                  }
              );
              html += '</select>';
              return html;
          }
          /*
           * فرمت مبلغ
           */
          function formatAmount(value) {
              value = String(value || '');
              value = value.replace(/,/g, '');
              if (value === '') {
                  return '';
              }
              var number = parseFloat(value);
              if (isNaN(number)) {
                  return '';
              }
              return number.toLocaleString('en-US');
          }
          /*
           * تبدیل مبلغ برای محاسبه
           */
          function numericAmount(value) {
              value = String(value || '');
              value = value.replace(/,/g, '');
              value = value.replace(/ /g, '');
              var number = parseFloat(value);
              if (isNaN(number)) {
                  return 0;
              }
              return number;
          }
          /*
           * محاسبه تراز
           *
           * چون هر ردیف یک بدهکار و یک بستانکار
           * با یک مبلغ دارد، مجموع باید برابر باشد.
           */
          function updateBalance() {
              var totalAmount = 0;
              var validRows = 0;
              $('.multi-item-amount').each(function () {
                  var amount =
                      numericAmount(
                          $(this).val()
                      );
                  if (amount > 0) {
                      totalAmount += amount;
                      validRows++;
                  }
              });
              $('#multi_total_bed').text(
                  totalAmount.toLocaleString('en-US')
              );
              $('#multi_total_bes').text(
                  totalAmount.toLocaleString('en-US')
              );
              var $status =
                  $('#multi_balance_status');
              $('#multi_document_template_balance')
                  .show();
              if (validRows === 0) {
                  $status
                      .removeClass(
                          'alert-success alert-danger'
                      )
                      .addClass(
                          'alert-warning'
                      )
                      .text(
                          'حداقل یک ردیف با مبلغ بیشتر از صفر وارد نمایید'
                      );
                  return false;
              }
              $status
                  .removeClass(
                      'alert-warning alert-danger'
                  )
                  .addClass(
                      'alert-success'
                  )
                  .text(
                      'سند متوازن است ✓'
                  );
              return true;
          }
          /*
           * نمایش ردیف‌های Template
           */
          function renderMultiTemplate(templateId) {
              $itemsContainer.empty();
              $('#multi_document_template_balance')
                  .hide();
              if (!templateId) {
                  $itemsContainer.html(
                      '<div class="alert alert-info text-center">' +
                      'ابتدا یک الگو را انتخاب نمایید.' +
                      '</div>'
                  );
                  $('#multi_document_template_items select.show-tick').selectpicker();
                  return;
              }
              var items =
                  multiTemplateData[templateId];
              if (
                  !items
                  || !items.length
              ) {
                  $itemsContainer.html(
                      '<div class="alert alert-warning text-center">' +
                      'برای این الگو ردیفی تعریف نشده است.' +
                      '</div>'
                  );
                  return;
              }
              var html = '';
              html += '<div class="table-responsive">';
              html += '<table class="table table-bordered table-striped">';
              html += '<thead>';
              html += '<tr>';
              html += '<th>ردیف</th>';
              html += '<th>عنوان</th>';
              html += '<th style="display: none">نوع عملیات</th>';
              html += '<th>بدهکار</th>';
              html += '<th>بستانکار</th>';
              html += '<th  style="min-width: 200px">مبلغ</th>';
              html += '<th style="min-width: 250px">شرح</th>';
              html += '</tr>';
              html += '</thead>';
              html += '<tbody>';
              $.each(items, function (index, item) {
                  var defaultAmount =
                      item.default_amount !== null
                          ? formatAmount(
                              item.default_amount
                          )
                          : '';
                  var sharh =
                      item.sharh || '';
                  html += '<tr>';
                  html += '<td>';
                  html += (index + 1);
                  html += '</td>';
                  html += '<td>';
                  html += $('<div>')
                      .text(item.title)
                      .html();
                  html += '</td>';
                  html += '<td style="display: none">';
                  html += $('<div>')
                      .text(
                          getOperationName(
                              item.operation_type
                          )
                      )
                      .html();
                  html += '</td>';
                  html += '<td>';
                  html += buildAccountSelect(
                      'multi_hesab_bed[' + item.id + ']',
                      item.id,
                      item.hesab_bed
                  );
                  html += '</td>';
                  html += '<td>';
                  html += buildAccountSelect(
                      'multi_hesab_bes[' + item.id + ']',
                      item.id,
                      item.hesab_bes
                  );
                  html += '</td>';
                  html += '<td>';
                  html += '<input ' +
                      'type="text" ' +
                      'class="form-control multi-item-amount" ' +
                      'data-item-id="' +
                      item.id +
                      '" ' +
                      'value="' +
                      defaultAmount +
                      '" ' +
                      'onkeyup="this.value=separate(this.value);">';
                  html += '</td>';
                  html += '<td>';
                  html += '<input ' +
                      'type="text" ' +
                      'class="form-control multi-item-sharh" ' +
                      'data-item-id="' +
                      item.id +
                      '" ' +
                      'value="' +
                      $('<div>')
                          .text(sharh)
                          .html() +
                      '">';
                  html += '</td>';
                  html += '</tr>';
              });
              html += '</tbody>';
              html += '</table>';
              html += '</div>';
              $itemsContainer.html(html);
              /*
               * فعال کردن Bootstrap Select برای Selectهای
               * تازه ساخته‌شده
               */
              $itemsContainer
                  .find('select.multi-item-account')
                  .selectpicker({
                      liveSearch: true,
                      width: '100%'
                  });
              $('.multi-item-amount')
                  .on('input', function () {
                      this.value = separate(this.value);
                      updateBalance();
                  });
              updateBalance();
          }
          /*
           * انتخاب Template
           */
          $template.on(
              'changed.bs.select',
              function () {
                  renderMultiTemplate(
                      $(this).val()
                  );
              }
          );
          /*
      * ==========================
      * ثبت سند چندتراکنشی
      * ==========================
      */
$('#save_multi_document_template')
    .on('click', function () {

        var templateId =
            $template.val();

        var tarikh =
            $('#multi_document_date').val();

        /*
         * ==========================
         * بررسی اولیه
         * ==========================
         */
        if (!templateId) {

            swal(
                'خطا',
                'الگوی ثبت سند را انتخاب نمایید.',
                'warning'
            );

            return;
        }

        if (!tarikh) {

            swal(
                'خطا',
                'تاریخ را وارد نمایید.',
                'warning'
            );

            return;
        }

        /*
         * ==========================
         * جمع‌آوری ردیف‌ها
         * ==========================
         */
        var items = {};
        var skippedItems = [];

        $('.multi-item-amount').each(function () {

            var $amount =
                $(this);

            var itemId =
                $amount.data('item-id');

            var amount =
                numericAmount(
                    $amount.val()
                );

            var $row =
                $amount.closest('tr');

            var title =
                $.trim(
                    $row
                        .find('td:eq(1)')
                        .text()
                );

            /*
             * شرح فقط از فرم
             */
            var sharh =
                $.trim(
                    $row
                        .find(
                            '.multi-item-sharh[data-item-id="' +
                            itemId +
                            '"]'
                        )
                        .val() || ''
                );

            /*
             * حساب بدهکار
             */
            var hesabBed =
                $row
                    .find(
                        'select[name="multi_hesab_bed[' +
                        itemId +
                        ']"]'
                    )
                    .val();

            /*
             * حساب بستانکار
             */
            var hesabBes =
                $row
                    .find(
                        'select[name="multi_hesab_bes[' +
                        itemId +
                        ']"]'
                    )
                    .val();

            /*
             * ==========================
             * مبلغ صفر یا خالی
             *
             * این ردیف اصلاً ارسال نمی‌شود.
             * ==========================
             */
            if (amount <= 0) {

                skippedItems.push({
                    id:
                        itemId,

                    title:
                        title ||
                        ('ردیف ' + itemId)
                });

                return;
            }

            /*
             * ==========================
             * حساب‌ها
             * ==========================
             */
            if (
                !hesabBed
                || parseInt(hesabBed, 10) <= 0
            ) {

                swal(
                    'خطا',
                    'حساب بدهکار برای ردیف «' +
                    (title || ('ردیف ' + itemId)) +
                    '» انتخاب نشده است.',
                    'warning'
                );

                return false;
            }

            if (
                !hesabBes
                || parseInt(hesabBes, 10) <= 0
            ) {

                swal(
                    'خطا',
                    'حساب بستانکار برای ردیف «' +
                    (title || ('ردیف ' + itemId)) +
                    '» انتخاب نشده است.',
                    'warning'
                );

                return false;
            }

            /*
             * ==========================
             * آماده‌سازی ردیف
             *
             * شرح Template استفاده نمی‌شود.
             * ==========================
             */
            items[itemId] = {

                price:
                    amount,

                sharh:
                    sharh,

                hesab_bed:
                    parseInt(
                        hesabBed,
                        10
                    ),

                hesab_bes:
                    parseInt(
                        hesabBes,
                        10
                    )
            };

        });

        /*
         * اگر یکی از حساب‌ها انتخاب نشده باشد،
         * each با return false متوقف می‌شود.
         *
         * بنابراین دوباره بررسی می‌کنیم.
         */
        if (
            Object.keys(items).length === 0
        ) {

            swal(
                'خطا',
                'هیچ ردیفی با مبلغ بیشتر از صفر برای ثبت وجود ندارد.',
                'warning'
            );

            return;
        }

        /*
         * ==========================
         * محاسبه جمع
         * ==========================
         */
        var totalAmount = 0;

        $.each(
            items,
            function (_, item) {

                totalAmount +=
                    numericAmount(
                        item.price
                    );

            }
        );

        if (totalAmount <= 0) {

            swal(
                'خطا',
                'مبلغ ردیف‌های قابل ثبت معتبر نیست.',
                'warning'
            );

            return;
        }

        /*
         * ==========================
         * ساخت پیام ردیف‌های حذف‌شده
         * ==========================
         */
        var skippedText = '';

        if (
            skippedItems.length > 0
        ) {

            skippedText =
                '<br><br>' +
                '<strong>' +
                'ردیف‌های زیر ثبت نمی‌شوند:' +
                '</strong>' +
                '<br>';

            $.each(
                skippedItems,
                function (_, item) {

                    skippedText +=
                        '• ' +
                        $('<div>')
                            .text(item.title)
                            .html() +
                        '<br>';

                }
            );
        }

        /*
         * ==========================
         * تأیید نهایی
         * ==========================
         */
        swal({

            title:
                'ثبت سند چندتراکنشی',

            text:
                'ردیف‌های دارای مبلغ بیشتر از صفر ثبت می‌شوند.' +
                skippedText +
                '<br>آیا مورد تأیید است؟',

            type:
                'warning',

            html:
                true,

            showCancelButton:
                true,

            closeOnConfirm:
                false,

            confirmButtonText:
                'بله، ثبت کن',

            confirmButtonColor:
                '#1EA64A',

            cancelButtonColor:
                '#E4A220',

            cancelButtonText:
                'لغو',

            showLoaderOnConfirm:
                true

        }, function () {

            /*
             * ==========================
             * ارسال به create.php
             * ==========================
             */
            $.ajax({

                url:
                    "<?php echo BASE_URL; ?>/inc/config/create.php",

                type:
                    'POST',

                dataType:
                    'json',

                data: {

                    c_multi_template:
                        'c_multi_template',

                    template_id:
                        templateId,

                    tarikh:
                        tarikh,

                    items:
                        items
                },

                success:
                    function (result) {

                        if (
                            result.res ===
                            'registered'
                        ) {

                            swal(
                                'موفق',
                                result.message ||
                                'سند با موفقیت ثبت شد.',
                                'success'
                            );

                            setTimeout(
                                function () {

                                    location.reload();

                                },
                                1000
                            );

                        } else {

                            swal(
                                'ناموفق',
                                result.message ||
                                'مشکلی در ثبت سند به وجود آمد.',
                                'error'
                            );
                        }
                    },

                error:
                    function () {

                        swal(
                            'ناموفق',
                            'خطایی در ارتباط با سرور به وجود آمد.',
                            'error'
                        );
                    }
            });
        });
    });

          /*
           * پاک کردن فرم هنگام بسته شدن
           */
          $('#multi_document_template_modal')
              .on(
                  'hidden.bs.modal',
                  function () {
                      $template
                          .val('')
                          .selectpicker('refresh');
                      $('#multi_document_date')
                          .val('');
                      $itemsContainer.html(
                          '<div class="alert alert-info text-center">' +
                          'ابتدا یک الگو را انتخاب نمایید.' +
                          '</div>'
                      );
                      $('#multi_document_template_balance')
                          .hide();
                  }
              );
      });
  </script>
  </body>
</html>
