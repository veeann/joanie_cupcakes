<?php
$sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");

$id="0";
$pw="";

if(isset($_POST['logname']))
	$id=$_POST['logname'];
if(isset($_POST['logpass']))
	$pw=$_POST['logpass'];

$sqlquery="SELECT * FROM Employee_t WHERE employee_id = $id AND password = '".$pw."' ";
$result=@mysqli_query($sqlconn, $sqlquery);
if($result == false || @mysqli_num_rows($result)==0)
	header ("Location: login.php");
else{
	session_start();
	$_SESSION['userid'] = $id;
	header ("Location: employeemenu.php");
}

@mysqli_close($sqlconn);
?>
