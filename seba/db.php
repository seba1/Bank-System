<!-- Name: 	Sebastian Horoszkiewicz -->
<!-- Date: 	28.01.2013 -->
<!-- ID	 :	C00156243 -->
<!-- db.php -->
<?php 
	$con = mysql_connect("localhost","everyt32_user2","password");	//Connect
	if(!$con)													//to this
	{															//database
		die('Could not connect: ' . mysql_error());				//if - if not 
	}															//connected show error.
	mysql_select_db("everyt32_bankDB", $con);							//select database
?>