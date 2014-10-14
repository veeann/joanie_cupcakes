<html>

<head>
<title>Joanie's Cupcakes</title>
<link rel="stylesheet" href="everywhere.css" />
<link rel="stylesheet" href="960.css" />
<link rel="stylesheet" href="reset.css" />
<link rel="stylesheet" href="table.css" />

<script type="text/javascript">
function redirect(id){
  window.location.assign("employeesform.php?"+id);
}
</script>

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
          <option value="empid">Employee ID</option>
          <option value="empln">Last Name</option>
          <option value="empfn">First Name</option>
          <option value="empjt">Job Title</option>
          <option value="empjd">Job Description</option>
        </select>
        <input type="text" name="search"><br>
        </form>
        </br>
      </div>

      <div class="grid_3" align="right">
        <a href="employeesform.php?addemp"><button>Add New Employee</button></a>
      </div>
      <div class="grid_3" align="right">
        <a href="employees.php"><button>All Employees</button></a>
      </div>
      <div class="grid_3" align="right">
        <a href="employeemenu.php"><button>Back to Menu</button></a>
      </div>

      <div class="grid_12">
        <?php
        $sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
        $permission="SELECT * FROM Employee_t WHERE employee_id=$userid ";
        $result=@mysqli_query($sqlconn, $permission);
        $row = @mysqli_fetch_array($result);
        $rank = $row['job_title'];

        if ($rank=="Employee") {
          header ("Location: employeesform.php?$userid");
        }
        else {
          $sqlquery="SELECT * FROM Employee_t ";
          
          //Check search query, default is show all:
          $searchterm="%";
          $searchby="firstname";
          
          if(isset($_POST['searchby']))
            $searchby=$_POST['searchby'];
          if(isset($_POST['search']))
            $searchterm=$_POST['search'];
          
          $current = array("\\", "'", "\"");
          $shouldb   = array("\\\\", "\'", "\\\"");
          $newphrase = str_replace($current, $shouldb, $searchterm);
          $searchterm = $newphrase;
          
          if($searchby=="empid")
            $sqlquery.="WHERE employee_id = $searchterm ";
          else if($searchby=="empln")
            $sqlquery.="WHERE upper(last_name) LIKE upper(\"%$searchterm%\") ";
          else if($searchby=="empfn")
            $sqlquery.="WHERE upper(first_name) LIKE upper(\"%$searchterm%\") ";
          else if($searchby=="empjt")
            $sqlquery.="WHERE upper(job_title) LIKE upper(\"$searchterm\") ";
          else if($searchby=="empjd")
            $sqlquery.="WHERE upper(job_description) LIKE upper(\"%$searchterm%\") ";
          
          $result=@mysqli_query($sqlconn, $sqlquery);
          
          if($result == false)
            echo "No results found.";
          else {
            $temp="<table><tr><th>Employee ID</th><th>Last Name</th><th>First Name</th><th>Job Title</th><th>Job Description</th></tr>";
            while($row = @mysqli_fetch_array($result)){
              $employeeid=$row['employee_id'];
              $temp.=("<tr onclick=\"redirect($employeeid)\" ><td>" . $row['employee_id'] . " </td><td> " . $row['last_name'] . " </td><td> " . $row['first_name'] . " </td><td> " . $row['job_title'] . "</td><td>" . $row['job_description'] . "</td></tr>");
            }
            if(@mysqli_num_rows($result)==0)
              echo "No results found.";
            else
              echo $temp . "</table>";
          }
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
