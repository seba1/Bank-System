<!-- Name: 	Josh Eisikovits -->
<!-- Date: 	23.01.2013 -->
<!-- ID	 :	C00156665 -->
<!-- login.php -->

<html>					<!-- start html -->	
<body>					<!-- start body -->
<title>Log In</title>	<!-- page title -->
<center>
<h2>Log In</h2>			<!-- Header -->

<!-- Import external files -->
<?php       
			ob_start(); ////turns on buffer, without it 'header' will return an error
			include 'projectFunctions.html' ;
			include 'cssStuff.css' ;
?>

<!-- Button to Exit -->
<center><button class="green" onclick="parent.location=':8443' ">Home</button></center>

<BR>
<div class="ridgeFOC"><BR>
<table>	<!-- Start Table -->
<tr>	<!-- Start Table rows -->


<?php
//~~~~~~~~~~~~~~~~~~~~~Connect to Database ~~~~~~~~~~
$con = mysql_connect("localhost","everyt32_user2","password");

if(!$con)
{
	die('Could not connect: ' . mysql_error() );
}//end if 

mysql_select_db("bankDB", $con);
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
if(isset($_POST['username']))		//boolean to check if username has been entered
{									//if true then checks corresponding information against database

	$username = $_POST['username'];	//assign data from javascript field to variable
	$password = $_POST['password'];	//assign data from javascript field to variable
    
	//query to check if data from fields(which are assinged to variables) match username and password in database
	$sql = "SELECT * FROM LogIn WHERE userName ='".$username."' AND password ='".$password."' LIMIT 1";
	
	$result = mysql_query($sql);	//assign sql query to result
	
	if (mysql_num_rows($result) == 1)		
	{								//if statment to check the rows in database for result where limit is equal to 1
		//on successfull login move to change password screen
		
		setcookie("userName", $username);
		header("Location: /josh/pg.php");
	}//end if
	else 
	{
		echo '<script type="text/javascript"> alert("Invalid Password")</script>';
	}//end else
	
}//end if

?>

</tr>

<!-- on submit run .php file --------->
<form method="post" action="login.php" >
</tr><tr>

<td><div class="textalignR">Username : </div></td>
<td><input type="text" name="username"	/></td>
</tr><tr>

<td><div class="textalignR">Password : </div></td>
<td><input type="password" name="password" /></td>
</tr>

</table> 
<center><button class="green" id="submit" name="submit"  >Log In</button></center>

</form> <!-----  end form  ------>

</body>	<!-----  end body  ------>
</html>	<!-----  end html  ------>