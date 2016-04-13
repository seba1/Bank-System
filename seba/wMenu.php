<!-- Name: 	Sebastian Horoszkiewicz -->
<!-- Date: 	06.03.2013 -->
<!-- ID	 :	C00156243 -->
<!-- menu.html -->
<html>
<title>Menu</title>
<?php 	include 'cssStuff.css' ?> <!-- includes css -->
<body>
<center>
<button class="green" onclick="parent.location='/pg.php'">Homepage</button><!-- button to homepage -->
<button class="green" onclick="parent.location='/seba/withdrawals.php'">Withdrawals</button>
<button class="green" onclick="parent.location='/josh/lodgements.php'">Lodgements</button>
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