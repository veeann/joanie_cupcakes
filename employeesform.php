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
      $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
      $id = parse_url($url, PHP_URL_QUERY);
      $permission="SELECT * FROM Employee_t WHERE employee_id=$userid ";
      $result=@mysqli_query($sqlconn, $permission);
      $row = @mysqli_fetch_array($result);
      $rank = $row['job_title'];
      
      $sidebar = '<div ';
      if ($id=="addemp") {
        $sidebar .= 'class="grid_3">';
        if ($rank=="Employee") {
          $sidebar .= '<p><a href="employees.php"><button>Employee Information</button></a></p>';
          $sidebar .= '<p><a href="employeemenu.php"><button>Back to Menu</button></a></p>';
          $sidebar .= '</div><div class="grid_9" align="center">';
          $sidebar .= '<p>You have no permission to add an new employee.</p>';
        }
        else {
          $sidebar .= '<p><a href="employees.php"><button>All Employees</button></a></p>';
          $sidebar .= '<p><a href="employeemenu.php"><button>Back to Menu</button></a></p>';
          $sidebar .= '</div><div class="grid_4" align="center">';
          $sidebar .= '<form method="post">';
          $sidebar .= '<p>Last Name:</p>';
          $sidebar .= '<p><input type="text" name="lastn" placeholder="Cruz" /></p>';
          $sidebar .= '</br>';
          $sidebar .= '<p>First Name:</p>';
          $sidebar .= '<p><input type="text" name="firstn" placeholder="Mary Ann" /></p>';
          $sidebar .= '</br>';
          $sidebar .= '<p>Job Title:</p>';
          $sidebar .= '<p><select name="jobti">
                        <option value="Administrator">Administrator</option>
                        <option value="Employee">Employee</option>
                      </select></p>';
          $sidebar .= '</br>';
          $sidebar .= '<p>Job Description:</p>';
          $sidebar .= '<p><input type="text" name="jobdesc" placeholder="Cashier" /></p>';
          $sidebar .= '</br></div><div class="grid_4" align="center">';
          $sidebar .= '<p>Salary:</p>';
          $sidebar .= '<p><input type="text" name="salary" placeholder="500.00" /></p>';
          $sidebar .= '</br>';
          $sidebar .= '<p>Password:</p>';
          $sidebar .= '<p><input type="text" name="pass" placeholder="mypassword" /></p>';
          $sidebar .= '</br>';
          $sidebar .= '<p><input type="submit" value="Add New Employee" /></p>';
          $sidebar .= '</form>';
        }
      }
      else {
        $sidebar .= 'class="grid_3">';
        $sidebar .= '<p><a href="employees.php"><button>All Employees</button></a></p>';
        $sidebar .= '<p><a href="employeemenu.php"><button>Back to Menu</button></a></p></br>';
        $sidebar .= '<form method="post">';
        if ($rank=="Administrator") {
          $sidebar .= '<p>Update Job Title:</p>';
          $sidebar .= '<p><select name="uptitle">
                        <option value="nothing">--</option>
                        <option value="Administrator">Administrator</option>
                        <option value="Employee">Employee</option>
                      </select></p>';
          $sidebar .= '</br>';
          $sidebar .= '<p>Update Job Descrption:</p>';
          $sidebar .= '<p><input type="text" name="updesc" placeholder="Leave blank to retain" /></p>';
          $sidebar .= '</br>';
          $sidebar .= '<p>Update Salary:</p>';
          $sidebar .= '<p><input type="text" name="upsal" placeholder="Leave blank to retain" /></p>';
          $sidebar .= '</br>';
        }
        $sidebar .= '<p>Update Password:</p>';
        $sidebar .= '<p><input type="text" name="uppass" placeholder="Leave blank to retain" /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p><input type="submit" value="Update" /></p>';
        $sidebar .= '</form>';
      }
      $sidebar .= '</div>';
      echo $sidebar;
      ?>

      <div class="grid_9">
        
        <?php
        if ($id=="addemp") {
          $theworker = "INSERT INTO Employee_t (last_name, first_name, job_title, job_description, salary, password) VALUES (";
          if (!empty($_POST['lastn']) && !empty($_POST['firstn'])) {
            $theworker .= "  '".$_POST['lastn']."', '".$_POST['firstn']."', ";
            $theworker .= " '".$_POST['jobti']."', ";
            if (!empty($_POST['jobdesc'])) {
              
              $theworker .= " '".$_POST['jobdesc']."', ";
              if (!empty($_POST['salary'])) {
                $numform = '/\d+.\d+/';
                if (preg_match($numform, $_POST['salary'])) {
                  $presyo = $_POST['salary'];
                  $theworker .= "$presyo, ";
                  if (!empty($_POST['pass'])) {
                    $theworker .= "  '".$_POST['pass']."') ";
                    //echo "$theworker";
                    @mysqli_query($sqlconn,$theworker); 
                    @mysqli_close($sqlconn);
                    header ("Location: employees.php");
                  }
                }
              }
            }
          }
        }
        else {
          $result=@mysqli_query($sqlconn, "SELECT * FROM Employee_t WHERE employee_id=$id");
          
          if(@mysqli_num_rows($result) == 0)
            echo "No employee record found.";
          else{
            echo '<table><tr><th /><th>Record Details</th></tr>';
            $row = @mysqli_fetch_array($result);
            echo "<tr><td>Employee ID</td><td>$id</td></tr>";
            echo "<tr><td>Last Name</td><td>{$row['last_name']}</td></tr>";
            echo "<tr><td>First Name</td><td>{$row['first_name']}</td></tr>";
            echo "<tr><td>Job Title</td><td>{$row['job_title']}</td></tr>";
            echo "<tr><td>Job Description</td><td>{$row['job_description']}</td></tr>";
            echo "<tr><td>Salary</td><td>{$row['salary']}</td></tr>";
            echo "<tr><td>Password</td><td>{$row['password']}</td></tr>";
            echo "</table>";
          }
          
          if(isset($_POST['uptitle'])){
            $check = $_POST['uptitle'];
            if ($check=="nothing") {
              //echo "<script type=\"text/javascript\">location.reload();</script>";
            }
            else {
              @mysqli_query($sqlconn, "UPDATE Employee_t SET job_title='".$check."' WHERE employee_id=$id");
              //echo "<script type=\"text/javascript\">location.reload();</script>";
            }
            header ("Location: employeesform.php?$id");
          }
          if(!empty($_POST['updesc'])){
            $check = $_POST['updesc'];
            @mysqli_query($sqlconn, "UPDATE Employee_t SET job_description='".$check."' WHERE employee_id=$id");
            //echo "<script type=\"text/javascript\">location.reload();</script>";
            header ("Location: employeesform.php?$id");
          }
          if(!empty($_POST['upsal'])){
            $check = $_POST['upsal'];
            $numform = '/\d+.\d+/';
            if (!preg_match($numform, $check)) {
              //echo "<script type=\"text/javascript\">location.reload();</script>";
            }
            else {
              @mysqli_query($sqlconn, "UPDATE Employee_t SET salary=$check WHERE employee_id=$id");
              //echo "<script type=\"text/javascript\">location.reload();</script>";
            }
            header ("Location: employeesform.php?$id");
          }
          if(!empty($_POST['uppass'])){
            $check = $_POST['uppass'];
            @mysqli_query($sqlconn, "UPDATE Employee_t SET password='".$check."' WHERE employee_id=$id");
            //echo "<script type=\"text/javascript\">location.reload();</script>";
            header ("Location: employeesform.php?$id");
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
