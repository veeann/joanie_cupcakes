<?php

session_start();
$userid = $_SESSION['userid'];
$_SESSION['userid'] = $userid;

$id = $_POST['delthis'];

$sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");

$deletepay = "DELETE FROM Payment_t WHERE payment_id=$id ";
@mysqli_query($sqlconn,$deletepay);
@mysqli_close($sqlconn);
header ("Location: payment.php");
?>
