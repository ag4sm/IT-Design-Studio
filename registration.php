<!DOCTYPE html>
<html lang="en">
<head>
<title>KSU CCSE Service Registration</title>
<meta charset="UTF-8" />
<link rel= "stylesheet" type = "text/css" href = "stylesheet.css">
<script type="text/javascript">
<!--

// instant validation for services
function checkserv_validate() {

var servchkd = document.getElementsByName("servicesoffered[]");
var okay = false;

    for(var i=0,l=servchkd.length;i<l;i++)
    {
        if(servchkd[i].checked)
        {
            okay=true;
            break;
        }
    }
    if(okay) {document.getElementById("servwarn").style.visibility = "hidden" ;
				return true;}
    else {document.getElementById("servwarn").style.visibility = "visible" ;
			document.getElementById("servwarn").style.color = "red" ;
				return false;}
}

//instant validation for days checkboxes
function checkdays_validate() {

var dayschkd = document.getElementsByName("days[]");
var okay = false;

    for(var i=0,l=dayschkd.length;i<l;i++)
    {
        if(dayschkd[i].checked)
        {
            okay=true;
            break;
        }
    }
    if(okay) {document.getElementById("dayswarn").style.visibility = "hidden" ;
    		return true;}
    else {document.getElementById("dayswarn").style.visibility = "visible" ;
			document.getElementById("dayswarn").style.color = "red" ;
			return false;}
}

//instant validation for time checkboxes
function checktime_validate() {

var timechkd = document.getElementsByName("time[]");
var okay = false;

    for(var i=0,l=timechkd.length;i<l;i++)
    {
        if(timechkd[i].checked)
        {
            okay=true;
            break;
        }
    }
    if(okay) {document.getElementById("timewarn").style.visibility = "hidden" ;
    		return true;}
    else {document.getElementById("timewarn").style.visibility = "visible" ;
			document.getElementById("timewarn").style.color = "red" ;
			return false;}
}

//form validation called when submit is pressed
function validateForm() {

	if (document.registration.netid.value.length == 0) {
		alert("You must enter a correct KSU Net ID");
		document.registration.netid.focus();
		return false;	
	}
	
	else if (document.registration.netid.value.length < '3') {
		alert("You must enter at least 3 characers for netid");
		document.registration.netid.focus();
		return false;
	}
	
	else if (document.registration.fname.value.length == 0) {
		alert("You must enter a First Name");
		document.registration.fname.focus();
		return false;
	}
	
	else if (document.registration.fname.value.length < '3') {
		alert("You must enter at least 3 characers for First Name");
		document.registration.fname.focus();
		return false;
	}
	
	else if (document.registration.lname.value.length == 0) {
		alert("You must enter a Last Name");
		document.registration.lname.focus();
		return false;
	}	
	
	else if (document.registration.lname.value.length < '3') {
		alert("You must enter at least 3 characers for Last Name");
		document.registration.lname.focus();
		return false;
	}
	
	else if (document.registration.email.value != document.registration.emailcheck.value) {
		alert("Email fields do NOT match");
		document.registration.email.focus();
		return false;
	}
	
	else if (checkserv_validate() == false || checkdays_validate() == false || checktime_validate() == false) {
		alert("Check to make sure at least one item in each selection is selected!");
		return false;
	}
	
	else {return true;}
	
}
//-->
</script>
</head>

<body>
<header>

<h1>KSU CCSE Services Listing</h1>

</header>

<nav>
<?php include "menu.php"; ?>
</nav>

<h2>Site Registration</h2>

<!--Registration form follows-->

<section id="form">
	<form id="registration" name="registration" action="reg_results.php" method="post" onsubmit="return validateForm();" >
		
		<!--Left Column-->
		<article id="left">
		<label for="ksuid">KSU Net ID:  <input type="text" name="netid" id="netid" tabindex="1" size="10"  title="You must type at least 3 letters." pattern="\w{3,}" required /></label>
		<br /><br />
		<label for="email">Email Address:  <input type="email" name="email" id="email" tabindex="4" size="25" required /></label><br />
		<br />
		<h4>Services Offered:</h4>
		
		<?php
		
		// connect to database
		$conn = mysqli_connect("localhost", "app_user", "my*password", "wscoville")
                  or die("Cannot connect to database:" . mysqli_connect_error($conn));

		$servq = "SELECT serviceID, service FROM services;";
		
		$dbResult = mysqli_query($conn,$servq) or die("Database query error" . mysqli_error($conn));

		while ($row = mysqli_fetch_array($dbResult)) {
		echo "<input type=\"checkbox\" name=\"servicesoffered[]\" onclick=\"checkserv_validate();\" value =\"$row[serviceID]\">" .$row['service']. "<br />";
		}
		
		mysqli_free_result($dbResult);
		
		?>
		
		<h5 id="servwarn" style="visibility:visible" >You must check at least 1 Service</h5>
		</article>
		
		<!--Middle Column-->
		<article id="center">
		<label for="fname">First Name: <input type="text" name="fname" id="fname" tabindex="2" size="20" title="You must type at least 3 letters." pattern="\w{3,}" required /></label><br />
		<br />
		<label for="emailcheck">Confirm Email: <input type="email" name="emailcheck" id="emailcheck" tabindex="5" size="25" required /></label><br />
		<br />
		<h4>Days Available:</h4>
		
		<?php
		
		$servq = "SELECT dayID, days FROM days;";
		
		$dbResult = mysqli_query($conn,$servq) or die("Database query error" . mysqli_error($conn));

		while ($row = mysqli_fetch_array($dbResult)) {
		echo "<input type=\"checkbox\" name=\"days[]\" onclick=\"checkdays_validate();\" value=\"$row[dayID]\">" .$row['days']. "<br />";
		}
		
		mysqli_free_result($dbResult);
		?>
	
			<h5 id="dayswarn" style="visibility:visible" >You must check at least 1 Day</h5>
		</article>

		<!--Right Column-->
		<article id="right">
		<label for="lname">Last Name: <input type="text" name="lname" id="lname" tabindex="3" size="20" title="You must type at least 3 letters." pattern="\w{3,}" required /></label>
		<br /><br />
		<label for="emailconf">Email Confirmation? <input type="checkbox" name="emailconf[]" id="emailconf" tabindex="6" /></label>
		<br /><br />
		<h4>Time Available:</h4>
		
		<?php
		
		$servq = "SELECT timeID, timeslot FROM timeslots;";
		
		$dbResult = mysqli_query($conn,$servq) or die("Database query error" . mysqli_error($conn));

		while ($row = mysqli_fetch_array($dbResult)) {
		echo "<input type=\"checkbox\" name=\"time[]\" onclick=\"checktime_validate();\" value=\"$row[timeID]\" >".$row['timeslot']. "<br />";
		}
		
		mysqli_free_result($dbResult);
		mysqli_close($conn); // close database connection
		
		?>
		
			<h5 id="timewarn" style="visibility:visible" >You must check at least 1 Time Slot</h5>
		</article>
		
		<p class="buttons">
		<input type="submit" value="Register" id="register" />
		<input type="reset" value="Reset" id="reset" />
		</p>
	</form>
	
</section>

</body>
</html>