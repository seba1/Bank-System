<!-- Name: 	Sebastian Horoszkiewicz -->
<!-- Date: 	23.01.2013 -->
<!-- ID	 :	C00156243 -->
<!-- withdrawals.php -->
<html>
<body>
<title>Withdrawals</title>			<!-- page title -->
<CENTER>
<H2>Withdrawals</H2>			<!-- title on top of the page-->
<?php	include 'wMenu.php'; 					//adds menu etc. from
		include 'functionsForWithdrawals.html';	//another file to
		include 'cssStuff.css';					//this page.
		include 'db.php';						//
?>
<BR>
<div class="ridge"><BR>			<!-- css "frame" for table -->
<table>							<!-- creates table  -->
<tr>							<!-- tr,td,/tr,/td creates row's, columns/close row/column -->
<tr><B><center>Select Customer : </B></center></tr>		<!-- indicates for user what to do -->
<tR>
<?php
	date_default_timezone_set('Europe/London');	//to avoid errors if date will be used
	$sql ="	SELECT * FROM 
		(Customer LEFT JOIN CurrentAccount
		ON Customer.CustomerID = CurrentAccount.CustomerNo)
		LEFT JOIN DepositAcc
		ON Customer.CustomerID = DepositAcc.cusid 
		WHERE deleteFlag = 0
		ORDER BY custFirstname";//join information from table customer with CurrentAccount table on customers id's
	$query = mysql_query($sql);		//make a query
	$id=""; $fname=''; $sname=''; $cusNo=''; $accNum=''; $bal=''; $overLimit=''; $depositaccno=''; $depbal=''; $ovL=''; //initialize variables
	$allText="$id,$fname,$sname,$cusNo,$accNum,$bal,$overLimit,$depositaccno,$depbal,$ovL";//set $allText variable to values above (so when "select..." will be selected fields will be empty)
	echo "<select name='listbox' id='listbox' onclick='populate()'>";//set name and id of listbox and go into populate function which will store choosen values into js vars/id's
	echo "<option value='$allText'>Select...</option>"; //set default value in list box as "Select..."
	while ($row = mysql_fetch_array($query))// go through array from query
	{
		$id=$row['CustomerID'];				//put
		$fname=$row['custFirstname'];		//choosen values
		$sname=$row['custSurname'];			//into 
		$cusNo=$row['CustomerNo'];			//php
		$accNum=$row['accNo'];				//variables
		$bal=$row['balance'];
		$overLimit=$row['overdrawn'];
		$depositaccno=$row['depaccno'];
		$depbal=$row['depbalance'];
		$ovL=$row['ovdftLm'];
		$allText="$id,$fname,$sname,$cusNo,$accNum,$bal,$overLimit,$depositaccno,$depbal,$ovL";// put above values into one variable(just for populate function)
		echo "<option value='$allText'>$fname $sname</option>"; //set text in listbox
	}
	echo "</select>";// close listbox

?>

</tr>
<form name="myForm" action="withdrawals.php" method="post"> <!-- Open form choose file and se method to post so i'll -->
</tr><tr>													<!-- be able to get values from below field later in php part. -->
<td><div class="textalignR">ID : </div></td>					<!-- This 'class' is used to align text to the right side of "box" in table -->
<td> <input type="text" name="id" id="id" disabled='disabled'/><BR></td>	<!-- type-input field, name/id sets value in text field -->
</tr><tr>																		 	<!-- with choosen informations from above listbox -->
<td><div class="textalignR">Firstname : </div></td>									<!-- if none it will stay empty -->
<td> <input type="text" name="fname" id="fname" disabled='disabled'/></td><!-- disabled part makes field non editable -->
</tr><tr>																			<!-- and sets colour of this field to gray -->
<td><div class="textalignR">Lastname : </div></td>									<!-- above comment applies to next few lines. -->
<td> <input type="text" name="sname" id="sname" disabled='disabled'/></td>
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
<td><div class="textalignR">Deposit Account Num : </div></td>
<td> <input type="text" name="DepAccNum" id="DepAccNum" disabled='disabled'/> </td>
</tr><tr>
<td><div class="textalignR">Deposit Balance  : </div></td>
<td> <input type="text" name="DepBal" id="DepBal" disabled='disabled'/> </td>
</tr><tr>
<td><div class="textalignR">Overdraft Limit	 : </div></td>
<td> <input type="text" name="overdraftLim" id="overdraftLim" disabled='disabled'/></td>
</tr><tr>
<td><div class="textalignR">Enter Amount to Withdraw : </div></td> 
<td><input type="text" name="withdrawAmount" id="withdrawAmount" value="0" autofocus /></td><!-- value = 0 therefore there will be 0 in that box -->
</tr>																	<!-- because we want user to input some value -->
<tr></tr><tr></tr>
<tr>
<td><div class="textalignR">
<button class="green" id="cbtn" name="cbtn" onclick="fromCurrAcc()">Withdraw from Current Acc</button></td><!-- button with added css, when clicked function is called (more about this function in functionsForWithdrawals.html file -->
<td>
<button class="blue" id="depbtn" name="depbtn" onclick="fromDepAcc()">Withdraw from Deposit Acc</button></td><!-- button with added css, when clicked function is called (more about this function in functionsForWithdrawals.html file -->
</tr>	
</table>	<!-- close table -->
<input type="hidden" name="withdr" id="withdr" />
<!-- 'withdr' - Withdraw, holds value from above button (clicked one) otherwise empty-->
</form><!-- close form -->
</div><!-- close ridge class (css part at the very start(border for table -->
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR> <!-- hide Notice's about non initialized variables -->
<?php
	$wAm= mysql_real_escape_string($_POST['withdrawAmount']);	//Store value from variable id POST into php variable.
	$currentDate = date("Y-m-d");								//Get todays date.
	$check='';												 	//Initialize variable which will hold value
	$checkWithd=false;
	$check= mysql_real_escape_string($_POST['withdr']);		 	//from withr variable.
	$ovftLim= mysql_real_escape_string($_POST['overdraftLim']);	//Similar to above.
	$ovftLim=(double)$ovftLim;								   	//Change value in this variable to double.
	$ovftLimMinus=$ovftLim*(-1);								//Make above value a negative value AND store it in New Variable.
	if($_POST['id']!="")//If id field is not empty == some value is there == go into this if
    {								//CURENT ACCOUNT//
	  if($check=='currAcc' && $_POST['AccNum']!='')	//if check have value of 'currAcc' that means that customer wants to take money
      {														//from curren acc, also check is account number field not empty
		//Overdrawn Amount (if any)
		$overdrawn= mysql_real_escape_string($_POST['Overdrawn']);//Get overdrawn amount
		$overdrawn=(double)$overdrawn;									//and convert string var into double(number).
		//Amount to withdraw
		$withdrawAmount= mysql_real_escape_string($_POST['withdrawAmount']);//Do the same as above.
		if($withdrawAmount=='')	//If user did not type anything into withdraw field
		{	$wAm=0;				//set withdrawn amount to 0.
			$withdrawAmount=0; }//
		else
		$withdrawAmount=(double)$withdrawAmount;//Otherwise convert inputed value to double(number).
		$CAbal= mysql_real_escape_string($_POST['Balance']);//Get current balance from user.
		$balance=0;					//Initialize var to 0.
		$balance=(double)$CAbal;	//Conver to double.
		$result = $balance - $withdrawAmount;//Calculate new balance.
		if($result<0)//If result is less than 0 then go in this if statement.
		{
			if($result<$ovftLimMinus)//If result is greater than Overdraft Limit
			{
				echo '<script type="text/javascript"> alert("ERROR: Not enough Funds") </script>';//Alert box telling user above if inormaton.
				$checkWithd=false;//set to false (transaction unsuccessful)
			}
			else//If result is in the range of overdraft limit go in there.
			{
				if($overdrawn>0)//If customer have already overdrawn amount (e.g overdrawn amount = 20(OVERDRAWN IS NOT A NEGATIVE VALUE)
				{				//then go through this if.
					$finalBalance=0;				//Set balance to 0.
					$newresult=$result*(-1);		//Change negative result into positive value.
					$newoverdrawn=$overdrawn+$newresult;	//Add overdrawn to amount that was over balance limit.
					if($newoverdrawn>$ovftLim) //If new overdrawn amount is greater than overdraft Limit then go into this if.
					{
						echo '<script type="text/javascript"> alert("ERROR : Not Enough Funds") </script>'; //Prompt an error (customer have not eough funds).
						$checkWithd=false;
					}
					else//If result is in the overdraft Limit then go into this else
					{
						$finalBalance=0;			//Initialize final balace var to 0.
						$overdrawn=$newoverdrawn;	//Set variable to new value.
						echo '<script type="text/javascript"> alert("You have Overdrawn Amount of : '."$overdrawn".'\n\nAmount Withdrawn : '."$wAm".'") </script>';//Inform about successfull withdraw telling how much you have taken out and how much you have overdrawn
						$checkWithd=true;//set to true (transaction successful)
					}
				}
				else //If customer have overdrawn amount == 0 then go into this else.
				{
					$finalBalance=0; //Set balance to 0.
					$newresult=$result*(-1); //Convert negative result to positive value.
					$overdrawn=$newresult;   //Set overdrawn amount to new one.
					echo '<script type="text/javascript"> alert("You have Overdrawn Amount of : '."$overdrawn".'\n\nAmount Withdrawn : '."$wAm".'") </script>';//Inform user about successful transation
					$checkWithd=true;
				}
			}
		}
		else//If result is greater than 0.
		{
			$finalBalance=$result;	//Set new balance.
			$overdrawn=$overdrawn;	//Set new Overdrawn.
			echo '<script type="text/javascript"> alert("New CA Balance : '."$finalBalance".'\n\nAmount Withdrawn : '."$wAm".'") </script>';//Inform user about successful transaction.
			$checkWithd=true;
		}
		if($checkWithd==true)//if transaction is successful update current account table and insert values that was changed into current history acc
		{
			$sql="UPDATE CurrentAccount
			SET balance = $finalBalance, overdrawn = $overdrawn
			WHERE accNo = '$_POST[AccNum]'"; // Update CurrentAccount table on balance and overdrawn amount, only where the accNo == posted acc Num.
			if(!mysql_query($sql,$con))
			{
				die('Error: ' . mysql_error());
			}
			$sql="INSERT INTO 
			CurrentAccHistory
			(AccNum, withdAm, Balance, OverdrawnAm, date)
			VALUES
			('$_POST[AccNum]','$withdrawAmount','$finalBalance','$overdrawn','$currentDate')";//Insert values into current acc history table
			if(!mysql_query($sql,$con))
			{
				die('Error: ' . mysql_error());
			}
		}	 
	 }
	  else if($_POST['AccNum']=='')//If current account number field is empty
      {
		echo '<script type="text/javascript"> alert("ERROR: Current Account Does Not Exist") </script>'; //Prompt to user & tell him that C.Acc does not exist for this customer.
	  
	  }
							//DEPOSIT ACCOUNT//
	  else if($check=='depAcc')//If check valu is eq to 'depAcc'
      {
		$withdrawAmount= mysql_real_escape_string($_POST['withdrawAmount']);//Get Amount to withdraw.
		if($withdrawAmount=='')
		{	 $wAm=0;			//Set those
			$withdrawAmount=0; }//values to 0.
		else//Otherwise.
			$withdrawAmount=(double)$withdrawAmount;//Convert withdrawAmount to double.
		$depBal= mysql_real_escape_string($_POST['DepBal']);//Get deposit blance.
		$depBalance=0;//Initialize to 0.
		$depBalance=(double)$depBal;//Convert depBal to double.
		$depResult = $depBalance - $withdrawAmount;//Calculate Deposit balance (Deposit balance - Withdraw amount).
		if($_POST['DepAccNum']=='')//If posted value is empty 
		{
			echo '<script type="text/javascript"> alert("ERROR: Deposit Account Does Not Exist") </script>'; //that will mean that account does  not exist.
		}
		else//Otherwise.
		{			
		  if($depResult<0)//If result is less than 0.
		  {
			echo '<script type="text/javascript"> alert("ERROR: Not enough Funds") </script>'; //There is not enouh funds.
		  }
		  else//If result is eq or greater than 0.
		  {
			$newDepBal=0;//Initialize Variable.
			$newDepBal=$depResult;//Put new Result into new variable.
			echo '<script type="text/javascript"> alert("New Balance : '."$newDepBal".'\n\nAmount Withdrawn : '."$wAm".'") </script>'; //Output successful withdrawn from Deposit Account.
		 
			$sql="UPDATE DepositAcc
			SET depbalance = $newDepBal
			WHERE cusid = '$_POST[id]'";//Update deposit balance in DepositAcc table, where cusid is equal to the one posted.  
			if(!mysql_query($sql,$con))
			{
				die('Error: ' . mysql_error());
			}
			$sql="INSERT INTO 
			DepAccHist
			(depAccNum, widthAm, Balance, date)
			VALUES
			('$_POST[DepAccNum]','$wAm','$newDepBal','$currentDate')";//Insert values into deposit acc history table
			if(!mysql_query($sql,$con))
			{
				die('Error: ' . mysql_error());
			}
		 }
		}
	  }
	}//END IF
	else if($_POST['id']=='' && ($check=='depAcc' || $check=='currAcc'))//If user pressed one of the button but the id field is empty that means that 
	echo '<script type="text/javascript"> alert("Please Choose a Person") </script>'; //user was not choosen, so prompt with this error message.

	mysql_close($con);//Close connection.
?>
</center><!-- Close center -->
</body><!-- Close body -->
</html><!-- Close html -->