<html>

<head>
<title>Joanie's Cupcakes</title>
<link rel="stylesheet" href="everywhere.css" />
<link rel="stylesheet" href="960.css" />
<link rel="stylesheet" href="reset.css" />
<link rel="stylesheet" href="table.css" />

<script type="text/javascript">
function redirect(id){
  window.location.assign("expensesform.php?"+id);
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
      <div class="grid_3">
        <h2>Search By</h2>
        <form method="post">
        <select name="searchby">
          <option value="exid">Expense ID</option>
          <option value="exda">Expense Date</option>
        </select>
        <input type="text" name="search"><br>
        </form>
        </br>
      </div>

      <div class="grid_3" align="right">
        <a href="expensesform.php?addexpense"><button>Add Expense Record</button></a>
      </div>
      <div class="grid_3" align="right">
        <a href="expenses.php"><button>All Expenses</button></a>
      </div>
      <div class="grid_3" align="right">
        <a href="employeemenu.php"><button>Back to Menu</button></a>
      </div>

      <div class="grid_12">
        <?php
        $sqlconn=@mysqli_connect("localhost", "root", "", "joanie")  or die("There was a problem reaching the database.");
        $sqlquery="SELECT * FROM Expense_t ";
        
        //Check search query, default is show all:
        $searchterm="%";
        $searchby="firstname";
        
        if(isset($_POST['searchby']))
          $searchby=$_POST['searchby'];
        if(isset($_POST['search']))
          $searchterm=$_POST['search'];
        
        if($searchby=="exid")
          $sqlquery.="WHERE expense_id = $searchterm ";
        else if($searchby=="exda")
          $sqlquery.="WHERE expense_date = \"$searchterm\" ";
        
        $sqlquery.="ORDER BY expense_date DESC ";
        $result=@mysqli_query($sqlconn, $sqlquery);
        
        if($result == false)
          echo "No results found.";
        else {
          $temp="<table><tr><th>Expense ID</th><th>Date</th><th>Price</th><th>Details</th></tr>";
          while($row = @mysqli_fetch_array($result)){
            $expenseid=$row['expense_id'];
            $temp.=("<tr onclick=\"redirect($expenseid)\" ><td>" . $row['expense_id'] . " </td><td> " . $row['expense_date'] . " </td><td> " . $row['price'] . " </td><td> " . $row['details'] . "</td></tr>");
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
