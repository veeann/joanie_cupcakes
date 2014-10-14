<?php
session_start();
date_default_timezone_set('Asia/Manila');
$fn = $_POST['orderfirst'];
$ln = $_POST['orderlast'];
$em = $_POST['orderemail'];
$cn = $_POST['ordernum'];
$ds = $_POST['orderdesc'];

$emformat = '/\S+@\S+.\S+/';
$numforma = '/\d{11}/';
$numformb = '/\d{4}-\d{3}-\d{4}/';

$current = array("\\", "'", "\"");
$shouldb   = array("\\\\", "\'", "\\\"");

$grr = str_replace($current, $shouldb, $fn);
$fn = $grr;
$grr = str_replace($current, $shouldb, $ln);
$ln = $grr;
$grr = str_replace($current, $shouldb, $em);
$em = $grr;
$grr = str_replace($current, $shouldb, $ds);
$ds = $grr;

if ($fn == "" || $ln == "" || $em == "" || $cn == "" || $ds == "") {
	//$_SESSION['error'] = "Please fill in all the fields.";
	header ("Location: customerordering.php");
}
else if (!preg_match($emformat, $em)) { 
	//$_SESSION['error'] = "Please input a valid email in the proper format (e.g. username@website.com).";
	header ("Location: customerordering.php");
}
else if (!preg_match($numforma, $cn) && !preg_match($numformb, $cn)) { 
	//$_SESSION['error'] = "Please input a valid mobile number in either of the following formats: 0000-000-0000 or 00000000000.";
	header ("Location: customerordering.php");
}
else {
	$sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
	$today =  date('Y-m-d H:i:s');
	$temp = str_replace("-","",$cn);
	$cn = $temp;
	$sqlinsert="INSERT INTO Order_t (order_date, customer_last_name, customer_first_name, customer_email, customer_contact_number, details, price, status) VALUES ('".$today."', '".$ln."', '".$fn."', '".$em."', '".$cn."', '".$ds."', 0.00, '".Placed."') ";
	//$_SESSION['error'] = "";
	@mysqli_query($sqlconn,$sqlinsert);

	@mysqli_close($sqlconn);

	header ("Location: ordersuccess.php");
}
?>
