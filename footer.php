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

  </body>

</html>
