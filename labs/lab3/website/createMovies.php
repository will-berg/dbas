<!--Here is some styling HTML you don't need to pay attention to-->
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
	<li class="nav-item">
		<a class="nav-link" href="movies.php">Movies</a>
	</li>
    <li class="nav-item">
		<a class="navbar-brand" href="createmovies.php">Add movie</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="users.php">Users</a> <!--Insert your own php-file here -->
    </li>
    <li class="nav-item">
      <a class="nav-link" href="checkUsers.php">Profiles</a> <!--Insert your own php-file here -->
    </li>
  </ul>
</nav>
</div>

<!--Styling HTML ends and the real work begins below-->
<?php

include 'connection.php'; //Init a connection

if($_POST){


    try {
        $query = "INSERT INTO Media(name,year,country,director,genre,length,rating) VALUES (:name,:year,:country,:director,:genre,:length,:rating)"; // Put query inserting data to table here

        $stmt = $con->prepare($query); // prepare query for execution

        $name=htmlspecialchars(strip_tags($_POST['name']));
        $year=htmlspecialchars(strip_tags($_POST['year']));
        $country=htmlspecialchars(strip_tags($_POST['country']));
        $director=htmlspecialchars(strip_tags($_POST['director']));
        $genre=htmlspecialchars(strip_tags($_POST['genre']));
        $length=htmlspecialchars(strip_tags($_POST['length']));
        $rating=htmlspecialchars(strip_tags($_POST['rating']));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':country', $country);
	    $stmt->bindParam(':director', $director);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':length', $length);
        $stmt->bindParam(':rating', $rating);



        if($stmt->execute()){ //Executes and check if correctly executed
            echo "<div class='alert alert-success'>Record was saved.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }
    }
    catch(PDOException $exception){ //In case of error
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

<!-- The HTML-Form. Rename, add or remove columns for your insert here -->
<center><h3>Input movie information below:</h3></center>
<div class="formdiv">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Name</td>
                <td><input type='text' name='name' class='form-control' /></td>
            </tr>
            <tr>
                <td>Year</td>
                <td><input type='number' name='year' class='form-control'/></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><input type='text' name='country' class='form-control' /></td>
            </tr>
            <tr>
                <td>Director</td>
                <td><input type='number' name='director' class='form-control' /></td>
            </tr>
            <tr>
                <td>Genre</td>
                <td><input type='text' name='genre' class='form-control' /></td>
            </tr>
            <tr>
                <td>Length</td>
                <td><input type='number' name='length' class='form-control' /></td>
            </tr>
            <tr>
                <td>Rating</td>
                <td><input type='number' name='rating' class='form-control' /></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Save' class='btn btn-primary' />
                    <a href='movies.php' class='btn btn-danger'>Go back</a>
                </td>
            </tr>
        </table>
    </form>
</div>
</div>
</html>
