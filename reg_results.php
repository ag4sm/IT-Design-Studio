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

<h2>Site Registration</h2>

<section>
  <?php
	$today = date("m/d/y");
	
	$all_info_provided = 1;

	if(!empty($_POST["netid"]) && !empty($_POST["email"]) && !empty($_POST["fname"]) && !empty($_POST["lname"])){

	$netid = $_POST["netid"];
	
	$email = $_POST["email"];
	
   $fname = $_POST["fname"];

   $lname = $_POST["lname"];
   
    

   $msg = "Thank you ". $fname ." ". $lname." for your registration on our web site. <br /> " .$today;
   
   
   
   echo "First Name:  $fname, Last Name:  $lname <br /> KSU Net ID:  $netid <br /> Email Address:  $email <br /><br /> ". $msg;
   
} else {

   $msg = "NetID, Name and email are required fields";
	
	echo $msg;
	$all_info_provided = 0;
	}
	
	if (!empty($_POST['servicesoffered'])) {
		
		$services = implode(",", $_POST['servicesoffered']);
		
	} else {
		echo "You must select at least one service!";
		$all_info_provided = 0;
	}
	
	if (!empty($_POST['days'])) {
		
		$days = implode(",", $_POST['days']);
		
	} else {
		echo "You must select at least one day!";
		$all_info_provided = 0;
	}
	
	if (!empty($_POST['time'])) {
		
		$time = implode(",", $_POST['time']);
		
	} else {
		echo "You must select at least one time slot!";
		$all_info_provided = 0;
	}
	
	  if (!empty($_POST["emailconf"])) {
            $email_conf = 1;
            echo("<p>Email Confirmation: Yes</p>");
				$to = $email;
				$subject = "Registration";
				$body = $msg;
				
			if (mail($to, $subject, $body)) {

				echo("<p>Confirmation email message successfully sent!</p>");

				} else {
					echo("<p>Confirmation email message delivery failed...</p>");
					}
			} else {
				$email_conf = 0;

				$confErr = "No";
                    echo("<p>Email Confirmation: ". $confErr . "</p>");
				}
	
	
	if ($all_info_provided == 1) {
			
		// connect to the database
		$conn = mysqli_connect("localhost", "app_user", "my*password", "wscoville")
				or die("Cannot connect to database:" .mysqli_connect_error($conn));
			
		//create prepared statement to insert data in profiles table
		$query = mysqli_prepare($conn, "INSERT INTO profiles (netID, fname, lname, email, email_notification) VALUES(?,?,?,?,?)") or die("Error: ". mysqli_error($conn));
			
		// bind parameters "s" - string "i" - integer
		mysqli_stmt_bind_param ($query, "ssssi", $netid, $fname, $lname, $email, $email_conf);
			
		//run the query mysqli_stmt_execute returns true if the query was successful
		mysqli_stmt_execute($query)
			or die("Error. Could not insert into the profiles table." . mysqli_error($conn));
			
		// mysqli_insert_id($conn) Returns the auto generated id used in the  query for current connection
		$inserted_id = mysqli_insert_id($conn);
			echo "Your data was recorded. It is entry #" . $inserted_id. "<br />";

		mysqli_stmt_close($query); 
		
			
		// insert data into services_provided
		foreach($_POST['servicesoffered'] as $services_prov) {
			
			$query = mysqli_prepare($conn, "INSERT INTO services_provided (profileID, serviceID) VALUES(?,?)")
					or die("Error: ". mysqli_error($conn));
			
			// bind parameters "i" - integer $inserted_id holds eventID
			mysqli_stmt_bind_param($query, "ii",$inserted_id, $services_prov);
			
			mysqli_stmt_execute($query)
					or die("Error. Could not insert into the services provided table." . mysqli_error($conn));

			mysqli_stmt_close($query);
		}

		
		//insert data into days_provided table
		foreach($_POST['days'] as $days_prov) {
			
			$query = mysqli_prepare($conn, "INSERT INTO days_provided (profileID, dayID) VALUES(?,?)")
					or die("Error: ". mysqli_error($conn));
		
			// bind parameters "i" - integer $inserted_id holds eventID
			mysqli_stmt_bind_param($query, "ii",$inserted_id, $days_prov);
			
			mysqli_stmt_execute($query)
					or die("Error. Could not insert into the days provided table." . mysqli_error($conn));

			mysqli_stmt_close($query);
		}
			
		
		//insert data into timeslots_provided table
		foreach($_POST['time'] as $timeslot_prov) {
			
			$query = mysqli_prepare($conn, "INSERT INTO timeslots_provided (profileID, timeID) VALUES(?,?)")
					or die("Error: ". mysqli_error($conn));
		
			// bind parameters "i" - integer $inserted_id holds eventID
			mysqli_stmt_bind_param($query, "ii",$inserted_id, $timeslot_prov);
			
			mysqli_stmt_execute($query)
					or die("Error. Could not insert into the days provided table." . mysqli_error($conn));

			mysqli_stmt_close($query);
		}
			
	}else {
		echo "<p>All information is required, use back button and complete all required fields.</p>";
		}
	
	
	$serv_query = "select services.service 
		from profiles, services, services_provided
		where profiles.profileID = services_provided.profileID AND services_provided.serviceID = services.serviceID AND profiles.profileID = '$inserted_id';";
	
	$result = mysqli_query($conn, $serv_query);
	
	if (!$result) {
			die("Invalid query: " . mysqli_error($conn));
			}
         else {echo "<p>Services selected to offer: ";
            		
		while($row = mysqli_fetch_array($result)){
				$qsrvc = $row['service'];
			
			 echo "{$qsrvc}, ";
			
			} echo "<br /></p>";
		 
			mysqli_free_result($result);
		 } 
		 
	$days_query = "select days.days 
		from profiles, days, days_provided
		where profiles.profileID = days_provided.profileID AND days_provided.dayID = days.dayID AND profiles.profileID = '$inserted_id';";
	
	$result = mysqli_query($conn, $days_query);
	
	if (!$result) {
			die("Invalid query: " . mysqli_error($conn));
			}
         else {echo "<p>Days selected to offer services: ";
            		
		while($row = mysqli_fetch_array($result)){
				$qdays = $row['days'];
			
			 echo "{$qdays}, ";
			
			} echo "<br /></p>";
		 
			mysqli_free_result($result);
		 } 
	
	
	
	$time_query = "select timeslots.timeslot 
		from profiles, timeslots, timeslots_provided
		where profiles.profileID = timeslots_provided.profileID AND timeslots_provided.timeID = timeslots.timeID AND profiles.profileID = '$inserted_id';";
	
	$result = mysqli_query($conn, $time_query);
	
	if (!$result) {
			die("Invalid query: " . mysqli_error($conn));
			}
         else {echo "<p>Times selected to be available: ";
            		
		while($row = mysqli_fetch_array($result)){
				$qtime = $row['timeslot'];
			
			 echo "{$qtime}, ";
			
			} echo "<br /></p>";
		 
			mysqli_free_result($result);
		 } 
	
	mysqli_close($conn);
	
  ?>
</section>
</body>
</html>
