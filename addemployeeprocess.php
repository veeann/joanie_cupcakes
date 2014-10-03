<?php
date_default_timezone_set('Asia/Manila');
$fn = $_POST['aefirst'];
$ln = $_POST['aelast'];
$ti = $_POST['aetitle'];
$ds = $_POST['aedesc'];
$sa = $_POST['aesal'];
$pw = $_POST['aepass'];
$userid = $_GET['userid'];

$money = '/\d+.\d+/';
$integ = '/\d+';

if ($fn == "" || $ln == "" || $em == "" || $cn == "" || $ds == "") {
	header ("Location: addemployee.php? userid = $userid");
}
else if ($ti != "Administrator" && $ti != "Employee") { 
	header ("Location: addemployee.php? userid = $userid");
}
else if (!preg_match($money, $sa) && !preg_match($integ, $sa)) { 
	header ("Location: addemployee.php? userid = $userid");
}
else {
	$sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
	$sqlinsert="INSERT INTO Employee_t (last_name, first_name, job_title, job_description, salary, password) VALUES ('".$ln."', '".$fn."', '".$ti."', '".$ds."', $sa, '".$pw."') ";
	
	@mysqli_query($sqlconn,$sqlinsert);

	@mysqli_close($sqlconn);

	header ("Location: employeemenu.php? userid = $userid");
}
?>
