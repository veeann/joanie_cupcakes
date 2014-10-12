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
      if ($id=="addorder") {
        $sidebar .= 'class="grid_3">';
        $sidebar .= '<p><a href="orders.php"><button>All Orders</button></a></p>';
        $sidebar .= '<p><a href="employeemenu.php"><button>Back to Menu</button></a></p>';
        $sidebar .= '</div><div class="grid_4" align="center">';
        $sidebar .= '<form method="post">';
        $sidebar .= '<p>Last Name:</p>';
        $sidebar .= '<p><input type="text" name="lastn" placeholder="Cruz" /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p>First Name:</p>';
        $sidebar .= '<p><input type="text" name="firstn" placeholder="Mary Ann" /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p>Email:</p>';
        $sidebar .= '<p><input type="text" name="email" placeholder="maryann@joanies.com" /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p>Contact Number:</p>';
        $sidebar .= '<p><input type="text" name="cnum" placeholder="0912-345-6789" /></p>';
        $sidebar .= '</br></div><div class="grid_4" align="center">';
        $sidebar .= '<p>Details:</p>';
        $sidebar .= '<p><input type="text" name="details" placeholder="A giant cake." /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p>Price:</p>';
        $sidebar .= '<p><input type="text" name="price" placeholder="500.00" /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p>Status:</p>';
        $sidebar .= '<p><select name="status">
                        <option value="Placed">Placed</option>
                        <option value="Priced">Priced</option>
                        <option value="Processing">Processing</option>
                        <option value="Finished">Finished</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Cancelled">Cancelled</option>
                      </select></p></br>';
        $sidebar .= '<p><input type="submit" value="Add Order" /></p>';
        $sidebar .= '</form>';
      }
      else {
        $sidebar .= 'class="grid_3">';
        $sidebar .= '<p><a href="orders.php"><button>All Orders</button></a></p>';
        $sidebar .= '<p><a href="paymentsform.php?addpay"><button>Add Payment</button></a></p></br>';
        $sidebar .= '<form method="post">';
        $sidebar .= '<p>Update Price:</p>';
        $sidebar .= '<p><input type="text" name="updateprice" placeholder="Leave blank to retain" /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p>Update Status:</p>';
        $sidebar .= '<p><select name="updatestatus">
                        <option value="nothing">--</option>
                        <option value="Placed">Placed</option>
                        <option value="Priced">Priced</option>
                        <option value="Processing">Processing</option>
                        <option value="Finished">Finished</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Cancelled">Cancelled</option>
                      </select></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p><input type="submit" value="Update" /></p>';
        $sidebar .= '</form>';
      }
      $sidebar .= '</div>';
      echo $sidebar;
      ?>

      <div class="grid_9">
        
        <?php
        date_default_timezone_set('Asia/Manila');
        $today =  date('Y-m-d H:i:s');
        if ($id=="addorder") {
          $theorder = "INSERT INTO Order_t (order_date, customer_last_name, customer_first_name, customer_email, customer_contact_number, details, price, status) VALUES ('".$today."', ";

          if (!empty($_POST['lastn']) && !empty($_POST['firstn'])) {
            $theorder .= "  '".$_POST['lastn']."', '".$_POST['firstn']."', ";
            if (!empty($_POST['details']) && !empty($_POST['email'])) {
              $emformat = '/\S+@\S+.\S+/';
              if (preg_match($emformat, $_POST['email'])) {
                $theorder .= " '".$_POST['email']."', ";
                if (!empty($_POST['cnum'])) {
                  $numforma = '/\d{11}/';
                  $numformb = '/\d{4}-\d{3}-\d{4}/';
                  if (preg_match($numforma, $_POST['cnum']) || preg_match($numformb, $_POST['cnum'])) {
                    $temp = str_replace("-","",$_POST['cnum']);
                    $theorder .= " '$temp', ";
                    $theorder .= " '".$_POST['details']."', ";
                    if (!empty($_POST['price'])) {
                      $numform = '/\d+.\d+/';
                      if (preg_match($numform, $_POST['price'])) {
                        $presyo = $_POST['price'];
                        $theorder .= "$presyo, ";
                        $theorder .= "  '".$_POST['status']."') ";
                        @mysqli_query($sqlconn,$theorder); 
                        @mysqli_close($sqlconn);
                        header ("Location: orders.php");
                      }
                    }
                  }
                }
              }
            }
          }
        }
        else {
          $result=@mysqli_query($sqlconn, "SELECT * FROM Order_t WHERE order_id=$id");
          
          if(@mysqli_num_rows($result) == 0)
            echo "No order record found.";
          else{
            echo '<table><tr><th /><th>Record Details</th></tr>';
            $row = @mysqli_fetch_array($result);
            echo "<tr><td>Order ID</td><td>$id</td></tr>";
            echo "<tr><td>Date</td><td>{$row['order_date']}</td></tr>";
            echo "<tr><td>Last Name</td><td>{$row['customer_last_name']}</td></tr>";
            echo "<tr><td>First Name</td><td>{$row['customer_first_name']}</td></tr>";
            echo "<tr><td>Email</td><td>{$row['customer_email']}</td></tr>";
            echo "<tr><td>Contact Numbers</td><td>{$row['customer_contact_number']}</td></tr>";
            echo "<tr><td>Details</td><td>{$row['details']}</td></tr>";
            echo "<tr><td>Price</td><td>{$row['price']}</td></tr>";
            echo "<tr><td>Status</td><td>{$row['status']}</td></tr>";
            echo "</table>";
          }
          
          if(!empty($_POST['updateprice'])){
            $check = $_POST['updateprice'];
            $numform = '/\d+.\d+/';
            if (!preg_match($numform, $check)) {
              //echo "<script type=\"text/javascript\">location.reload();</script>";
            }
            else {
              @mysqli_query($sqlconn, "UPDATE Order_t SET price=$check WHERE order_id=$id");
              //echo "<script type=\"text/javascript\">location.reload();</script>";
            }
            header ("Location: ordersform.php?$id");
          }
          if(isset($_POST['updatestatus'])){
            $check = $_POST['updatestatus'];
            if ($check=="nothing") {
              //echo "<script type=\"text/javascript\">location.reload();</script>";
            }
            else {
              @mysqli_query($sqlconn, "UPDATE Order_t SET status='".$check."' WHERE order_id=$id");
              //echo "<script type=\"text/javascript\">location.reload();</script>";
            }
            header ("Location: ordersform.php?$id");
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
