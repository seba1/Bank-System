<!-- Name: 	Sebastian Horoszkiewicz -->
<!-- Date: 	26/02/2013 -->
<!-- ID	 :	C00156243 -->
<HTML>
<head>
</head>
<CENTER>
<TITLE>Homepage</TITLE>
<?php 	include 'cssForHomePage.css';	?>
<H2><U>Account Maintenance Menu</U></H2>
<button class="green" onclick="parent.location='/josh/lodgements.php'" >Lodgements</button>
<button class="green" onclick="parent.location='/seba/withdrawals.php'">Withdrawals</button>
<button class="green" onclick="parent.location='/josh/changePassword.php'"  >Change Password</button>
<button class="red" id="lo" name="lo" onclick="logout()" >Log Out</button>
<table>
<tr><td>
<div class="ridge">
<center><BR>Customer File Maintenance Menu<BR>
<button class="green" onclick="parent.location='/josh/AddCustomer.php'" >Add a New Customer</button>
<button class="green" onclick="parent.location='/josh/deleteCustomer.php'" >Delete a Customer</button>
<button class="green" onclick="parent.location='/josh/Amend.php'" >Amend/View a Customer</button>
</center></div>
</td><td>
<div class="ridge">
<center><BR>Managment Menu I<BR>
<button class="green" onclick="parent.location='/seba/chargeinterest.php'" >Charge Interest on Overdrawn CA</button>
<button class="green" onclick="parent.location='/'" >Charge Interest on Deposit Acc.</button>
<button class="green" onclick="parent.location='/'" >Calculate Interest on Current Acc.</button>
</center></div>
</td><tr><td>
<div class="ridge">
<center><BR>Current Account Menu<BR>
<button class="green" onclick="parent.location='/seba/OpenCurAcc.php'" >Open Current Account</button>
<button class="green" onclick="parent.location='/seba/closecurracc.php'" >Close a Current Account</button>
<button class="green" onclick="parent.location='/seba/updatecurracc.php'" >Update Current Account</button>
</center></div>
</td><td>
<div class="ridge">
<center><BR>Managment Menu II<BR>
<button class="green" onclick="parent.location='/'" >Change rate of interest for DA</button>
<button class="green" onclick="parent.location='/'" >Charge rate of interest for LA</button>
<button class="green" onclick="parent.location='/'" >Charge rate of interest for Current Account</button>
</center></div>
</td><tr><td>
<div class="ridge">
<center><BR>Deposit Account Menu<BR>
<button class="green" onclick="parent.location='/'" >Open a Deposit Account</button>
<button class="green" onclick="parent.location='/'" >Close a Deposit Account</button>
<button class="green" onclick="parent.location='/'" >View Deposit Account</button>
</center></div>
</td><td>
<div class="ridge">
<center><BR>Quotes Menu<BR>
<button class="green" onclick="parent.location='/'" >Quote Loan Repayment</button>
<button class="green" onclick="parent.location='/'" >Quote Deposit Account</button>
<button class="green" onclick="parent.location='/'" >Quote Loan Account</button>
<button class="green" onclick="parent.location='/'" >Quote Current Account rates</button>
</center></div>
</td></tr><tr><td>
<div class="ridge">
<center><BR>Loan Account Menu<BR>
<button class="green" onclick="parent.location='/'" >Open Loan Account</button>
<button class="green" onclick="parent.location='/'" >Close a Loan Account</button>
<button class="green" onclick="parent.location='/'" >Amend/View Loan Account</button>
</center></div>
</td><td>
<div class="ridge">
<center><BR>Reports Menu<BR>
<button class="green" onclick="parent.location='/'" >Deposit Acc. History</button>
<button class="green" onclick="parent.location='/'" >Loan Account History</button>
<button class="green" onclick="parent.location='/'" >Current Acc. History</button>
<button class="green" onclick="parent.location='/'" >Customer Report</button>
</center></div>
</td></tr>
</table>
</CENTER>
<script>
function logout()//prompts to user to confirm log out
{
	var r=confirm("Are You Sure?");//set text into 'box' and return true/false
	if (r==true)//if user pressed 'ok' r=true
	{
		window.location='/josh/login.php';//go to log-in page
	}
}
</script>
</BODY>
</HTML>