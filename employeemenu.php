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
  color: #FFD1FF;
}
p{ 
  margin-left: 30px;
  margin-bottom: 0;
  margin-top: 0;
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
  			<img src="images/logo.png" alt="Insert Logo Here" name="Insert_logo" width="169" height="155" id="Insert_logo" style="background-color: #C6D580; display:block;" />
  		</a> 
  		</br>
  		<?php
  		session_start();
  		$userid = $_SESSION['userid'];
      $_SESSION['userid'] = $userid;
  		?>
  	</div>

  	<div class="container_12">
  		<div class="grid_3">
        <a href="attendance.php"><button>Sign Attendance</button></a>
        <a href="viewattendance.php"><button>View Attendance</button></a>
        <a href="orders.php"><button>Orders</button></a>
  		  <a href="salary.php"><button>Salaries</button></a>
  		  <a href="expenses.php"><button>Expenses</button></a>
  		  <a href="payment.php"><button>Order Payment</button></a>
        <a href="sales.php"><button>Sales Report</button></a>
  		  <a href="employees.php"><button>Employees</button></a>
      </div>
      <div class="grid_9">
        <?php
        date_default_timezone_set('Asia/Manila');
        $sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
        $sqlquery="SELECT * FROM Employee_t WHERE employee_id = $userid ";
        $result=@mysqli_query($sqlconn, $sqlquery);
        $row = @mysqli_fetch_array($result);
        $name = $row['first_name'];
        echo "Welcome, $name!";
        $surname = $row['last_name'];
        $title = $row['job_title'];
        $job = $row['job_description'];

        $today =  date('Y-m-d');
        $sqlquery="SELECT * FROM Attendance_t, Employee_t WHERE Employee_t.employee_id = $userid AND Employee_t.employee_id = Attendance_t.employee_id AND Attendance_t.signed_date = '".$today."' ";
        $result=@mysqli_query($sqlconn, $sqlquery);
        if($result == false || @mysqli_num_rows($result)==0) {
          echo "</br></br>You have not yet signed your attendance for today.</br>";
        }
        else {
          $row = @mysqli_fetch_array($result);
          if ($row['time_in']!=$row['time_out']) {
            echo "</br></br>You have already signed out. Good job today!</br>";
          }
          else{
            echo "</br></br>Are you leaving? Don't forget to sign out!</br>";
          }
        }

        echo "</br></br>";
        echo "Account ID: $userid</br>";
        echo "Name: $surname, $name</br>";
        echo "Job Title: $title</br>";
        echo "Job Description: $job</br></br></br>";

        if ($title=="Administrator")
          echo "<p>You have full access to the site.</p></br>";
        else {
          echo "<p>You have limited access to the site.</p></br>";
          echo "<p>You cannot view the attendance of other employees.</p></br>";
          echo "<p>You cannot view the salaries of other employees.</p></br>";
          echo "<p>You cannot view nor request for a sales report.</p></br>";
          echo "<p>You cannot view the list of employees.</p></br>";
          echo "<p>You cannot create a new employee account.</p></br>";
        }

        @mysqli_close($sqlconn);
        ?>
      </div>
    </div>
  	
  	</br>
  	</br>
  	</br>
  	<div class="footer"><img src="images/Logo3.png" width="50" height="50" />Copyright 2014</div>
</div>

</body>
</html>
