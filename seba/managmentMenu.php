<!-- Name: 	Sebastian Horoszkiewicz -->
<!-- Date: 	06.03.2013 -->
<!-- ID	 :	C00156243 -->
<!-- menu.html -->
<html>
<title>Managment Menu</title>
<?php 	include 'cssStuff.css' ?> <!-- includes css -->
<body>
<center>
<button class="green" onclick="parent.location='/pg.php'">Homepage</button><!-- button to homepage -->
<button class="green" onclick="parent.location='/seba/chargeinterest.php'">Charge Interest on Overdrawn Current Accounts</button>
<button class="green" onclick="parent.location='/'">Calculate Interest on Deposit Accounts</button>
<button class="green" onclick="parent.location='/'">Calculate Interest on Current Accounts</button>
<button class="green" onclick="parent.location='/'">Change Rate of Interest for Deposit Accounts</button>
<button class="green" onclick="parent.location='/'">Change Rate of Interest for Loan Accounts</button>
<button class="green" onclick="parent.location='/'">Change Rate of Interest for Current Accounts</button>
<button class="red" id="lo" name="lo" onclick="logout()" >Log Out</button>
</center>
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
</body>
</html>