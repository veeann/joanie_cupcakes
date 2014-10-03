<?php
date_default_timezone_set('Asia/Manila');
$sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
$userid = $_GET['userid'];
$today =  date('Y-m-d');
$time = date('H:i:s');
$sqlquery="SELECT * FROM Attendance_t, Employee_t WHERE Employee_t.employee_id = $userid AND Employee_t.employee_id = Attendance_t.employee_id AND Attendance_t.signed_date = '".$today."' ";
$result=@mysqli_query($sqlconn, $sqlquery);
if($result == false || @mysqli_num_rows($result)==0) {
	$sqlinsert = "INSERT INTO Attendance_t (signed_date, time_in, time_out, employee_id) VALUES ('".$today."', '".$time."', '".$time."', $userid) ";
	@mysqli_query($sqlconn, $sqlinsert);
	echo "success";
}
else {
	$row = @mysqli_fetch_array($result);
	if ($row['time_in']==$row['time_out']) {
		$sqlupdate = "UPDATE Attendance_t SET time_out='".$time."' WHERE employee_id = $userid AND signed_date='".$today."' ";
		@mysqli_query($sqlconn, $sqlupdate);
		echo "signed out";
	}
}
@mysqli_close($sqlconn);
header ("Location: employeemenu.php? userid = $userid");
?>
