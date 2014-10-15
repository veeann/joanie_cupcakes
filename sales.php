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
      <?php 
        $sqlconn=@mysqli_connect("localhost", "root", "", "joanie") or die("There was a problem reaching the database.");
        $permission="SELECT * FROM Employee_t WHERE employee_id=$userid ";
        $result=@mysqli_query($sqlconn, $permission);
        $row = @mysqli_fetch_array($result);
        $rank = $row['job_title'];
        if ($rank=="Administrator") {
          echo '<div class="grid_3">
                  <h2>Search By</h2>
                  <form method="post">
                  <select name="searchby">
                      <option value="day">Date</option>
                     <option value="repid">Report ID</option>
                    
                  </select>
                  <input type="text" name="search"><br>
                  </form>
                  </br>
                </div>';
          echo '<div class="grid_3" align="right">
                <a href="computesales.php"><button>Compute Sales</button></a>
                </div>';
          echo '<div class="grid_3" align="right">
                <a href="sales.php"><button>All Sales Reports</button></a>
                </div>';
        }
        @mysqli_close($sqlconn);
      ?>
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
          $sqlquery="SELECT * FROM Report_t ";

          $totalincome = 0;
          $totalexpenses = 0;
          $profit = 0;
          
          if ($rank=="Administrator") {
            $searchterm="%";
            $searchby="firstname";
            
            if(isset($_POST['searchby']))
              $searchby=$_POST['searchby'];
            if(isset($_POST['search']))
              $searchterm=$_POST['search'];

            if (!preg_match('/[a-zA-Z0-9\s]+/', $searchterm))
              $searchterm = "-";
            
            if($searchby=="repid")
              $sqlquery.="WHERE report_id = $searchterm ";
            else if($searchby=="day") {
              $timegiven = strtotime($searchterm);
              $dategiven = date("Y-m-d", $timegiven);
              $sqlquery.="WHERE (\"$dategiven\" BETWEEN date_from AND date_to) ";
            }

            if ($searchby=="day" && !preg_match('/\d{4}-\d{2}-\d{2}/', $searchterm))
              echo "Date Format must be: YYYY-MM-DD";
            else {

              $sqlquery.="ORDER BY date_to DESC ";

              $result=@mysqli_query($sqlconn, $sqlquery);
              
              if($result == false)
                echo "No results found.";
              else {
                $temp="<table><tr><th>Report ID</th><th>Date From</th><th>Date To</th><th>Gross Income</th><th>Total Expenses</th><th>Profit</th></tr>";
                while($row = @mysqli_fetch_array($result)){
                  $totalincome = $totalincome + $row['gross_income'];
                  $totalexpenses = $totalexpenses + $row['total_expenses'];
                  $temp.=("<tr><td>" . $row['report_id'] . " </td><td> " . $row['date_from'] . " </td><td> " . $row['date_to'] . " </td><td> " . $row['gross_income'] . "</td><td> " . $row['total_expenses'] . "</td><td> " . $row['net_income'] . "</td></tr>");
                }
                $profit = $totalincome - $totalexpenses;
                if(@mysqli_num_rows($result)==0)
                  echo "No results found.";
                else {
                  echo "Gross Income: $totalincome</br>";
                  echo "Total Expenses: $totalexpenses</br>";
                  echo "Net Profit: $profit</br></br>";
                  echo $temp . "</table>";
                }
              }
            }
          }
          else {
            echo "</br>You have no permission to view the sales records.";
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
