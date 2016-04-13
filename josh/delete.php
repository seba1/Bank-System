<!-- Name: 	Josh Eisikovits -->
<!-- Date: 	23.01.2013 -->
<!-- ID	 :	C00156665 -->
<!-- delete.php -->

<?php
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$con = mysql_connect("localhost","everyt32_user2","password");

if(!$con)
{
	die('Could not connect: ' . mysql_error() );
}//end if 

mysql_select_db("everyt32_bankDB", $con);
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$id = $_POST["idAmend"];

$sql = "UPDATE Customer SET deleteFlag=1
    WHERE CustomerID='$id'";

$result = mysql_query($sql, $con);

mysql_close($con);

?>

<!-- Name: 	Josh Eisikovits -->
<!-- Date: 	23.01.2013 -->
<!-- ID	 :	C00156665 -->
<!-- Display In Table Format -->
<html>
<body>


<?php        include 'projectMenu.php' ;    
?>


<?php
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$con = mysql_connect("localhost","everyt32_user2","password");
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("everyt32_bankDB", $con);
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	$result = mysql_query("SELECT * FROM Customer WHERE deleteFlag=0");
	
	echo "<table border='1'>
	<tr>
	<th>CustomerID</th>
	<th>custFirstname</th>
	<th>custSurname</th>
	<th>Address</th>
	<th>PhoneNo</th>
	</tr>";
		
	while($row = mysql_fetch_array($result))
	{
		
		echo "<tr>";
		echo "<td>" . $row['CustomerID']."</td>";
		echo "<td>" . $row['custFirstname']. "</td>";
		echo "<td>" . $row['custSurname']. "</td>";
		echo "<td>" . $row['Address']. "</td>";
		echo "<td>" . $row['PhoneNo']. "</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	mysql_close($con);
?>

</body>
</html>