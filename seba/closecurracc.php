<!-- Name: 	Sebastian Horoszkiewicz -->
<!-- Date: 	22.02.2013 -->
<!-- ID	 :	C00156243 -->
<!-- Close Current Account -->
<html>
<body>
<title>Close Current Account</title><!-- page title -->
<CENTER>
<H2>Close Current Account</H2>		<!-- title on top of the page-->
<?php 	include 'menu.php'; 					//adds menu etc. from
		include 'functionsForCloseAcc.html'; 	//another file to
		include 'cssStuff.css';					//this page.
		include 'db.php';						//
?>
<BR>
<div class="ridgeForCloseAcc"><BR>	<!-- css frame/border for table (table will be in the border)-->
<table>								<!-- creates table  -->
<tr>								<!-- tr,td,/tr,/td creates row's, columns/close row/column -->
<tr><B><center>Choose Customer Account to Close : </B></center></tr><!-- indicates for user what to do -->
<TR><CENTER> &nbsp </CENTER></TR><!-- empty row/col -->
<TR>
<?php
	date_default_timezone_set('Europe/London');	//to avoid errors if date will be used
	$sql ="	SELECT * FROM 
		(Customer LEFT JOIN CurrentAccount
		ON Customer.CustomerID = CurrentAccount.CustomerNo)
		WHERE deleteFlag = 0 AND accNo != ''
		ORDER BY custFirstname"; // join both tables on customer id and shows records for customers not deleted and does not show customers that do not have a current account

	$query = mysql_query($sql);//create a query
	$id=''; $fname=''; $sname=''; $accNum=''; $addr=''; $cabal=''; $ovAm='';//initialize variables
	$allText="$id,$fname,$sname,$accNum,$addr,$cabal,$ovAm";// set $allText variable to values above (so when "select..." will be selected fields will be empty)
	echo "<select name='listbox' id='listbox' onclick='populateCloseAcc()'>";//set name and id of listbox and go into populate function which will store choosen values into js vars/id's
	echo "<option value='$allText'>Select Customer...</option>";//set default value in list box as "Select..."
	while ($row = mysql_fetch_array($query))// go through array from query
	{
		$id=$row['CustomerID'];			//put
		$fname=$row['custFirstname'];	//choosen values
		$sname=$row['custSurname'];		//into 
		$accNum=$row['accNo'];			//php
		$addr=$row['Address'];			//variables
		$cabal=$row['balance'];
		$ovAm=$row['overdrawn'];
		$allText="$id,$fname,$sname,$accNum,$addr,$cabal,$ovAm";// put above values into one variable(just for populate function)
		echo "<option value='$allText'>$fname $sname</option>"; //set text in listbox
	}
	echo "</select>";// close listbox
?>
</tr>
<form name="myForm" action="closecurracc.php" method="post"> <!-- Open form choose file and se method to post so i'll -->
</tr><tr>													 <!-- be able to get values from below field later in php part. -->
<td><div class="textalignR">ID : </div></td>				 <!-- This 'class' is used to align text to the right side of "box" in table -->
<td><input type="text" name="id" id="id" disabled='disabled'/></td> <!-- type-input field, name/id sets value in text field -->
</tr><tr>															<!-- with choosen informations from above listbox -->
<td><div class="textalignR">Firstname : </div></td>					<!-- if none it will stay empty -->
<td> <input type="text" name="fname" id="fname" disabled='disabled'/></td><!-- disabled part makes field non editable -->
</tr><tr>
<td><div class="textalignR">Lastname : </div></td>
<td> <input type="text" name="sname" id="sname" disabled='disabled'/></td>
</tr><tr>
<td><div class="textalignR">Address : </div></td>
<td> <input type="text" name="addr" id="addr" disabled='disabled'/> </td>
</tr><tr>
<td><div class="textalignR">Current Account No. : </div></td>
<td> <input type="text" name="AccNum" id="AccNum" disabled='disabled'/> </td>
</tr><tr>
<td><div class="textalignR">Current Acc. Balance : </div></td>
<td> <input type="text" name="Balance" id="Balance" disabled='disabled'/> </td>
</tr><tr>
<td><div class="textalignR">Overdrawn Amount on C.A  : </div></td>
<td> <input type="text" name="Overdrawn" id="Overdrawn" disabled='disabled'/> </td>
</tr>
</table>
<BR>
<center><button class="red" id="istrue" name="istrue" onclick="closecurra()">Close Current Account</button></center><!-- return some value if 'ok' pressed -->
</form><!-- close form -->
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><!-- hides notices from user -->
<?php
	$check='';	$sbalance=0;	//initialize variables
	$ide='';	$currentAN='';
	$ide= mysql_real_escape_string($_POST['id']);//get posted value
	$check= mysql_real_escape_string($_POST['istrue']);
	$currentAN= mysql_real_escape_string($_POST['AccNum']);
	$sbalance= mysql_real_escape_string($_POST['Balance']);	
	$sbalance=(double)$sbalance;//convert to double
	$overDrAm= mysql_real_escape_string($_POST['Overdrawn']);	
	$overDrAm=(double)$overDrAm;//convert to double
	if($check=='true')//if user clicked and confirmed close acc and 'ok' then go in there
	{
	 if($ide=='')//if id field is empty == no results choosen
	 {
		echo '<script type="text/javascript"> alert("Please Choose a Customer") </script>';//prompt with alert message
	 }
	 else if($currentAN=='')//if acc num field is empty == customer does not have an current account
	 {
		echo '<script type="text/javascript"> alert("Current Account Does Not Exist") </script>';//prompt with alert message
	 }
	 else//if all 'required' fields are filled from db go in there
	 {
	  if($sbalance==0&&$overDrAm==0)//user must have balance and overdrawn value == 0
	  {
		$sql="DELETE FROM 
			  CurrentAccount
			  WHERE  accNo = '$_POST[AccNum]'";//deletes choosen account 
		if(!mysql_query($sql,$con))
		{
			die('Error: ' . mysql_error());
		}
		else
		{
			if(mysql_affected_rows() !=0)//if any record was deleted prompt with message below
			{
				echo '<script type="text/javascript"> alert("Account : '."$currentAN".' has been Deleted.") </script>';//prompt to user account number that was deleted
			}
		}	
	  }
 	  else//if user have balance or overdrawn value greater than 0
	  {
	    echo '<script type="text/javascript"> alert("ERROR: Make sure that Balance\nOR\nOverdrawn Amount is equal to 0!\t") </script>'; 
	  }
	 }
	}
	mysql_close($con);//close connection
?>
</div><!-- close border -->
</CENTER>
</body>
</html>