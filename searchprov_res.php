<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Submission Results</title>
<link rel= "stylesheet" type = "text/css" href = "stylesheet.css">
</head>

<body>
<header>
<h1>KSU CCSE Services Listing</h1>
</header>
<nav>
<?php include "menu.php"; ?>
</nav>
<section>
<h2>Selected Service Providers</h2>
<table>
		<tr><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Service</th></tr>

<?php
$conn = mysqli_connect("localhost", "app_user", "my*password", "wscoville")
	or die("Cannot connect to database:" .mysqli_connect_error($con));

	$q = "select fname, lname, email, services.service from profiles, services inner join services_provided where profiles.profileID = services_provided.profileID AND services_provided.serviceID = services.serviceID AND services.service ='$_POST[searchservice]';" or die("Error: ". mysqli_error($conn));
	
	$queryResult = mysqli_query($conn,$q) or die("Database query error" . mysqli_error($conn));
	
		while ($row = mysqli_fetch_array($queryResult)) {
		echo "<tr><td>{$row['fname']}</td><td>{$row['lname']}</td><td>{$row['email']}</td><td>{$row['service']}</td></tr>";
		}
		
		mysqli_free_result($queryResult);		
		mysqli_close($conn);
?>
</table>
</section>
</body>
</html>