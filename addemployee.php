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
  		  <a href="attendance.php?userid=<?php echo $userid ?>"><button>New Employee</button></a>
      </div>
      </br></br></br>
      <?php 
      $output = "";
      $sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
      $sqlquery="SELECT * FROM Employee_t WHERE employee_id = $userid ";
      $result=@mysqli_query($sqlconn, $sqlquery);
      $row = @mysqli_fetch_array($result);
      $title = $row['job_title'];
      
      if ($title=="Administrator") {
        $output.='<div class="grid_4" align="right"><font color="#CCCCCC">First Name: </font></div>';
        $output.='<div class="grid_4" align="left"><input  type="text" name="aefirst" placeholder="Mary Ann"/> </div>';
        $output.='<div class="grid_4" align="right"><font color="#CCCCCC">Last Name: </font></div>';
        $output.='<div class="grid_4" align="left"><input  type="text" name="aelast" placeholder="Cruz"/> </div>';
        $output.='<div class="grid_4" align="right"><font color="#CCCCCC">Job Title: </font></div>';
        $output.='<div class="grid_4" align="left"><input  type="text" name="aetitle" placeholder="Employee / Administrator"/> </div>';
        $output.='<div class="grid_4" align="right"><font color="#CCCCCC">Job Description: </font></div>';
        $output.='<div class="grid_4" align="left"><input  type="text" name="aedesc" placeholder="Cashier"/> </div>';
        $output.='<div class="grid_4" align="right"><font color="#CCCCCC">Salary per hour: </font></div>';
        $output.='<div class="grid_4" align="left"><input  type="text" name="aesal" placeholder="500.00"/> </div>';
        $output.='<div class="grid_4" align="right"><font color="#CCCCCC">Set Password: </font></div>';
        $output.='<div class="grid_4" align="left"><input  type="text" name="aepass" placeholder="mypassword"/> </div>';
        $output.='<div class="grid_9" align="center"><a href="addemployeeprocess.php?userid=<?php echo $userid ?>"><button id="Submit" style="background-color:#EE637E; color:#3C2312; border-radius:50px; height:50px;width:200px"> Add New Employee </button></a></div>';
      }
      else {
        $output.="You do not have permission to access this feature.";
      }
      echo $output;
      @mysqli_close($sqlconn);
      ?>
    </div>
  	
  	</br>
  	</br>
  	</br>
  	<div class="footer">Copyright 2014</div>
</div>

</body>
</html>
