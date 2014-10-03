<?php
date_default_timezone_set('Asia/Manila');
$fn = $_POST['orderfirst'];
$ln = $_POST['orderlast'];
$em = $_POST['orderemail'];
$cn = $_POST['ordernum'];
$ds = $_POST['orderdesc'];

$emformat = '/\S+@\S+.\S+/';
$numforma = '/\d{11}/';
$numformb = '/\d{4}-\d{3}-\d{4}/';

if ($fn == "" || $ln == "" || $em == "" || $cn == "" || $ds == "") {
	header ("Location: customerordering.php");
}
else if (!preg_match($emformat, $em)) { 
	header ("Location: customerordering.php");
}
else if (!preg_match($numforma, $cn) && !preg_match($numformb, $cn)) { 
	header ("Location: customerordering.php");
}
else {
	$sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
	$today =  date('Y-m-d H:i:s');
	$sqlinsert="INSERT INTO Order_t (order_date, customer_last_name, customer_first_name, customer_email, customer_contact_number, details, price, status) VALUES ('".$today."', '".$ln."', '".$fn."', '".$em."', '".$cn."', '".$ds."', 0.00, '".Placed."') ";
	
	@mysqli_query($sqlconn,$sqlinsert);

	@mysqli_close($sqlconn);

	header ("Location: ordersuccess.php");
}
?>
