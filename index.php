<html>

<head>

<title>Joanie's Cupcakes</title>
<link rel="stylesheet" href="everywhere.css" />
<link rel="stylesheet" href="960.css" />
<link rel="stylesheet" href="reset.css" />

<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="jquery.cycle.all.js"></script>
<script type"text/javascript">$('#slider').cycle({ 
    fx:     'fade', 
    speed: 'slow', 
   
    next:   '#next', 
    prev:   '#prev' 
});</script>

<style type="text/css">
button{
	font-size:10px;
	color: #000000;
	letter-spacing: 1px;
	background-color: #EE637E;
	height: 30px;
	width: 100%;
	margin-left:auto;
	margin-right:auto;
	border-radius:10px;
}
</style>

</head>


<body>

<div class="container">
	<?php
	session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
	?>
	<div class="clear"></div>

	<div class="header" align="center">
		<p>&nbsp;</p>
		<a href="index.php">
			<img src="images/logo.png" alt="Insert Logo Here" name="Insert_logo" width="300" height="208" class="header" id="Insert_logo" style="background-color: #3C2311; display:block;" />
    	</a>
    	<p>&nbsp;</p>
    	<font color="#EE657F">A one-stop cake shop to fulfill your sweet tooth!</font>
		<p>&nbsp;</p>
	</div>

	<div class="sidebar1">
    	<a href="login.php" ><button>Employees only</button></a>
    </div>

  	<div id="content">
  		<div id="wrapper">
    		<div id="container">
				<div id="slider">
					<img src="images/sample1.png" width="600" height="600" />
					<img src="images/sample2.png" width="600" height="600" />
					<img src="images/sample3.png" width="600" height="600" />
				</div>
 			</div>  
  		</div>

		<div align="center" id="buttoncont">
			<a href="customerordering.php">
				<button style="font-size:24;width:250px;height:100px">ORDER NOW
			</button></a>
		</div>
	</div>

  	<div class="footer"><img src="images/Logo3.png" width="50" height="50" />Copyright 2014</div>
</div>


</body>
</html>
