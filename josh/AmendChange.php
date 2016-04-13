<?php
//--------------------Connect To Bank Database ---------
	$con = mysql_connect("localhost","everyt32_user2","password");
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("everyt32_bankDB", $con);
//-----------------------------------------------------------


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

$result = mysql_query($sql, $con);


if(!mysql_query($sql, $con))
{
	die('Error: ' . mysql_error());
}

echo "$first has been amended";

mysql_close($con);

?>
