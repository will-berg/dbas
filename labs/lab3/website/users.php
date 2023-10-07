<!--Here is some styling HTML you don't need to pay attention to-->
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
      <a class="navbar-brand" href="users.php">Users</a> <!--Insert your own php-file here -->
    </li>
    <li class="nav-item">
      <a class="nav-link" href="checkUsers.php">Profiles</a> <!--Insert your own php-file here -->
    </li>
  </ul>
</nav>
</div>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Search</td>
            <td><input type='text' name='keyword' class='form-control' /></td>
        </tr>
    </table>
</form>

<!--Styling HTML ends and the real work begins below-->

<?php


include "connection.php";

$query = "SELECT * FROM Customers WHERE LOWER(name) LIKE LOWER(:keyword)";

$stmt = $con->prepare($query);
$keyword= isset($_POST['keyword']) ? $_POST['keyword'] : ''; //Is there any data sent from the form?

$keyword = "%".$keyword."%";
$stmt->bindParam(':keyword', $keyword);

$stmt->execute();

$num = $stmt->rowCount(); //Aquire number of rows

if($num>0){ //Is there any data/rows?
    echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
    echo "<tr>";
        echo "<th>name</th>"; // Rename, add or remove columns as you like.
		echo "<th>custid</th>";
    echo "</tr>";
while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
    extract($rad);
    echo "<tr>";

		// Here is the data added to the table
        echo "<td>{$name}</td>"; //Rename, add or remove columns as you like
		echo "<td>{$custid}</td>";
		echo "<td>";

		//Here are the buttons for update, delete and subscription plan.
		echo "<a href='updateUser.php?custid={$custid}' class='btn btn-primary m-r-1em'>Update</a>";// Replace with ID-variable, to make the buttons work
		echo "<a href='deleteUser.php?custid={$custid}' class='btn btn-danger'>Delete</a>";// Replace with ID-variable, to make the buttons work
		echo "<a href='subPlans.php?custid={$custid}' class='btn btn-primary'>Subtype</a>";// Replace with ID-variable, to make the buttons work
    echo "<a href='updateCard.php?custid={$custid}' class='btn btn-primary'>Credit Card</a>";// Replace with ID-variable, to make the buttons work
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
