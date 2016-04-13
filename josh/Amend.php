<!-- Name: 	Joshua Eisikovits -->
<!-- Date: 	15.02.2013 -->
<!-- ID :	C00156665 -->
<!-- Amend.php -->

<html>	<!-- start html -->	
<body>	<!-- start body -->
<title>Amend Customer</title>
<center>
<h2>Amend Customer</h2>

<!-- Import external files -->
<?php        include 'projectMenu.php' ; 
             include 'projectFunctions.html' ;
			 include 'cssStuff.css' ;
?>


<BR>
<div class="ridgeFOC"><BR>
<table>
<tr>

<!-----  button to unlock fields for amendment  ------>
<center><button class="blue" id="amndbtn" name="amndbtn" onclick="unlock()">Amend Details</button></center>

<tr>

<b>Select Customer &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
:&nbsp&nbsp&nbsp </b>
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

//select only customers who have delteflag 0, (customers in the database with deleteFlag 1, are "flagged" and shouldn't be displayed
$sql = " SELECT * FROM Customer WHERE deleteFlag = 0";

//create variables
$id='';$firstName='';$surname='';$address='';$telNum='';$occupation='';
$salary='';$gName='';

$query = mysql_query($sql);	//make query

$allText = "$id,$firstName,$surname,$address,$telNum,$occupation,$salary,$gName";

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
		
	//Print information to listbox
	echo "<option value='$allText'>$firstName $surname</option>";
}//end while loop

echo "</select>";

?>

</tr>

<!-- on submit run .php file, as well as call function formValidate from projectFunctions.html to confirm/validate --------->
<form name="AmendCustForm" action="Amend.php" method="post" >
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
</table>	<!-----  end table  ------>

<center><button class="green" id="submit" name="submit" onclick="verifyChange()">Submit Changes</button></center>

<?php
$id = $_POST['idAmend'];
$first = $_POST["firstNameAmend"];
$last = $_POST["amendSurname"];
$address = $_POST["amendAddress"];
$telNum = $_POST["amendTel"];
$occ = $_POST["amendOcc"];
$sal = $_POST["amendSal"];
$gName = $_POST["amendGua"];


$sql = "UPDATE Customer SET custFirstname ='$first', custSurname='$last', Address='$address', PhoneNo='$telNum', Occupation='$occ', Salary='$sal', guarantorsName='$gName'	
	WHERE CustomerID='$id' ";



if(!mysql_query($sql, $con))
{
	die("error".mysql_error());
}

mysql_close($con);

?>

</form> <!-----  end form  ------>
</body>	<!-----  end body  ------>
</html>	<!-----  end html  ------>