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
                     <option value="salarid">Salary ID</option>
                    
                  </select>
                  <input type="text" name="search"><br>
                  </form>
                  </br>
                </div>';
          echo '<div class="grid_3" align="right">
                <a href="computesalary.php"><button>Compute Salary</button></a>
                </div>';
          echo '<div class="grid_3" align="right">
                <a href="salary.php"><button>All Salary Expenses</button></a>
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
          $sqlquery="SELECT * FROM SalaryExpense_t ";
          
          if ($rank=="Administrator") {
            $searchterm="%";
            $searchby="firstname";
            
            if(isset($_POST['searchby']))
              $searchby=$_POST['searchby'];
            if(isset($_POST['search']))
              $searchterm=$_POST['search'];
            
            if($searchby=="salarid")
              $sqlquery.="WHERE salary_expense_id = $searchterm ";
            else if($searchby=="day") {
              $timegiven = strtotime($searchterm);
              $dategiven = date("Y-m-d", $timegiven);
              $sqlquery.="WHERE (\"$dategiven\" BETWEEN date_from AND date_to) ";
            }

            $sqlquery.="ORDER BY date_from DESC ";

            $result=@mysqli_query($sqlconn, $sqlquery);
            
            if($result == false)
              echo "No results found.";
            else {
              $temp="<table><tr><th>Salary Expense ID</th><th>Date From</th><th>Date To</th><th>Total Salary</th></tr>";
              while($row = @mysqli_fetch_array($result)){
                $temp.=("<tr><td>" . $row['salary_expense_id'] . " </td><td> " . $row['date_from'] . " </td><td> " . $row['date_to'] . " </td><td> " . $row['total_salary'] . "</td></tr>");
              }
              if(@mysqli_num_rows($result)==0)
                echo "No results found.";
              else
                echo $temp . "</table>";
            }
          }
          else {
            echo "</br>You have no permission to view the salary expense records.";
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
