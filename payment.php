<html>

<head>
<title>Joanie's Cupcakes</title>
<link rel="stylesheet" href="everywhere.css" />
<link rel="stylesheet" href="960.css" />
<link rel="stylesheet" href="reset.css" />
<link rel="stylesheet" href="table.css" />

<script type="text/javascript">
function redirect(id){
  window.location.assign("paymentsform.php?"+id);
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
          <option value="payid">Payment ID</option>
          <option value="payda">Payment Date</option>
          <option value="price">Price</option>
          <option value="ordid">Order ID</option>
        </select>
        <input type="text" name="search"><br>
        </form>
        </br>
      </div>

      <div class="grid_3" align="right">
        <a href="paymentsform.php?addpay"><button>Add Payment Record</button></a>
      </div>
      <div class="grid_3" align="right">
        <a href="payment.php"><button>All Payments</button></a>
      </div>
      <div class="grid_3" align="right">
        <a href="employeemenu.php"><button>Back to Menu</button></a>
      </div>

      <div class="grid_12">
        <?php
        $sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
        $sqlquery="SELECT * FROM Payment_t ";
        
        //Check search query, default is show all:
        $searchterm="%";
        $searchby="firstname";
        
        if(isset($_POST['searchby']))
          $searchby=$_POST['searchby'];
        if(isset($_POST['search']))
          $searchterm=$_POST['search'];
        
        if($searchby=="payid")
          $sqlquery.="WHERE payment_id = $searchterm ";
        else if($searchby=="payda")
          $sqlquery.="WHERE pay_date = \"$searchterm\" ";
        else if($searchby=="price")
          $sqlquery.="WHERE price = $searchterm ";
        else if($searchby=="ordid")
          $sqlquery.="WHERE order_id = $searchterm ";
        
        $sqlquery.="ORDER BY pay_date DESC ";
        $result=@mysqli_query($sqlconn, $sqlquery);
        
        if($result == false)
          echo "No results found.";
        else {
          $temp="<table><tr><th>Payment ID</th><th>Pay Date</th><th>Price</th><th>Order ID</th></tr>";
          while($row = @mysqli_fetch_array($result)){
            $orderid=$row['payment_id'];
            $temp.=("<tr onclick=\"redirect($orderid)\" ><td>" . $row['payment_id'] . " </td><td> " . $row['pay_date'] . " </td><td> " . $row['price'] . " </td><td> " . $row['order_id'] . "</td></tr>");
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
