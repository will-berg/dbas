<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div class="container">
<div class="page-header">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav">
  <a class="nav-link" href="movies.php">Movies</a>
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



<!--Styling HTML ends and the real work begins below-->

<?php

$upid=isset($_GET['upid']) ? $_GET['upid'] : die('ERROR: User Profile ID not found.'); //The parameter value from the click is aquired
include 'connection.php'; //Init a connection

$query = "SELECT media.name AS movie, listentryid, userprofile, watchlist.rating, progress FROM Watchlist JOIN media ON movie = mediaid WHERE userprofile = :upid";

$stmt = $con->prepare($query);
$stmt->bindParam(':upid', $upid); //Binding ID for the query

$stmt->execute();


$num = $stmt->rowCount(); //Aquire number of rows

if($num>0){ //Is there any data/rows?
    echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
    echo "<tr>";
        echo "<th>movie</th>"; // Rename, add or remove columns as you like.
		echo "<th>upid</th>";
    echo "<th>rating</th>";
    echo "<th>progress(in %)</th>";
    echo "</tr>";
while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
    extract($rad);
    echo "<tr>";

		// Here is the data added to the table
        echo "<td>{$movie}</td>"; //Rename, add or remove columns as you like
		echo "<td>{$upid}</td>";
    echo "<td>{$rating}</th>";
    echo "<td>{$progress}</th>";
		echo "<td>";

		//Here are the buttons for update, delete and read.
		echo "<a href='updateRating.php?listentryid={$listentryid}' class='btn btn-primary m-r-1em'>Update rating</a>";// Replace with ID-variable, to make the buttons work
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
