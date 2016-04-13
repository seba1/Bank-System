<!-- Name: 	Sebastian Horoszkiewicz -->
<!-- Date: 	19.02.2013 -->
<!-- ID	 :	C00156243 -->
<!-- Update Current Account -->
<html>
<body>
<title>Update Current Account</title><!-- page title -->
<CENTER>
<H2>Update Current Account</H2>			<!-- title on top of the page-->
<?php 	include 'menu.php'; 						//adds menu etc. from
		include 'functionsForUpdateCurrAcc.html'; 	//another file to
		include 'cssStuff.css';						//this page.
		include 'db.php';							//
?>
<BR>
<div class="ridgeForUpdateCA"><BR>		<!-- css "frame" for table -->
<table>									<!-- creates table  -->
<tr>									<!-- tr,td,/tr,/td creates row's, columns/close row/column -->
<tr><B><center>Select Customer Account to Update : </B></center></tr><!-- indicates for user what to do -->
<TR><CENTER> &nbsp </CENTER></TR>  <!-- empty row/col -->
<tR>
<?php
	date_default_timezone_set('Europe/London');		//to avoid errors if date will be used
	$sql ="	SELECT * FROM 
		(Customer LEFT JOIN CurrentAccount
		ON Customer.CustomerID = CurrentAccount.CustomerNo)
		WHERE deleteFlag = 0 AND accNo != ''
		ORDER BY custFirstname"; // join both tables on customer id and shows records for customers not deleted and does not show customers that do not have a current account
	$query = mysql_query($sql);//make a query
	$id=''; $fname=''; $sname=''; $accNum=''; $addr=''; $cabal=''; $ovAm=''; $ovL='';//initialize variables
	$allText="$id,$fname,$sname,$accNum,$addr,$cabal,$ovAm,$ovL";// set $allText variable to values above (so when "select..." will be selected fields will be empty)
	echo "<select name='listbox' id='listbox' onclick='populateUpdateCA()'>";//set name and id of listbox and go into populate function which will store choosen values into js vars/id's
	echo "<option value='$allText'>Select Customer...</option>";//set default value in list box as "Select Customer..."
	while ($row = mysql_fetch_array($query))// go through array from query
	{
		$id=$row['CustomerID'];			//put
		$fname=$row['custFirstname'];	//choosen values
		$sname=$row['custSurname'];		//into php
		$accNum=$row['accNo'];			//variables
		$addr=$row['Address'];
		$cabal=$row['balance'];
		$ovAm=$row['overdrawn'];
		$ovL=$row['ovdftLm'];
		$allText="$id,$fname,$sname,$accNum,$addr,$cabal,$ovAm,$ovL";// put above values into one variable(just for populate function)
		echo "<option value='$allText'>$fname $sname</option>"; //set text in listbox
	}
	echo "</select>";// close listbox
?>
</tr>
<TR><CENTER> &nbsp </CENTER></TR><!-- empty row/col -->
<tr><center><button class="green" id="btn" name="btn" onclick="enableBtn()" >Enable Details</button><!-- This button enables Overdraft Limit -->
<button class="red" id="dblbtn" name="dblbtn" onclick="disableBtn()" >Disable Details</button><!-- This button disables Overdraft Limit -->
</center></tr>
<form name="myForm" action="updatecurracc.php" method="post"><!-- Open form choose file and se method to post so i'll -->
</tr><tr>													 <!-- be able to get values from below field later in php part. -->
<td><div class="textalignR">ID : </div></td>				 <!-- This 'class' is used to align text to the right side of "box" in table -->
<td> <input type="text" name="id" id="id" disabled='disabled'/><BR></td><!-- type-input field, name/id sets value in text field -->
</tr><tr>													 <!-- with choosen informations from above listbox -->
<td><div class="textalignR">Firstname : </div></td>			 <!-- if none it will stay empty -->
<td> <input type="text" name="fname" id="fname" disabled='disabled'/></td>
</tr><tr>
<td><div class="textalignR">Lastname : </div></td>
<td> <input type="text" name="sname" id="sname" disabled='disabled'/></td>
</tr><tr>
<td><div class="textalignR">Address : </div></td>
<td> <input type="text" name="addr" id="addr" disabled='disabled'/></td>
</tr><tr>
<td><div class="textalignR">Current Acc. Balance : </div></td>
<td> <input type="text" name="Balance" id="Balance" disabled='disabled'/> </td>
</tr><tr>
<td><div class="textalignR">Overdrawn Amount on C.A  : </div></td>
<td> <input type="text" name="Overdrawn" id="Overdrawn" disabled='disabled'/> </td>
</tr><tr>
<td><div class="textalignR">Current Account No. : </div></td>
<td> <input type="text" name="AccNum" id="AccNum" disabled='disabled'/> </td>
</tr><tr>
<td><div class="textalignR">Overdraft Limit	 : </div></td>
<td> <input type="text" name="overdraftLim" id="overdraftLim" disabled='disabled'/></td>
</tr>
<tr></tr><tr></tr>
</tr>	
</table><!-- close table -->
<center><button class="green" id="istrue" name="istrue" onclick="updatecaol()">Update Current Account</button></center><!-- when clicked prompts ok/cancel, if user will press ok value will be returned to var 'istrue' -->
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
</form><!-- close form -->

<?php
	$check='';			$currentAcN='';//initialize variables
	$newOvdrftLm='';	$ide='';
	$ide= mysql_real_escape_string($_POST['id']);//Store value from POST into php variable.
	$check= mysql_real_escape_string($_POST['istrue']);	
	$currentAcN= mysql_real_escape_string($_POST['AccNum']);
	$newOvdrftLm= mysql_real_escape_string($_POST['overdraftLim']);	
	$newOvdrftLm=(double)$newOvdrftLm;//convert to double
	if($check=='true')//if value in 'check' is 'true' that means that the update curr acc button was pressed.
	{
		if($currentAcN != '')//if current account number is not empty 
		{
			$sql="UPDATE CurrentAccount
			SET	ovdftLm = $newOvdrftLm
			WHERE accNo = '$_POST[AccNum]'";//updates/change overdraft limit to new value
		
			if(!mysql_query($sql,$con))
			{
				die('Error: ' . mysql_error());
			}
			echo '<script type="text/javascript"> alert("New Overdraft Limit : '."$newOvdrftLm".'") </script>';//prompt to user with new overdraft limit that was set
		}
		else if($ide=='')//if id field is empty == customer not choosen
		{
			echo '<script type="text/javascript"> alert("Please Choose a Customer") </script>';//so prompt with message asking to choose customer
		}
		else//otherwise if account number field is empty or whatever else
		{
			echo '<script type="text/javascript"> alert("ERROR: Account for this user does not exist") </script>';//prompt to user
		}
	}
	mysql_close($con);//close connection
?>
</div>
</CENTER>
</body>
</html>