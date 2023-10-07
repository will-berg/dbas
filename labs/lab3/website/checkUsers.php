<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="style.css"/>
<style>
</style>
</head>
<body>
<div class="container">
<div class="page-header">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

  <ul class="navbar-nav">
	<li class="nav-item">
		<a class="nav-link" href="movies.php">Movies</a>
	</li>
    <li class="nav-item">
		<a class="nav-link" href="createmovies.php">Add movie</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="users.php">Users</a> <!--Insert your own php-file here -->
    </li>
    <li class="nav-item">
      <a class="navbar-brand" href="checkUsers.php">Profiles</a> <!--Insert your own php-file here -->
    </li>
  </ul>
</nav>
</div>

<?php

include 'connection.php'; //Init a connection
session_start();


$query = "SELECT name, upid FROM UserProfiles WHERE customer = :custid";

$stmt = $con->prepare($query);
$custid = $_SESSION['customerID'];

$stmt->bindParam(':custid', $custid);

$stmt->execute();

$num = $stmt->rowCount(); //Aquire number of rows

if($num>0){ //Is there any data/rows?
    echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
    echo "<tr>";
        echo "<th>name</th>"; // Rename, add or remove columns as you like.
		echo "<th>upid</th>";
    echo "</tr>";
while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
    extract($rad);
    echo "<tr>";

		// Here is the data added to the table
        echo "<td>{$name}</td>"; //Rename, add or remove columns as you like
		echo "<td>{$upid}</td>";
		echo "<td>";

		//Here are the buttons for update, delete and read.
		echo "<a href='watchlist.php?upid={$upid}'class='btn btn-info m-r-1em'>Watchlist</a>"; // Replace with ID-variable, to make the buttons work
		echo "<a href='deleteProfile.php?upid={$upid}' class='btn btn-danger'>Delete</a>";// Replace with ID-variable, to make the buttons work
		echo "</td>";
    echo "</tr>";
}
echo "</table>";
}
else{
	echo "<h1> Search gave no result </h1>";
}






?>
</div>
</body>
</html>
