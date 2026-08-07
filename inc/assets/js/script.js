function separate( Number ) {
    Number += '';
    Number = Number.replace( ',', '' );
    Number = Number.replace( ',', '' );
    Number = Number.replace( ',', '' );
    Number = Number.replace( ',', '' );
    Number = Number.replace( ',', '' );
    Number = Number.replace( ',', '' );
    x = Number.split( '.' );
    y = x[ 0 ];
    z = x.length > 1 ? '.' + x[ 1 ] : '';
    var rgx = /(\d+)(\d{3})/;
    while ( rgx.test( y ) )
        y = y.replace( rgx, '$1' + ',' + '$2' );
    return y + z;
}
function vamSelect() {
    var other = document.getElementById("otherBoxVam");
    var other2 = document.getElementById("otherBoxVam2");
    if (document.forms[0].kol_id.options[document.forms[0].kol_id.selectedIndex].value == vam) {
        other.style.display = "block";
        other2.style.display = "block";
    }
    else {
        other.style.display = "none";
        other2.style.display = "none";
    }
}
function addCommas(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
$(".toggle-password").click(function() {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});
            var dynamicVariable = document.title+'-'+$.now();
        
        

        
            jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
                return this.flatten().reduce( function ( a, b ) {
                  if ( typeof a === 'string' ) {
                    a = a.replace(/[^\d.-]/g, '') * 1;
                  }
                  if ( typeof b === 'string' ) {
                    b = b.replace(/[^\d.-]/g, '') * 1;
                  }
        
                  return a + b;
                }, 0 );
              });
        
            jQuery.fn.dataTable.Api.register('sum()', function () {
                return this.flatten().reduce(function (a, b) {
                    if (typeof a === 'string') {
                        a = a.replace(/[^\d.-]/g, '') * 1;
                    
                    }
                    if (typeof b === 'string') {
                        b = b.replace(/[^\d.-]/g, '') * 1;
                
                    }
                    return a + b;
                }, 0);
            });
        
            function formatNumber(num, isDollars) {
                if (num && isDollars) {
               //     return `$${num.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`;
                    
                }
                return num;
            }



$('.tbl_col_1').DataTable({

    "autoWidth": true,
    //	 responsive: false,
    fixedHeader: {
        header: true,
        footer: false,
        headerOffset: $('#top_menus').outerHeight()
    },
    
    "language": {
        "paginate": {
            "first": " اولین",
            "last": "آخرین",
            "sNext": "بعدی",
            "sPrevious": "قبلی",
        },
        "search": "جستجو :",
        "sEmptyTable": "هنوز اطلاعاتی وارد نشده است",
        "sSearchPlaceholder": " ",
        "sInfo": "نمایش _START_ تا _END_ از مجموع _TOTAL_ ",
        "sInfoEmpty": " ",
        "sInfoFiltered": "(فیلتر شده از مجموع _MAX_ ورودی)",

        "sLengthMenu": "نمایش :  _MENU_ ",
        "loadingRecords": "متنظر بمانید ...",
        "sProcessing": "درحال پردازش ...",
        "sZeroRecords": "اطلاعاتی پیدا نشد !",

    },

    dom: "<'row'<'col-sm-4'f><'col-sm-4'B><'col-sm-4'l>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-7 ingft 'p><'col-sm-5 text-left rfgwq'i>>",
    responsive: true,
    "order": [[ 0, "desc" ]],
    "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],

    buttons: [

        {
            extend: 'excelHtml5',
            title: 'Data export'
        },
        {
            extend: 'print',
            footer: true,
            autoPrint: false,
            title: dynamicVariable,

            exportOptions: {

                columns: ':not(:last-child)',
            }
        },
        {
            extend: 'pdfHtml5',
            action: function(e, dt, button, config) {
                config.filename = dynamicVariable;
                $.fn.dataTable.ext.buttons.pdfHtml5.action(e, dt, button, config);

            }
        },

        'copy' ,


    ]



















});

    
            $('.tbl_col_1a').DataTable({
                
                "bProcessing": true,
                "serverSide": true,
                processing:true,
                "ajax": {
                    url: "datatbl.php",
                    type: "POST",
                    error: function(data) {
                        alert("some error occured please try again.")
                    }
                    },
    "autoWidth": true,

    //	 responsive: false,
    fixedHeader: {
        header: true,
        footer: false,
        headerOffset: $('#top_menus').outerHeight()
    },
    "language": {
        "paginate": {
            "first": " اولین",
            "last": "آخرین",
            "sNext": "بعدی",
            "sPrevious": "قبلی",
        },
        "search": "جستجو :",
        "sEmptyTable": "هنوز اطلاعاتی وارد نشده است",
        "sSearchPlaceholder": " ",
        "sInfo": "نمایش _START_ تا _END_ از مجموع _TOTAL_ ",
        "sInfoEmpty": " ",
        "sInfoFiltered": "(فیلتر شده از مجموع _MAX_ ورودی)",

        "sLengthMenu": "نمایش :  _MENU_ ",
        "loadingRecords": "متنظر بمانید ...",
        "sProcessing": "<div><div></div><div></div><div></div><div></div></div>",
        "sZeroRecords": "اطلاعاتی پیدا نشد !",

    },

    dom: "<'row'<'col-sm-4'f><'col-sm-4'B><'col-sm-4'l>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-7 ingft 'p><'col-sm-5 text-left rfgwq'i>>",
    responsive: true,
    "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
     "order": [[ 0, "desc" ]],
    buttons: [

        {
            extend: 'excelHtml5',
            title: 'Data export'
        },
        {
            extend: 'print',
            footer: true,
            autoPrint: false,
            title: dynamicVariable,

            exportOptions: {

                columns: ':not(:last-child)',
            }
        },
        {
            extend: 'pdfHtml5',
            action: function(e, dt, button, config) {
                config.filename = dynamicVariable;
                $.fn.dataTable.ext.buttons.pdfHtml5.action(e, dt, button, config);

            }
        },

        'copy' ,


    ]



















});

var table = $('.tbl_col_1a').DataTable();
 
table.columns( '.select-filter' ).every( function () {
    var that = this;
 
    // Create the select list and search operation
    var select = $('<select />')
        .appendTo(
            this.footer()
        )
        .on( 'change', function () {
            that
                .search( $(this).val() )
                .draw();
        } );
 
    // Get the search data for the first column and add to the select list
    this
        .cache( 'search' )
        .sort()
        .unique()
        .each( function ( d ) {
            select.append( $('<option value="'+d+'">'+d+'</option>') );
        } );
} );


$('.tbl_ms').DataTable({
    footerCallback: function () {
        const api = this.api();
        const columns = [
            {
                index: 5,
                dollars: false,
            },
            /* {
                 index: 5,
                 dollars: true,
             },*/
        ];



    },

    "autoWidth": true,
    columnDefs: [
        { responsivePriority: 1, targets: 0},
        { responsivePriority: 2, targets: -1 },

    ],
    //	 responsive: false,
    fixedHeader: {
        header: true,
        footer: false,
        headerOffset: $('#top_menus').outerHeight()
    },
    "language": {
        "paginate": {
            "first": " اولین",
            "last": "آخرین",
            "sNext": "بعدی",
            "sPrevious": "قبلی",
        },
        "search": "جستجو :",
        "sEmptyTable": "هنوز اطلاعاتی وارد نشده است",
        "sSearchPlaceholder": " ",
        "sInfo": "نمایش _START_ تا _END_ از مجموع _TOTAL_ ",
        "sInfoEmpty": " ",
        "sInfoFiltered": "(فیلتر شده از مجموع _MAX_ ورودی)",

        "sLengthMenu": "نمایش :  _MENU_ ",
        "loadingRecords": "متنظر بمانید ...",
        "sProcessing": "درحال پردازش ...",
        "sZeroRecords": "اطلاعاتی پیدا نشد !",

    },

    dom: "<'row'<'col-sm-4'f><'col-sm-4'B><'col-sm-4'l>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-7 ingft 'p><'col-sm-5 text-left rfgwq'i>>",
    responsive: true,
    "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
    "order": [[ 1, "asc" ]],
    buttons: [

        {
            extend: 'excelHtml5',
            title: 'Data export'
        },
        {
            extend: 'print',
            footer: true,
            autoPrint: false,
            title: dynamicVariable,

            exportOptions: {

                columns: ':not(:last-child)',
            }
        },
        {
            extend: 'pdfHtml5',
            action: function(e, dt, button, config) {
                config.filename = dynamicVariable;
                $.fn.dataTable.ext.buttons.pdfHtml5.action(e, dt, button, config);

            }
        },

        'copy' ,


    ]



















});
jQuery('.delete_is').on('click', function () {


    var esm = $(this).val();
    swal({
        title: "این فایل حذف شود ؟",
        text: "با تایید این عملیات فایل برای همیشه حذف خواهد گردید",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "بله، حذف شود",
        cancelButtonText: "لغو",
        closeOnConfirm: false,
        closeOnCancel: false
    }, function (isConfirm) {
        if (isConfirm) {
            $.post(home_url+'/inc/config/delete_file.php', {name: esm}, function(data){
                if(data==="1") {


                    swal("حذف شد !", "فایل به طور کامل پاک گردید.", "success");
                    location.reload();
                }else{
                    swal("مشکلی در حذف پیش آمد", "صفحه را مجدد بارگزاری نمایید یا با مدیر سیستم تماس بگیرید.", "error");
                }

            });


        } else {



            swal("لغو گردید", "اطلاعات حفظ شد :)", "error");
        }


    });




});

$('.tbl_simple2').DataTable({
    "autoWidth": true,
    "language": {
        "paginate": {
            "first": " اولین",
            "last": "آخرین",
            "sNext": "بعدی",
            "sPrevious": "قبلی",
        },
        "search": "جستجو :",
        "sEmptyTable": "هنوز اطلاعاتی وارد نشده است",
        "sSearchPlaceholder": " ",
        "sInfo": "نمایش _START_ تا _END_ از مجموع _TOTAL_ ",
        "sInfoEmpty": " ",
        "sInfoFiltered": "(فیلتر شده از مجموع _MAX_ ورودی)",

        "sLengthMenu": "نمایش :  _MENU_ ",
        "loadingRecords": "متنظر بمانید ...",
        "sProcessing": "درحال پردازش ...",
        "sZeroRecords": "اطلاعاتی پیدا نشد !",

    },
   // dom: "<'row'<'col-sm-4'f><'col-sm-4'B><'col-sm-4'l>>" +
    dom: "<'row'<'fffffwd'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-7 ingft 'p><'col-sm-5'l>>",
    responsive: true,
    "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
    "order": [[ 1, "DESC" ]],
    buttons: [

        {
            extend: 'excelHtml5',
            title: 'Data export'
        },
        {
            extend: 'print',
            footer: true,
            autoPrint: false,
            title: dynamicVariable,

            exportOptions: {

                columns: ':not(:last-child)',
            }
        },
        {
            extend: 'pdfHtml5',
            action: function(e, dt, button, config) {
                config.filename = dynamicVariable;
                $.fn.dataTable.ext.buttons.pdfHtml5.action(e, dt, button, config);

            }
        },

        'copy' ,


    ]

});

/*

$('.tbl_ms').DataTable({
        footerCallback: function () {
          const api = this.api();
          const columns = [
              {
                  index: 5,
                  dollars: false,
              },
             /!* {
                  index: 5,
                  dollars: true,
              },*!/
          ];
        

    
      },
  
          "autoWidth": true,
              columnDefs: [
      { responsivePriority: 1, targets: 0},
      { responsivePriority: 2, targets: -1 },

  ],
          //	 responsive: false,
       fixedHeader: {
  header: true,
  footer: false,
headerOffset: $('#top_menus').outerHeight()
},
        "language": {
            "paginate": {
                "first": " اولین",
                "last": "آخرین",
                "sNext": "بعدی",
                "sPrevious": "قبلی",
                        },
            "search": "جستجو :",
          "sEmptyTable": "هنوز اطلاعاتی وارد نشده است",
            "sSearchPlaceholder": " ",
               "sInfo": "نمایش _START_ تا _END_ از مجموع _TOTAL_ ",
           "sInfoEmpty": " ",
          "sInfoFiltered": "(فیلتر شده از مجموع _MAX_ ورودی)",
           
               "sLengthMenu": "نمایش :  _MENU_ ",
   "loadingRecords": "متنظر بمانید ...",
            "sProcessing": "درحال پردازش ...",
          "sZeroRecords": "اطلاعاتی پیدا نشد !",
            
                },
      
      dom: "<'row'<'col-sm-4'f><'col-sm-4'B><'col-sm-4'l>>" +
"<'row'<'col-sm-12'tr>>" +
"<'row'<'col-sm-7 ingft 'p><'col-sm-5 text-left rfgwq'i>>",
responsive: true,
  "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
   "order": [[ 0, "desc" ]],
       buttons: [

          {
              extend: 'excelHtml5',
              title: 'Data export'
          },
             {
              extend: 'print',
                 footer: true,
                     autoPrint: false,
              title: dynamicVariable,
                 
                 exportOptions: {
                     
                  columns: ':not(:last-child)',
              }
          },
          {
              extend: 'pdfHtml5',
                  action: function(e, dt, button, config) {
      config.filename = dynamicVariable;
      $.fn.dataTable.ext.buttons.pdfHtml5.action(e, dt, button, config);

    }
          }, 
      
           'copy' , 
           
           
      ]



















});


*/




 $('input.global_filter').on( 'keyup click', function () {
      filterGlobal();
  } );

  $('input.column_filter').on( 'keyup click', function () {
      filterColumn( $(this).parents().attr('data-column') );
  } );
  function filterGlobal () {
  $('.tbl_col_1a').DataTable().search(
      $('#global_filter').val(),
      $('#global_regex').prop('checked'),
      $('#global_smart').prop('checked')
  ).draw();
}
var $demoMaskedInput = $('.msk');
//Date
$demoMaskedInput.find('.datep').inputmask('9999/99/99', { jitMasking: true });
function filterColumn ( i ) {
  $('.tbl_col_1a').DataTable().column( i ).search(
      $('#col'+i+'_filter').val(),
      $('#col'+i+'_regex').prop('checked'),
      $('#col'+i+'_smart').prop('checked')
  ).draw();
}
$( "#search_bx" ).click(function() {
$( "#bx_s" ).slideToggle( "slow", function() {
  // Animation complete.
});


        
});

