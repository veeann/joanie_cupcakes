<html>

<head>
<title>Joanie's Cupcakes</title>
<link rel="stylesheet" href="everywhere.css" />
<link rel="stylesheet" href="960.css" />
<link rel="stylesheet" href="reset.css" />

<style type="text/css">
.grid_3 img{
	width:100%;
}
.grid_9 img{
  width:100%;
}
button{
	font-size:10px;
	color: #000000;
	letter-spacing: 1px;
	background-color: #FFD1FF;
	border: none;
	height: 30px;
	width: 100%;
	margin-top:20px;
	margin-left:auto;
	margin-right:auto;
	padding:10px;
}

</style>
</head>


<body>

<div class="container">
  	<div class="header" align="center" >
  		</br>
  		<a href="index.php">
  			<img src="images/logo.jpg" alt="Insert Logo Here" name="Insert_logo" width="169" height="155" id="Insert_logo" style="background-color: #C6D580; display:block;" />
  		</a> 
  		</br>
      <?php
      $userid = $_GET['userid'];
      ?>
  	</div>

  	<div class="container_12">
  		<div class="grid_3">
        <a href="attendance.php?userid=<?php echo $userid ?>"><button>Sign Attendance</button></a>
        <button>Orders</button>
  		  <button>Salaries</button>
  		  <button>Expenses</button>
  		  <button>Order Payment</button>
        <button>Sales Report</button>
  		  <a href="addemployee.php?userid=<?php echo $userid ?>"><button>New Employee</button></a>
      </div>
      <div class="grid_9">
        <?php
        date_default_timezone_set('Asia/Manila');
        $sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
        
        $today =  date('Y-m-d');
        $sign = "";
        $sqlquery="SELECT * FROM Attendance_t, Employee_t WHERE Employee_t.employee_id = $userid AND Employee_t.employee_id = Attendance_t.employee_id AND Attendance_t.signed_date = '".$today."' ";
        $result=@mysqli_query($sqlconn, $sqlquery);
        if($result == false || @mysqli_num_rows($result)==0) {
          echo "</br></br>You have not yet signed your attendance for today.</br>";
          $sign = "Sign In";
        }
        else {
          $row = @mysqli_fetch_array($result);
          if ($row['time_in']!=$row['time_out']) {
            echo "</br></br>You have already signed out. See you tomorrow!</br>";
            $sign = "Finished";
          }
          else{
            echo "</br></br>Are you leaving? Don't forget to sign out!</br>";
            $sign = "Sign Out";
          }
        }

        @mysqli_close($sqlconn);
        ?>
        <a href="attendanceprocess.php?userid=<?php echo $userid ?>">
          <center><button style="width:25%"><?php echo $sign ?></button></center>
        </a>
      </div>
    </div>
  	
  	</br>
  	</br>
  	</br>
  	<div class="footer">Copyright 2014</div>
</div>

</body>
</html>
