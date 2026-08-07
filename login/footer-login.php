<script src="<?php echo BASE_URL; ?>/inc/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/inc/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo BASE_URL; ?>/inc/plugins/sweetalert/sweetalert.min.js"></script><!-- ADD-User.php -->
 <script src="<?php echo BASE_URL; ?>/inc/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js 
    <script src="../assets/js/admin.js"></script>-->
 <script>
	 		
$(document).ready(function (e) {
	
	
});
	
</script>



    
    <script>

		$('#logn').validate({

    submitHandler: function(form) {
		
		    $('.vorud').on('click', function () {
        var type = $(this).data('type');
      if (type === 'ajax-loader') {
		    var user = $("#user").val();
			var pass = $("#pass").val();
		  var lg = $("#lg").val();

		  
		  $.post( "login.php",{
	  user : user,
      pass : pass,
      lg : lg,
	
},
 function( data ) {
			     var result = jQuery.parseJSON(data);
	if(result.res=="vorud") {
	//  $("input[type=text], textarea").val("");
		
    swal("موفق", "با موفقیت وارد شدید", "success");
		window.setTimeout(function() {
    window.location.href = '../index.php';
}, 500);

	}else if(result.res=="bad") {
		swal("نا موفق", "نام کاربری و رمز ورود صحیح نمی باشد", "error");
		
	}else {
		swal("نا موفق", "دوباره سعی نمایید", "error");
	}
});
		  
		  
		  
		  
		  
        }
    });
       //Put Ajax
		  return false;  // blocks regular submit since you have ajax
    }
});	
    	
		
</script>
    
    
    
    
</body>

</html>