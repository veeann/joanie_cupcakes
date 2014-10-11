<html>

<head>
<title>Joanie's Cupcakes</title>
<link rel="stylesheet" href="everywhere.css" />
<link rel="stylesheet" href="960.css" />
<link rel="stylesheet" href="reset.css" />
<link rel="stylesheet" href="table.css" />

<script type="text/javascript">
function redirect(id){
  window.location.assign("ordersform.php?"+id);
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
          <option value="orderid">Order ID</option>
          <option value="orderda">Order Date</option>
          <option value="custln">Customer Last Name</option>
          <option value="custfn">Customer First Name</option>
          <option value="custem">Customer Email</option>
          <option value="custcn">Customer Contact Number</option>
          <option value="orderst">Order Status</option>
        </select>
        <input type="text" name="search"><br>
        </form>
        </br>
      </div>

      <div class="grid_3" align="right">
        <a href="ordersform.php?addorder"><button>Add Order Record</button></a>
      </div>
      <div class="grid_3" align="right">
        <a href="orders.php"><button>All Orders</button></a>
      </div>
      <div class="grid_3" align="right">
        <a href="employeemenu.php"><button>Back to Menu</button></a>
      </div>

      <div class="grid_12">
        <?php
        $sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
        $sqlquery="SELECT * FROM Order_t ";
        
        //Check search query, default is show all:
        $searchterm="%";
        $searchby="firstname";
        
        if(isset($_POST['searchby']))
          $searchby=$_POST['searchby'];
        if(isset($_POST['search']))
          $searchterm=$_POST['search'];
        
        if($searchby=="orderid")
          $sqlquery.="WHERE order_id = $searchterm ";
        else if($searchby=="orderda")
          $sqlquery.="WHERE upper(order_date) LIKE upper(\"%$searchterm%\") ";
        else if($searchby=="custln")
          $sqlquery.="WHERE upper(customer_last_name) LIKE upper(\"%$searchterm%\") ";
        else if($searchby=="custfn")
          $sqlquery.="WHERE upper(customer_first_name) LIKE upper(\"%$searchterm%\") ";
        else if($searchby=="custem")
          $sqlquery.="WHERE upper(customer_email) LIKE upper(\"%$searchterm%\") ";
        else if($searchby=="custcn")
          $sqlquery.="WHERE upper(customer_contact_number) LIKE upper(\"%$searchterm%\") ";
        else if($searchby=="orderst")
          $sqlquery.="WHERE upper(status) LIKE upper(\"%$searchterm%\") ";
        
        $result=@mysqli_query($sqlconn, $sqlquery);
        
        if($result == false)
          echo "No results found.";
        else {
          $temp="<table><tr><th>Order ID</th><th>Date</th><th>Last Name</th><th>First Name</th><th>Email</th><th>Contact Number</th><th>Details</th><th>Price</th><th>Status</th></tr>";
          while($row = @mysqli_fetch_array($result)){
            $orderid=$row['order_id'];
            $temp.=("<tr onclick=\"redirect($orderid)\" ><td>" . $row['order_id'] . " </td><td> " . $row['order_date'] . " </td><td> " . $row['customer_last_name'] . " </td><td> " . $row['customer_first_name'] . "</td><td>" . $row['customer_email'] . "</td><td>" . $row['customer_contact_number'] . "</td><td>" . $row['details'] . " </td><td>" . $row['price'] . " </td><td>" . $row['status'] . " </td></tr>");
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
