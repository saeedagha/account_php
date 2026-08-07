<?php
// DB table to use
require_once 'inc/config/db.php';
$table = 'ruznameh';

// Table's primary key
$primaryKey = 'id';

// An array of columns from the database that should be read and returned to DataTables.  
// The 'db' parameter is the database column name, and the 'dt parameter the DataTables column ID.  
// In this example, object parameter names
$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'date', 'dt' => 1, 'formatter' => function( $d, $row ) {
        return date_sep($d);
    }),
    array('db' => 'hesab_bed',  'dt' => 2, 'formatter' => function($d, $row){
        $f= $row["hesab_bed"];
        $a= '<a href="'.BASE_URL.'/ruznameh/view.php?view='.$f.'" class="col-pink">';
    $hesab = display_hesab($row['hesab_bed']);
      $List = implode(' » ', $hesab);
      $b='</a>';
         return $a.$List.$b;

    }),
    array('db' => 'hesab_bes',  'dt' => 3, 'formatter' => function($d, $row){
        $f= $row["hesab_bes"];
        $a= '<a href="'.BASE_URL.'/ruznameh/view.php?view='.$f.'" class="col-teal">';
        $hesab = display_hesab($row['hesab_bes']);
        $List = implode(' » ', $hesab);
        $b='</a>';
        return $a.$List.$b;

    }),
    array('db' => 'sharh',  'dt' => 4),
    array('db' => 'price',  'dt' => 5, 'formatter' => function($d, $row){
       $s='<a href="'.BASE_URL.'/ruznameh/edit.php?edit='.$row['id'].'">'.number_format( $row['price']).'</a>';
return $s;
    }),

);

// SQL server connection information
global $user, $pass, $db;
$sql_details = array(
    'db'   => $db,
	'user' => $user,
	'pass' => $pass,
	'host' => 'localhost'
);

// Helper functions for building a DataTables server-side processing SQL query
require('ssp.class.php');

echo json_encode(
	SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)
);
