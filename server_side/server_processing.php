<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'User_details';

// Table's primary key
$primaryKey = 'user_id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => 'user_id', 'dt' => 0 ),
	array( 'db' => 'username', 'dt' => 1 ),
	array( 'db' => 'first_name',  'dt' => 2 ),
	array( 'db' => 'last_name',   'dt' => 3 ),
	array( 'db' => 'gender',     'dt' => 4 )
);

// SQL server connection information
// $sql_details = array(
// 	'user' => 'sa',
// 	'pass' => 'Espex.2018',
// 	'db'   => 'REPORTCALLS',
// 	'host' => '10.0.0.131'
// );

$sql_details = array(
	'user' => 'sa',
	'pass' => '12345678',
	'db'   => 'test',
	'host' => 'LAPTOP-0GVT7Q7J'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require_once( 'ssp.class.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

