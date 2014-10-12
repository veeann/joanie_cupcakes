<html>

<head>

<title>Joanie's Cupcakes</title>
<link rel="stylesheet" href="everywhere.css" />
<link rel="stylesheet" href="960.css" />
<link rel="stylesheet" href="reset.css" />

<style type="text/css">
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
        <font color="#EE637E">A one-stop cake shop to fulfill your sweet tooth!</font>
        </br>
        </br>
        <form method="post" action="orderprocess.php">
            <p><font color="#CCCCCC">First Name:</font>
                <input  type="text" name="orderfirst" placeholder="Mary Ann"/></p>
            <p><font color="#CCCCCC">Last Name: </font> 
                <input  type="text" name="orderlast" placeholder="Cruz"/></p>
            <p><font color="#CCCCCC">E-mail: </font> 
                <input  type="text" name="orderemail" placeholder="name@server.com"/></p>
            <p><font color="#CCCCCC">Contact Number: </font> 
                <input  type="text" name="ordernum" placeholder="0901-234-5678"/></p>
            <p><font color="#CCCCCC">Description: </font> </br>
                <textarea name="orderdesc" cols="50" rows="6" 
                placeholder="Describe your cake/cupcake order."></textarea>
            </br>
            <button id="Submit" style="background-color:#EE637E; color:#3C2312; border-radius:50px; height:50px;width:200px">Submit</button>
        </form>
        </br>
    </div>

    <div class="footer"><img src="images/Logo3.png" width="50" height="50" />Copyright 2014</div>
</div>

</body>
</html>
