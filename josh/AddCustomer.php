<!-- Name: 	Joshua Eisikovits -->
<!-- Date: 	15.02.2013 -->
<!-- ID :	C00156665 -->
<!-- AddCustomer.php -->

<html>	<!-- start html -->	
<body>	<!-- start body -->
<title>Add New Customer</title>
<CENTER>
<h2>Add New Customer</h2>

<!-- Import external files -->
<?php        include 'projectMenu.php' ; 
             include 'projectFunctions.html' ;
			 include 'cssStuff.css' ;
?>

<BR>
<div class="ridgeFOC"><BR>
<table>
<tr>
<tr><CENTER><button class="blue" onclick="parent.location='/josh/pg.php' ">Exit/Cancel</button></CENTER></tr>
<TR><CENTER><B>OR</B></CENTER></TR>
<tr>

<?php
//--------------------Connect To Bank Database ---------
	$con = mysql_connect("localhost","everyt32_user2","password");
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("everyt32_bankDB", $con);
//-----------------------------------------------------------
?>

</tr>

<!-- on submit run .php file, as well as call function formAdd from projectFunctions.html to confirm/validate --------->
<form action="AddCustomer.php" method="post" onsubmit = "return formAdd()">	
</tr><tr>


<td><div class="textalignR">First Name: </div></td>
<td><input type="text" name="firstname" id="firstname" required autofocus /></td>
</tr><tr>

<td><div class="textalignR">Surname: </div></td>
<td><input type="text" name="surname" required /></td>
</tr><tr>

<td><div class="textalignR">Address: </div></td> 
<td><input type="text" name="address" required /></td>
</tr><tr>

<td><div class="textalignR">Tel Number: </div></td> 
<td><input type ="tel" name="telNumber" required /></td>
</tr><tr>

<td><div class="textalignR">Occupation: </div></td> 
<td><input type ="text" name="occupation" required /></td>
</tr><tr>

<td><div class="textalignR">Salary: </div></td>
<td><input type="text" name ="salary" required/></td>
</tr><tr>


<td><div class="textalignR">Gaurantors Name:</div></td> 
<td><input type="text" name="guarantorsName"	/></td>



</tr>

</table>	<!-----  end table  ------>

<center><button class="green" id="submit" name="submit">Add Customer</button></center>	<!--- Button To Add Customer ---->
</form>	<!--- End form ---->

<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR> <!------ used to hide notice message ----->

<?php
	$firstname=''; $surname=''; $address=''; $telNumber=''; $occupation=''; $salary=''; $guarantorsName=''; 

	//query to generate random customer number
	$sql = mysql_query("SELECT * FROM 
		Customer
		ORDER BY CustomerID ASC");	//Select all from customer and sort by CustomerId in ascending order
	
	while($row = mysql_fetch_array($sql))	//search array using the query
	{
		$customerNumber=$row['CustomerID'];	//store value into variable
	}//end while loop
	
	$customerNumber=(int)$customerNumber + 1; //parse customerNumber and increment

	$sql="INSERT INTO Customer (custFirstname, custSurname, CustomerID, Address, PhoneNo, Occupation, Salary, guarantorsName)
	
	VALUES
	( '$_POST[firstname] ', '$_POST[surname] ', $customerNumber ,'$_POST[address] ', '$_POST[telNumber] ', '$_POST[occupation]' , '$_POST[salary]', '$_POST[guarantorsName] ') " ;
	
	if(!mysql_query($sql,$con))
	{
		die('Error: ' . mysql_error());
	}//end if
	
	
	//inform that customer number has been added and display
	echo '<script type="text/javascript"> alert("Customer Number : '. "$customerNumber".' has been generated")</script>';
	
	mysql_close($con);
?>
</body>	<!--- End HTML ---->
</html>	<!--- End HTML ---->