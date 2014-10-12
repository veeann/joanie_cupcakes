<?php
session_start();
$userid = $_SESSION['userid'];
$_SESSION['userid'] = $userid;

$id = $_POST['delthis'];

$sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");

$deleteex = "DELETE FROM Expense_t WHERE expense_id=$id ";
@mysqli_query($sqlconn,$deleteex);
@mysqli_close($sqlconn);
header ("Location: expenses.php");
?>
