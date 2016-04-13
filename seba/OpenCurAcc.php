<!-- Name: 	Sebastian Horoszkiewicz -->
<!-- Date: 	07.02.2013 -->
<!-- ID	 :	C00156243 -->
<!-- Open Current Account -->
<html>
<body>
<title>Open Current Account</title><!-- page title -->
<CENTER>
<H2>Open Current Account</H2>	<!-- title on top of the page-->
<?php 	include 'menu.php'; 				//adds menu etc. from
		include 'functionsForOpenAcc.html'; //another file to 
		include 'cssStuff.css';				//this page. 
		include 'db.php';					//
?>
<BR>
<div class="ridgeFOC"><BR>		<!-- css "frame" for table -->
<table>							<!-- creates table  -->
<tr>							<!-- tr,td,/tr,/td creates row's, columns/close row/column -->
<tr><CENTER><button class="blue" onclick="parent.location='/josh/AddCustomer.php'">Add New Customer</button></CENTER></tr><!-- button to Add Customer -->
<TR><CENTER><B>OR</B></CENTER></TR>
<tr>
<?php
	date_default_timezone_set('Europe/London');	//to avoid errors if date will be used
	$sql ="	SELECT * FROM 
		Customer WHERE deleteFlag = 0
		ORDER BY custFirstname"; //get information from customer table where value in del flag == 0 (0-customer not deleted)

	$query = mysql_query($sql);//create a query
	$id=''; $fname=''; $sname=''; $addr='';//initialize variables
	$allText="$id,$fname,$sname,$addr";// set $allText variable to values above (so when "select..." will be selected fields will be empty)
	echo "<select name='listbox' id='listbox' onclick='populateCA()'>";//set name and id of listbox and go into populate function which will store choosen values into js vars/id's
	echo "<option value='$allText'>Select Existing Cust...</option>";//set default value in box as "Select Existing Cust..."
	while ($row = mysql_fetch_array($query))// go through array from query
	{
		$id=$row['CustomerID'];			//put
		$fname=$row['custFirstname'];	//choosen values
		$sname=$row['custSurname'];		//into 
		$addr=$row['Address'];			//php variables
		$allText="$id,$fname,$sname,$addr";// put above values into one variable(just for populate function)
		echo "<option value='$allText'>$fname $sname</option>"; //set text in listbox
	}
	echo "</select>";// close listbox
?>
</tr>
<form name="myForm" action="OpenCurAcc.php" method="post"><!-- Open form choose file and se method to post so i'll -->
</tr><tr>												  <!-- be able to get values from below field later in php part. -->
<td><div class="textalignR">ID : </div></td>			  <!-- This 'class' is used to align text to the right side of "box" in table -->
<td><input type="text" name="id" id="id" disabled='disabled'/></td>	<!-- type-input field, name/id sets value in text field -->
</tr><tr>															<!-- with choosen informations from above listbox -->
<td><div class="textalignR">Firstname : </div></td>					<!-- if none it will stay empty -->
<td> <input type="text" name="fname" id="fname" disabled='disabled'/></td><!-- disabled part makes field non editable -->
</tr><tr>																  <!-- and sets colour of this field to gray -->
<td><div class="textalignR">Lastname : </div></td>						  <!-- above comment applies to next few lines. -->
<td> <input type="text" name="sname" id="sname" disabled='disabled'/></td>
</tr><tr>
<td><div class="textalignR">Address : </div></td>
<td> <input type="text" name="addr" id="addr" disabled='disabled'/></td>
</tr><tr>
<td><div class="textalignR">Balance : </div></td>
<td><input type="text" name="Balancefna" id="Balancefna" autofocus /></td>
</tr><tr>
<td><div class="textalignR">Set Overdraft Limit : </div></td>
<td> <input type="text" name="ovdrLmt" id="ovdrLmt"/> </td>
</tr>
</table><!-- close table -->
<BR>
<center><button class="green" id="istrue" name="istrue" onclick="opencurra()">Open Current Account</button></center><!-- return some value if 'ok' pressed -->
</form>
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><!-- hide notice msg's-->
<?php
	$check='';//initialize variables
	$sbalance=0;
	$overdrLim=0;
	$getId='';
	$getId= mysql_real_escape_string($_POST['id']);//Store value from variable in POST into php variable.
	$check= mysql_real_escape_string($_POST['istrue']);	
	$sbalance= mysql_real_escape_string($_POST['Balancefna']);
	$sbalance=(double)$sbalance;//Convert sbalance value into double
	$overdrLim= mysql_real_escape_string($_POST['ovdrLmt']);
	$overdrLim=(double)$overdrLim;//Convert overdrLim value into double
	if($check=='true')//if var check contains 'true' it means that the button to open ca was clicked and user confirmed his decision by clicking 'ok'
	{
	  if($getId=='')//if id field is empty == no customer choosen
	  {
		echo '<script type="text/javascript"> alert("Choose a Person")</script>';//prompt with error
	  }
	  else//otherwise add account
	  {
		$sql = mysql_query("SELECT * FROM 
		(Customer LEFT JOIN CurrentAccount
		ON Customer.CustomerID = CurrentAccount.CustomerNo)
		LEFT JOIN DepositAcc
		ON Customer.CustomerID = DepositAcc.cusid 
		ORDER BY CurrentAccount.accNo ASC");//Join three tables on customer id and order them by current account number (in ascending order)

		while($row = mysql_fetch_array($sql))//go through array from query
		{
			$lastAccNo=$row['accNo'];//stores last value into variable
		}
		$lastAccNo=(int)$lastAccNo+1;//convert to int and add 1
		$overdrawn=0;//set overdrawn to 0
		$sql="INSERT INTO CurrentAccount (CustomerNo, accNo, balance, overdrawn, ovdftLm)
		VALUES
		('$_POST[id]', $lastAccNo, $sbalance, $overdrawn, $overdrLim)";//adds new account information
	
		if(!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error());
		}
		echo '<script type="text/javascript"> alert("Account : '."$lastAccNo".' has been added \n\nBalance : '."$sbalance".'\n\nOverdraft Limit : '."$overdrLim".' ")</script>';//tell user that account was added
	  }
	}
	mysql_close($con);//close connection
?>
</div><!-- close ridge border -->
</center>
</body>
</html>