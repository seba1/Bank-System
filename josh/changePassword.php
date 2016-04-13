<!-- Name: 	Josh Eisikovits -->
<!-- Date: 	23.01.2013 -->
<!-- ID	 :	C00156665 -->
<!-- changePasswod.php -->

<html>							<!-- start html -->	
<body>							<!-- start body -->
<title>Change Password</title>	<!-- page title -->
<center>
<h2>Change Password</h2>		<!-- Header -->

<!-- Import external files -->
<?php       
			ob_start(); ////turns on buffer, without it 'header' will return an error
			include 'projectFunctions.html' ;
			include 'cssStuff.css' ;
?>

<!-- Button to Exit -->
<center><button class="green" onclick="parent.location=':8443' ">Home Page</button></center>

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

mysql_select_db("everyt32_bankDB", $con);
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$username=$_COOKIE["userName"];
echo "$username";

	$sql = "SELECT * FROM LogIn 
	WHERE userName = $username";
	

	
	
?>


</tr>

<!-- on submit run .php file --------->
<form method="post" action="changePassword.php" >
</tr><tr>


<td><div class="textalignR">Password : </div></td>
<td><input type="password" name="password" /></td>
</tr><tr>

<td><div class="textalignR">New Password : </div></td>
<td><input type="password" name="password" id="pass" disabled ="disabled"/></td>
</tr><tr>

<td><div class="textalignR">Confrim Password : </div></td>
<td><input type="password" name="password" id="conPas" disabled ="disabled"/></td>
</tr>

</table> 
<center><button class="green" id="submit" name="submit"  >Log In</button></center>

</form> <!-----  end form  ------>

</body>	<!-----  end body  ------>
</html>	<!-----  end html  ------>
