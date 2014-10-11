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
      
      $sidebar = '<div ';
      if ($id=="addexpense") {
        $sidebar .= 'class="grid_3">';
        $sidebar .= '<p><a href="expenses.php"><button>All Expenses</button></a></p>';
        $sidebar .= '<p><a href="employeemenu.php"><button>Back to Menu</button></a></p>';
        $sidebar .= '</div><div class="grid_9" align="center">';
        $sidebar .= '<form method="post">';
        $sidebar .= '<p>Price:</p>';
        $sidebar .= '<p><input type="text" name="price" placeholder="100.00" /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p>Details:</p>';;
        $sidebar .= '<p><input type="text" name="details" placeholder="Ingredients" /></p></br>';
        $sidebar .= '<p><input type="submit" value="Add Expense" /></p>';
        $sidebar .= '</form>';
      }
      else {
        $sidebar .= 'class="grid_3">';
        $sidebar .= '<p><a href="expenses.php"><button>All Expenses</button></a></p></br>';
        $sidebar .= '<form method="post">';
        $sidebar .= '<p><input type="submit" name="delexpense" value="Delete Expense" /></p>';
        $sidebar .= '</form>';
      }
      $sidebar .= '</div>';
      echo $sidebar;
      ?>

      <div class="grid_9">
        
        <?php
        date_default_timezone_set('Asia/Manila');
        $today =  date('Y-m-d H:i:s');
        if ($id=="addexpense") {
          $theexpense = "INSERT INTO Expense_t (expense_date, price, details) VALUES ('".$today."', ";

          
            if (!empty($_POST['details']) && !empty($_POST['price'])) {
              $numform = '/\d+.\d+/';
              if (preg_match($numform, $_POST['price'])) {
                $presyo = $_POST['price'];
                $theexpense .= "$presyo, '".$_POST['details']."') ";
                @mysqli_query($sqlconn,$theexpense); 
                @mysqli_close($sqlconn);
                header ("Location: expenses.php");
              }      
            }
          
        }
        else {
          $result=@mysqli_query($sqlconn, "SELECT * FROM Expense_t WHERE expense_id=$id");
          
          if(@mysqli_num_rows($result) == 0)
            echo "No order record found.";
          else{
            echo '<table><tr><th /><th>Record Details</th></tr>';
            $row = @mysqli_fetch_array($result);
            echo "<tr><td>Expense ID</td><td>$id</td></tr>";
            echo "<tr><td>Date</td><td>{$row['expense_date']}</td></tr>";
            echo "<tr><td>Price</td><td>{$row['price']}</td></tr>";
            echo "<tr><td>Details</td><td>{$row['details']}</td></tr>";
            echo "</table>";
            if ( isset( $_POST['delexpense'] ) ) { 
              $deleteex = "DELETE FROM Expense_t WHERE expense_id=$id ";
              @mysqli_query($sqlconn,$deleteex);
              @mysqli_close($sqlconn);
              header ("Location: expenses.php");
            }
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
