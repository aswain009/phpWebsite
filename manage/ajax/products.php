<?php 
include('../includes/settings.php');
include('../includes/functions.php');

// DB table to use
$table = 'products';
 
// Table's primary key
$primaryKey = 'sku';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'name', 'dt' => 0 ),
    array( 'db' => 'category',  'dt' => 1 ),
    array( 'db' => 'qty',   'dt' => 2 ),
    array( 'db' => 'visibility',     'dt' => 3 ),
    array( 'db' => 'status',     'dt' => 4 ),
    array(
    	'db' => 'sku',
    	'dt' => 5,
    	'formatter' => function($d, $row){
    		return '<a href="editProducts.php?productID='.$d.'" role="button" class="btn">Edit</a> <a href="ajax/delete.php?deleteProduct='.$d.'" data-target="#deleteProduct" role="button" class="btn" data-toggle="modal">Delete</a>';
    	}
    )
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'a3smedia_regofro',
    'pass' => 'wcDDnGdRDxqXUnpD8L2AkbmB',
    'db'   => 'a3smedia_regofront',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( '../assets/lib/DataTables/ssp/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);