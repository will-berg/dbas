<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>
<head>
    <title>Update movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div class="container">


<!--Styling HTML ends and the real work begins below-->
<?php


$mediaid=isset($_GET['mediaid']) ? $_GET['mediaid'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired

include 'connection.php'; //Init the connection

try { //Aquire the already existing data
    $query = "SELECT name, year, country, director, genre, length, rating FROM Media WHERE mediaid = :mediaid"; //Put query gathering the data here
    $stmt = $con->prepare( $query );

    $stmt->bindParam(':mediaid', $mediaid); //Binding ID for the query

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetching the data

    $name = $row['name']; //Rename, add or remove columns as you like
	$year = $row['year'];
	$country = $row['country'];
	$director = $row['director'];
	$genre = $row['genre'];
	$length = $row['length'];
	$rating = $row['rating'];
}

catch(PDOException $exception) { //In case of error
    die('ERROR: ' . $exception->getMessage());
}


 if ($_POST) { //Has the form been submitted?
    try {
        $query = "UPDATE Media
                    SET name = :name, year = :year, country = :country, director = :director, genre = :genre, length = :length, rating = :rating
                    WHERE media.mediaid = :mediaid"; //Put your query for updating data here

        $stmt = $con->prepare($query);

        $name=htmlspecialchars(strip_tags($_POST['name'])); //Rename, add or remove columns as you like
        $year=htmlspecialchars(strip_tags($_POST['year']));
        $country=htmlspecialchars(strip_tags($_POST['country']));
        $director=htmlspecialchars(strip_tags($_POST['director']));
        $genre=htmlspecialchars(strip_tags($_POST['genre']));
        $length=htmlspecialchars(strip_tags($_POST['length']));
        $rating=htmlspecialchars(strip_tags($_POST['rating']));

        $stmt->bindParam(':mediaid', $mediaid); //Binding ID for the query
        $stmt->bindParam(':name', $name); //Binding parameters for query
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':director', $director);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':length', $length);
        $stmt->bindParam(':rating', $rating);

        // Execute the query
        if ($stmt->execute()) {//Executes and check if correctly executed
            echo "<div class='alert alert-success'>Record was updated.</div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
        }
    }

    catch (PDOException $exception) { //In case of error
        die ('ERROR: ' . $exception->getMessage());
    }
}
?>

<!-- The HTML-Form. Rename, add or remove columns for your update here -->
<center><h3>Update Movie Information:</h3></center>
<div class="formdiv">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?mediaid={$mediaid}");?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Name</td>
                <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Year</td>
                <td><input type='number' name='year' value="<?php echo htmlspecialchars($year, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><input type='text' name='country' value="<?php echo htmlspecialchars($country, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>

            <tr>
                <td>Director</td>
                <td><input type='number' name='director' value="<?php echo htmlspecialchars($director, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>

            <tr>
                <td>Genre</td>
                <td><input type='text' name='genre' value="<?php echo htmlspecialchars($genre, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Length</td>
                <td><input type='number' name='length' value="<?php echo htmlspecialchars($length, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Rating</td>
                <td><input type='number' name='rating' value="<?php echo htmlspecialchars($rating, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Save Changes' class='btn btn-primary' />
                    <a href='movies.php' class='btn btn-danger'>Back to read products</a>
                </td>
            </tr>
        </table>
    </form>
</div>
</div>
</body>
</html>
