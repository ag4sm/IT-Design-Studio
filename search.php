<!DOCTYPE html>
<html lang="en">
<head>
<title>KSU CCSE Service Search</title>
<meta charset="UTF-8" />
<link rel= "stylesheet" type = "text/css" href = "stylesheet.css">
<script type="text/javascript">
<!--
function validateSearch() {

	if isset(document.searchp.searchservice) {
		alert("You must make a selection");
		document.searchp.searchservice.focus();
		return false;	
	}else {return true;}
	
}
//-->
</script>
</head>

<body>
<header>

<h1>KSU CCSE Services Search</h1>

</header>

<nav>
<?php include "menu.php"; ?>
</nav>

	<h2>Site Search</h2>

<section>
	<!--	<article id="left">
		<label for="searchserv">Search for Services <input type="text" name="searchserv" id="searchserv" size="30" required /></label>
		</article> -->
		
		<article id="centr">
		
		<p>This site currently shows all registered members' names and email addresses.  Below you can select a service that you need and click the Search button to get a listing of who provides that service.</p>
		
		<table>
					<tr><th>First Name</th><th>Last Name</th><th>Email Address</th></tr>
		
			<?php 
		
			$conn = new mysqli("localhost", "app_user",
            "my*password", "wscoville");

			if (mysqli_connect_errno()){
			echo 'Cannot connect to database: ' .
              mysqli_connect_error($conn);
			}
			else{
			echo "Connected to MySQL database.<br />";

			//specify query NOTE that first ; is the end of the query
			$query = "select profiles.fname, profiles.lname, profiles.email  from profiles;";

			//run the query and keep results in $result variable
			$result = mysqli_query($conn, $query);

			// Check the result

			if (!$result) {
				die("Invalid query: " . mysqli_error($conn));
				}
			else {
				echo "<br />";

            //use loop to fetch records from $result
				
            while ($row = mysqli_fetch_array($result)){

                //$row hold individual row from a recordset
                //$row['field_name'] is the value of the field
                //<br /> is used to display each field on a new line

				echo "<tr><td>{$row['fname']}</td><td>{$row['lname']}			</td><td>{$row['email']}</td></tr>";
					}
				
				mysqli_free_result($result);
					}
				
			}
		
			?>
		</table>
		
		<p>
		<form name="searchp" id="searchp" action="searchprov_res.php" method="post" onsubmit="return validateSearch();" >
		<label for="searchprov">Search by Service  
		<select name="searchservice" id="searchservice">
		<?php 
		$q1 = "select service from services;";
		$qResult = mysqli_query($conn,$q1) or die("Database query error" . mysqli_error($db));
		while ($row = mysqli_fetch_array($qResult)) {
		echo "<option value = '" . $row['service'] . "'>" . $row['service'] ."</option>";
		}
		
		mysqli_close($conn);
		?>
		</select>
		</label>
		</p>
		
		<p class="buttons">
		<input type="submit" value="Search" id="searchb" />
		<input type="reset" value="Reset" id="reset" />
		</form>
		</p>
		
		</article>
		
		<article id="right">		
		</article> 
		
	
				
	
	
</section>

</body>
</html>