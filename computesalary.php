<html>

<head>
<title>Joanie's Cupcakes</title>
<link rel="stylesheet" href="everywhere.css" />
<link rel="stylesheet" href="960.css" />
<link rel="stylesheet" href="reset.css" />
<link rel="stylesheet" href="table.css" />

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
      <?php
        $sqlconn=@mysqli_connect("localhost", "root", "", "joanie") or die("There was a problem reaching the database.");
        $permission="SELECT * FROM Employee_t WHERE employee_id=$userid ";
        $result=@mysqli_query($sqlconn, $permission);
        $row = @mysqli_fetch_array($result);
        $rank = $row['job_title'];
        if ($rank=="Employee") {
          @mysqli_close($sqlconn);
          header ("Location: employeemenu.php");
        }
      ?>
      <div class="grid_3">
        </br>
        <h2>Compute Salaries</h2>
        </br>
        <form method="post">
        <p><font style="font-size:12px">Period</font></p>
        <select name="searchperiod">
          <option value="first">First Half (1-15)</option>
          <option value="second">Second Half (16-31)</option>
        </select>
        </br></br>
        <p><font style="font-size:12px">Month</font></p>
        <select name="searchmonth">
          <option value="01">January</option>
          <option value="02">February</option>
          <option value="03">March</option>
          <option value="04">April</option>
          <option value="05">May</option>
          <option value="06">June</option>
          <option value="07">July</option>
          <option value="08">August</option>
          <option value="09">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
        </br></br>
        <p><font style="font-size:12px">Year</font></p>
        <input type="text" name="searchyear"><br>
        </br>
        <input type="submit" name="compute" value="Compute"><br>
        </form>
        </br>
      </div>

      <div class="grid_3" align="right">
        <a href="salary.php"><button>All Salary Expenses</button></a>
      </div>
      <div class="grid_3" align="right">
        <a href="employeemenu.php"><button>Back to Menu</button></a>
      </div>

      <div class="grid_9">
        </br>
        <?php
          $sqlconn=@mysqli_connect("localhost", "root", "", "joanie") or die("There was a problem reaching the database.");

          $cmonth = "";
          $cyear = "";
          $cdayfrom = "";
          $cdayto = "";

          //if asked to compute
          $okay = "false";
          if(isset($_POST['searchyear'])) {
            $cyear=$_POST['searchyear'];
            if (ctype_digit($cyear))
              $okay = "true";
          }
          if(isset($_POST['searchmonth']))
            $cmonth=$_POST['searchmonth'];
          if(isset($_POST['searchperiod'])) {
            $period=$_POST['searchperiod'];
            if ($period=="first") {
              $cdayfrom = 1;
              $cdayto = 15;
            }
            else {
              $cdayfrom = 16;
              $cdayto = cal_days_in_month(CAL_GREGORIAN, $cmonth, $cyear);
            }
          }

          $employeecount = 0;
          $totalhours = 0;
          $totalpay = 0;

          if ($okay=="true") {
            $df = mktime(0, 0, 0, $cmonth, $cdayfrom, $cyear);
            $dt = mktime(0, 0, 0, $cmonth, $cdayto, $cyear);
            
            $cdatefrom = date('Y-m-d', $df);
            $cdateto = date('Y-m-d', $dt);

            //get all employees
            $sqlquery="SELECT * FROM Employee_t ";
            $result=@mysqli_query($sqlconn, $sqlquery);

            $temp="<table><tr><th>Employee Name</th><th>Days Present</th><th>Hours Worked</th><th>Salary per Hour</th><th>Pay for the Period</th></tr>";

            while($row = @mysqli_fetch_array($result)) {
              $curid = $row['employee_id'];
              $cursalary = $row['salary'];

              //for each employee, get all attendances between the dates
              $sqlattend="SELECT * FROM Attendance_t WHERE employee_id=$curid AND ( signed_date BETWEEN '".$cdatefrom."' AND '".$cdateto."' ) ";
              $attendances=@mysqli_query($sqlconn, $sqlattend);
              if(@mysqli_num_rows($attendances)>0) $employeecount++;

              $employeehours = 0;
              $employeedays = 0;
              //for each attendance, get total hours
              while($person = @mysqli_fetch_array($attendances)) {
                $employeedays++;
                $starttime = date("H", strtotime($person['time_in']));
                $endtime = date("H", strtotime($person['time_out']));

                $curhours = $endtime - $starttime;
                $employeehours = $employeehours + $curhours;
              }
              $employeesalary = $cursalary * $employeehours;
              $totalhours = $totalhours + $employeehours;
              $totalpay = $totalpay + $employeesalary;
              if(@mysqli_num_rows($attendances)>0) $temp.=("<tr><td>" . $row['last_name'] . ", " . $row['first_name'] . " </td><td> " . $employeedays . " </td><td> " . $employeehours . " </td><td> " . $cursalary . " </td><td> " . $employeesalary . "</td></tr>");
            }

            if($employeecount==0) {
              echo "No employee worked during that time period. No salaries can be computed.";
            }
            else {
              echo "Number of employees for the period: $employeecount </br>";
              echo "Total number of hours worked: $totalhours </br>";
              echo "Total salary expense for the period: $totalpay </br>";
              echo $temp . "</table>";
            }

            
            $exists = "true";
            //check if period already has salaryexpense record
            $ifexists = "SELECT * FROM SalaryExpense_t WHERE date_from BETWEEN '".$cdatefrom."' AND '".$cdateto."' ";
            $answer=@mysqli_query($sqlconn, $ifexists);
            if (@mysqli_num_rows($answer)==0) $exists = "false";
            
            //update record if it exists, otherwise add new record
            if ($exists == "true") {
              $sqlupdate = "UPDATE SalaryExpense_t SET date_from = '".$cdatefrom."', date_to = '".$cdateto."', total_salary = $totalpay WHERE date_from BETWEEN '".$cdatefrom."' AND '".$cdateto."' ";
              @mysqli_query($sqlconn, $sqlupdate);
            }
            else {
              $sqlstore = "INSERT INTO SalaryExpense_t (date_from, date_to, total_salary) VALUES ('".$cdatefrom."', '".$cdateto."', $totalpay) ";
              @mysqli_query($sqlconn, $sqlstore);
            }
          }
          else{
            echo "Please input the priod for which the total salary expense for all employees will be computed.";
            echo "</br>If that period already has a record, the salary expense will be recomputed and updated.";
            echo "</br>If the given period is ongoing, a tentative salary expense will be recorded.";
            echo "</br></br>IMPORTANT: Make sure to compute all salaries before asking for the sales report.";
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
