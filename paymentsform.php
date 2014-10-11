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

<script type="text/javascript">
function redirect(id){
  window.location.assign("ordersform.php?"+id);
}
</script>

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
      if ($id=="addpay") {
        $sidebar .= 'class="grid_3">';
        $sidebar .= '<p><a href="payment.php"><button>All Payments</button></a></p>';
        $sidebar .= '<p><a href="employeemenu.php"><button>Back to Menu</button></a></p>';
        $sidebar .= '</div><div class="grid_4" align="center">';
        $sidebar .= '<form method="post">';
        $sidebar .= '<p>Price:</p>';
        $sidebar .= '<p><input type="text" name="price" placeholder="500.00" /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p>Order ID:</p>';
        $sidebar .= '<p><input type="text" name="orderid" placeholder="1" /></p>';
        $sidebar .= '</br>';
        $sidebar .= '<p><input type="submit" value="Add Payment" /></p>';
        $sidebar .= '</form>';
      }
      else {
        $sidebar .= 'class="grid_3">';
        $sidebar .= '<p><a href="payment.php"><button>All Payments</button></a></p></br>';
        $sidebar .= '<form method="post">';
        $sidebar .= '<p><input type="submit" name="delpay" value="Delete Payment" /></p>';
        $sidebar .= '</form>';
      }
      $sidebar .= '</div>';
      echo $sidebar;
      ?>

      <div class="grid_9">
        
        <?php
        date_default_timezone_set('Asia/Manila');
        $today =  date('Y-m-d H:i:s');
        if ($id=="addpay") {
          $thepayment = "INSERT INTO Payment_t (pay_date, price, order_id) VALUES ('".$today."', ";
          if (!empty($_POST['price']) && !empty($_POST['orderid'])) {
            $numform = '/\d+.\d+/';
            if (preg_match($numform, $_POST['price'])) {
              $presyo = $_POST['price'];
              $thepayment .= "$presyo, ";

              $ordercheck=$_POST['orderid'];
              $exists=@mysqli_query($sqlconn, "SELECT * FROM Order_t WHERE order_id = $ordercheck");
              if(mysqli_num_rows($exists)==0)
                echo( "No corresponding order was found. Cannot add payment to inexistent order.");
              else {
                $thepayment .= "  '".$ordercheck."') ";
                @mysqli_query($sqlconn,$thepayment); 
                @mysqli_close($sqlconn);
                header ("Location: payment.php");
              }
            }
          }
        }
        else {
          $result=@mysqli_query($sqlconn, "SELECT * FROM Payment_t WHERE payment_id=$id");
          
          if(@mysqli_num_rows($result) == 0)
            echo "No order record found.";
          else{
            echo '<table><tr><th /><th>Record Details</th></tr>';
            $row = @mysqli_fetch_array($result);
            echo "<tr><td>Payment ID</td><td>$id</td></tr>";
            echo "<tr><td>Pay Date</td><td>{$row['pay_date']}</td></tr>";
            echo "<tr><td>Price</td><td>{$row['price']}</td></tr>";
            $thisorder = $row['order_id'];
            echo "<tr onclick=\"redirect($thisorder)\" ><td>Order ID</td><td>{$thisorder}</td></tr>";
            echo "</table>";
            if ( isset( $_POST['delpay'] ) ) { 
              $deletepay = "DELETE FROM Payment_t WHERE payment_id=$id ";
              @mysqli_query($sqlconn,$deletepay);
              @mysqli_close($sqlconn);
              header ("Location: payment.php");
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
