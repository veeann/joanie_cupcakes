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
        <h2>Compute Sales</h2>
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
        <a href="sales.php"><button>All Sales Reports</button></a>
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

          $totalexpenses = 0;
          $totalincome = 0;

          if ($okay=="true") {
            $df = mktime(0, 0, 0, $cmonth, $cdayfrom, $cyear);
            $dt = mktime(0, 0, 0, $cmonth, $cdayto, $cyear);
            
            $cdatefrom = date('Y-m-d', $df);
            $cdateto = date('Y-m-d', $dt);

            $temp="<table><tr><th>Date</th><th>Price</th><th>Details</th></tr>";
            //get all expenses
            $count = 0;
            $sqlquery="SELECT * FROM Expense_t WHERE expense_date BETWEEN '".$cdatefrom."' AND '".$cdateto."' ";
            $result=@mysqli_query($sqlconn, $sqlquery);
            while($row = @mysqli_fetch_array($result)) {
              $totalexpenses = $totalexpenses + $row['price'];
              $temp.=("<tr><td>" . $row['expense_date'] . " </td><td> " . $row['price'] . " </td><td> " . $row['details'] . " </td></tr>");
            }
            $count = $count + @mysqli_num_rows($result);

            //get all salary expenses
            $sqlquery="SELECT * FROM SalaryExpense_t WHERE date_from BETWEEN '".$cdatefrom."' AND '".$cdateto."' ";
            $result=@mysqli_query($sqlconn, $sqlquery);
            while($row = @mysqli_fetch_array($result)) {
              $totalexpenses = $totalexpenses + $row['total_salary'];
              $temp.=("<tr><td>" . $row['date_to'] . " </td><td> " . $row['total_salary'] . " </td><td>Salary Expense</td></tr>");
            }
            $count = $count + @mysqli_num_rows($result);

            if ($count==0) $temp = "</br>There were no expenses for this period.</br>";
            else $temp .= "</table>";

            $temp2="<table><tr><th>Date</th><th>Payment</th><th>Order</th></tr>";
            //get all payments
            $sqlquery="SELECT * FROM Payment_t WHERE pay_date BETWEEN '".$cdatefrom."' AND '".$cdateto."' ";
            $result=@mysqli_query($sqlconn, $sqlquery);
            while($row = @mysqli_fetch_array($result)) {
              $totalincome = $totalincome + $row['price'];
              $temp2.=("<tr><td>" . $row['pay_date'] . " </td><td> " . $row['price'] . " </td><td> " . $row['order_id'] . " </td></tr>");
            }
            if (@mysqli_num_rows($result)==0) $temp2 = "</br>There was no income gained during the period.";
            else $temp2 .= "</table>";

            $profit = $totalincome - $totalexpenses;
            echo "Total Expenses: $totalexpenses </br>";
            echo "Gross Income: $totalincome </br>";
            echo "Net Profit: $profit </br></br>Expenses:";
            echo $temp;
            echo "</br>Income:";
            echo $temp2;

            if ($totalincome!=0 || $totalexpenses!=0 || $profit!=0) {
              $exists = "true";
              //check if period already has sales record
              $ifexists = "SELECT * FROM Report_t WHERE date_from BETWEEN '".$cdatefrom."' AND '".$cdateto."' ";
              $answer=@mysqli_query($sqlconn, $ifexists);
              if (@mysqli_num_rows($answer)==0) $exists = "false";
              
              //update record if it exists, otherwise add new record
              if ($exists == "true") {
                $sqlupdate = "UPDATE Report_t SET date_from = '".$cdatefrom."', date_to = '".$cdateto."', gross_income = $totalincome, total_expenses = $totalexpenses, net_income = $profit WHERE date_from BETWEEN '".$cdatefrom."' AND '".$cdateto."' ";
                @mysqli_query($sqlconn, $sqlupdate);
              }
              else {
                $sqlstore = "INSERT INTO Report_t (date_from, date_to, gross_income, total_expenses, net_income) VALUES ('".$cdatefrom."', '".$cdateto."', $totalincome, $totalexpenses, $profit) ";
                @mysqli_query($sqlconn, $sqlstore);
              }
            }
          }
          else{
            echo "Please input the priod for which the sales report will be given.";
            echo "</br>If that period already has a record, the existing report will be recomputed and overwritten.";
            echo "</br>If the given period is ongoing, a tentative report will be outputed and recorded.";
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
