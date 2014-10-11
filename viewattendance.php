<html>

<head>
<title>Joanie's Cupcakes</title>
<link rel="stylesheet" href="everywhere.css" />
<link rel="stylesheet" href="960.css" />
<link rel="stylesheet" href="reset.css" />
<link rel="stylesheet" href="table.css" />

<style type="text/javascript">
function reload(){
  location.reload();
}
</style>

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
        <h2>Search By</h2>
        <form method="post">
        <select name="searchby">
          <?php 
          $sqlconn=@mysqli_connect("localhost", "root", "", "joanie") or die("There was a problem reaching the database.");
          $permission="SELECT * FROM Employee_t WHERE employee_id=$userid ";
          $result=@mysqli_query($sqlconn, $permission);
          $row = @mysqli_fetch_array($result);
          $rank = $row['job_title'];

          $choices = '<option value="day">Signed Date</option>';
          if ($rank=="Administrator") {
            $choices .= '<option value="attend">Attendance ID</option>';
            $choices .= '<option value="employ">Employee ID</option>';
          }
          echo "$choices";
          @mysqli_close($sqlconn);
          ?>
        </select>
        <input type="text" name="search"><br>
        </form>
        </br>
      </div>

      <div class="grid_3" align="right">
        <a href="employeemenu.php"><button>Back to Menu</button></a>
      </div>

      <div class="grid_12">
        <?php
          $sqlconn=@mysqli_connect("localhost", "root", "", "joanie") or die("There was a problem reaching the database.");
          $permission="SELECT * FROM Employee_t WHERE employee_id=$userid ";
          $result=@mysqli_query($sqlconn, $permission);
          $row = @mysqli_fetch_array($result);
          $rank = $row['job_title'];
          $sqlquery="SELECT * FROM Attendance_t ";
          
          //Check search query, default is show all:
          $searchterm="%";
          $searchby="firstname";

          if ($rank=="Employee") {
            $searchterm=$userid;
            $searchby="employ";
          }
          
          if(isset($_POST['searchby']))
            $searchby=$_POST['searchby'];
          if(isset($_POST['search']))
            $searchterm=$_POST['search'];
          
          if($searchby=="employ")
            $sqlquery.="WHERE employee_id = $searchterm ";
          else if($searchby=="attend")
            $sqlquery.="WHERE attendance_id = $searchterm ";
          else if($searchby=="day") {
            if ($rank=="Administrator")
              $sqlquery.="WHERE upper(signed_date) LIKE upper(\"%$searchterm%\") ";
            else
              $sqlquery.="WHERE employee_id=$userid AND upper(signed_date) LIKE upper(\"%$searchterm%\") ";
          }


          $result=@mysqli_query($sqlconn, $sqlquery);
          
          if($result == false)
            echo "No results found.";
          else {
            $temp="<table><tr><th>Attendance ID</th><th>Employee ID</th><th>Signed Date</th><th>Time In</th><th>Time Out</th></tr>";
            while($row = @mysqli_fetch_array($result)){
              $attendanceid=$row['attendance_id'];
              $temp.=("<tr><td>" . $row['attendance_id'] . " </td><td> " . $row['employee_id'] . " </td><td> " . $row['signed_date'] . " </td><td> " . $row['time_in'] . "</td><td>" . $row['time_out'] . "</td></tr>");
            }
            if(@mysqli_num_rows($result)==0)
              echo "No results found.";
            else
              echo $temp . "</table>";
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
