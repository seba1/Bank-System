<!-- Name: 	Sebastian Horoszkiewicz -->
<!-- Date: 	19.02.2013 -->
<!-- ID	 :	C00156243 -->
<!-- chargeinterest.php -->
<html>
<body>
<title>Charge Interest on Current Account</title><!-- page title -->
<center>
<h2>Charge Interest</h2>			<!-- title on top of the page-->
<?php 	include 'managmentMenu.php'; 				//adds menu etc. from
		include 'functionsForCIoOCA.html'; 	//another file to
		include 'cssStuff.css';				//this page.
		include 'db.php';					//
?>
<BR>
<div class="ridgeForCIoOCA"><BR>	<!-- css "frame" for table -->
<table>								<!-- creates table  -->
<tr>								<!-- tr,td,/tr,/td creates row's, columns/close row/column -->
<tr><B><center>Select Customer : </B></center></tr><!-- indicates for user what to do -->
<tR>
<?php
	date_default_timezone_set('Europe/London');		//to avoid errors if date will be used
	$sql ="	SELECT * FROM 
		(Customer LEFT JOIN CurrentAccount
		ON Customer.CustomerID = CurrentAccount.CustomerNo)
		WHERE overdrawn > 0 AND deleteFlag = 0
		ORDER BY accNo ASC"; //join information from table customer with CurrentAccount table on customers id's and pick accounts with balance less than 0 also order those in ascending order (for listbox)
	$query = mysql_query($sql);//make a query
	$accNum=''; $bal=''; $overdrawn=''; $ovL=''; $cAccIR='';//initialize variables
	$allText="$accNum,$overdrawn,$ovL,$cAccIR";//set $allText variable to values above (so when "select..." will be selected fields will be empty)
	echo "<select name='listbox' id='listbox' onclick='populateCIoOCA()'>";//set name and id of listbox and go into populate function which will store choosen values into js vars/id's
	echo "<option value='$allText'>Select...</option>";//set default value in list box as "Select..."
	while ($row = mysql_fetch_array($query))// go through array from query
	{
		$accNum=$row['accNo'];			//put choosen values
		$overdrawn=$row['overdrawn'];	//into 
		$ovL=$row['ovdftLm'];			//php variables
		if($cAccIR=='')//if this variable is empty go into this if and get some value for it
		{
			$sqlc ="SELECT CurrentAccOverdrawnInterest FROM Interest";//get interest rate for current acount
			$queryc = mysql_query($sqlc);//make a query
			while($row3 = mysql_fetch_array($queryc))		//There should be only
			{												//one interest rate so there is no need
				$cAccIR=$row3['CurrentAccOverdrawnInterest'];//to do anything else than store this value into variable
			} 
		}
		$allText="$accNum,$overdrawn,$ovL,$cAccIR";//put above values into one variable(just for populate function)
		echo "<option value='$allText'>$accNum</option>"; //set text in listbox
	}
	echo "</select>";//close select

?>

</script>
</tr>
<form name="myForm" action="chargeinterest.php" method="post">   <!-- Open form choose file and se method to post so i'll -->
</tr><tr>														 <!-- be able to get values from below field later in php part. -->
<td><div class="textalignR">Current Account Number  : </div></td><!-- This 'class' is used to align text to the right side of "box" in table -->
<td> <input type="text" name="accNum" id="accNum" disabled='disabled'/> </td><!-- type-input field, name/id sets value in text field -->
</tr><tr>															<!-- with choosen informations from above listbox -->
<td><div class="textalignR">Overdrawn Amount	 : </div></td>
<td> <input type="text" name="amOverdrawn" id="amOverdrawn" disabled='disabled'/></td>
</tr><tr>
<td><div class="textalignR">Overdraft Limit	 : </div></td>
<td> <input type="text" name="overdraftLim" id="overdraftLim" disabled='disabled'/></td>
</tr><tr>
<td><div class="textalignR">Interest Rate : </div></td>
<td><input type="text" name="cAccInterestR" id="cAccInterestR" disabled='disabled'/>%</td>
<tr></tr><tr></tr></tr>	
</table><!-- close form -->
<button class="red" id="iit" name="iit" onclick="chargeInt()">Charge Interest on All Accounts</button></td><!-- when clicked user will be prompted (to preceed or not(ok/cancel)) -->
</form><!-- close form -->
</div>
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><!-- hide unwanted Notice messages -->
<?php
	$currentDate = date("d-m-Y");//get todays date
	$check= mysql_real_escape_string($_POST['iit']);//Store value from variable iit POST into php variable.
	$ovAmount= mysql_real_escape_string($_POST['amOverdrawn']);
	$ovAmount=(double)$ovAmount;//convert to double
	$count=0;//initialize to 0
	if($check=="true")//if check contains 'true' == button to charge interest & confirmation for pressing this button was positive
	{
		$sql ="	SELECT * FROM CurrentAccount
				WHERE overdrawn > 0 ";//pick accounts with balance less than 0
		$query = mysql_query($sql);//make a query
		while($row = mysql_fetch_array($query))// go through array from query
		{
			$accNum=$row['accNo'];			//Put accNum from db into variable
			$overdrawn=$row['overdrawn'];	//Put overdrawn from db into variable
			$res=$overdrawn*$cAccIR/100;	//Calculate overdrawn
			$newOv=$res+$overdrawn;			//Add above result to old overdrawn amount.
			$sql ="UPDATE CurrentAccount SET overdrawn = $newOv WHERE accNo = $accNum ";//Update current account on overdrawn field where account number is = to account that was this calculation done for(including deleted customer acc)
			if(!mysql_query($sql,$con))
			{
				die('Error: ' . mysql_error());
			}
			$count++;//count no of records updated
		}
		echo '<script type="text/javascript"> alert("Number of Records Updated : '. "$count" .'") </script>';//output how many records were updated 
	}
	mysql_close($con);//close connection
?>
</center>
</body>
</html>