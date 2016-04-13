<!-- Name: 	Joshua Eisikovits -->
<!-- Date: 	15.02.2013 -->
<!-- ID :	C00156665 -->
<!-- deleteCustomer.php -->

<html>	<!-- start html -->	
<body>	<!-- start body -->
<title>Delete Customer</title>
<CENTER>
<h2>Delete Customer</h2>

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
<b>Select Customer &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
:&nbsp&nbsp&nbsp </b>
<?php
//--------------------Connect To Bank Database ---------
	$con = mysql_connect("localhost","everyt32_user2","password");
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("everyt32_bankDB", $con);
//-----------------------------------------------------------

//select only customers who have delteflag 0, (customers in the database with deleteFlag 1, are "flagged" and shouldn't be displayed
$sql = " SELECT * FROM Customer WHERE deleteFlag = 0";

//create variables
$id='';$firstName='';$surname='';$address='';$telNum='';$occupation='';
$salary='';$gName='';

$query = mysql_query($sql);	//make query

//assign all above values to $allText
$allText ="$id,$firstName,$surname,$address,$telNum,$occupation,$salary,$gName";

//call function emulate
echo "<select name='listbox' id='listbox' onclick='emulate()'>";

echo "<option value='$allText'>Select...</option>";


//while loop to fetch data from customer table
while ($row = mysql_fetch_array($query))
{
	$id=$row['CustomerID'];
	$firstName=$row['custFirstname'];
	$surname=$row['custSurname'];
	$address=$row['Address'];
	$telNum=$row['PhoneNo'];
	$occupation=$row['Occupation'];
	$salary=$row['Salary'];
	$gName=$row['guarantorsName'];
	
	//prints variables into fields
	$allText="$id,$firstName,$surname,$address,$telNum,$occupation,$salary,$gName";
		
	echo "<option value='$allText'>$firstName $surname</option>";
      
}
echo "</select>";	//close select listbox

mysql_close($con); 
?>

</tr>
<!-- on submit run .php file, as well as call function formValidate from projectFunctions.html to confirm/validate --------->
<form name="deleteCustomerForm" action="delete.php" method="post" onsubmit="return formValidate()">
</tr><tr>

<td><div class="textalignR">ID : </div></td>			  <!-- This 'class' is used to align text to the right side of "box" in table -->
<td><input type="text" name="idAmend" id="idAmend" disabled ='disabled'   /></td>
</tr><tr>

<td><div class="textalignR">Firstname : </div></td>
<td><input type="text" name="firstNameAmend" id="firstNameAmend" disabled='disabled' /></td>
</tr><tr>

<td><div class="textalignR">Surname : </div></td>
<td><input type="text" name="amendSurname"  id="amendSurname" disabled='diasbled' /></td>
</tr><tr>

<td><div class="textalignR">Address : </div></td>
<td><input type="text" name="amendAddress"  id="amendAddress" disabled='diasbled' /></td>
</tr><tr>

<td><div class="textalignR">Telephone Number : </div></td>
<td><input type="tel" name="amendTel"  id="amendTel" disabled='diasbled' /></td>
</tr><tr>

<td><div class="textalignR">Occupation : </div></td>
<td><input type="text" name="amendOcc"  id="amendOcc" disabled='diasbled' /></td>
</tr><tr>

<td><div class="textalignR">Salary : </div></td>
<td><input type="text" name="amendSal"  id="amendSal" disabled='diasbled' /></td>
</tr><tr>

<td><div class="textalignR">Guarantor's Name : </div></td>
<td><input type="text" name="amendGua"  id="amendGua" disabled='diasbled' /></td>
</tr>
</table>

<center><button class="green" id="delbtn" name="delbtn" >Delete Customer</button></center>

<!----- <input type="submit" value="Delete Customer" id="delbtn" name="delbtn"  />	<!--- Button To Delete Customer ---->

</form> <!-----  end form  ------>
	

</body>	<!-----  end body  ------>
</html>	<!-----  end html  ------>