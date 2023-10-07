<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>

<head>
    <title>LMS movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <div class="container">

        <!--Styling HTML ends and the real work begins below-->


        <?php

$mediaid=isset($_GET['mediaid']) ? $_GET['mediaid'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired

include 'connection.php';

try {
    $query = "SELECT media.mediaid, media.name, media.year, media.country, directors.name AS director, string_agg(actors.name, ', ') AS actors,
    media.genre, media.length, media.rating, media.dateadded
    FROM Media
    JOIN Directors ON directors.directorid = media.director
    JOIN MediaActors ON mediaactors.movie = media.mediaid
    JOIN Actors ON actors.actorid = mediaactors.actor
    WHERE media.mediaid = :mediaid
    GROUP BY mediaid, media.name, country, directors.name, genre, length, media.rating, dateadded"; // Put query fetching data from table here

    $stmt = $con->prepare( $query );

    $stmt->bindParam(':mediaid', $mediaid); //Bind the ID for the query

    $stmt->execute(); //Execute query

    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetchs data

    $mediaid = $row['mediaid'];
    $name = $row['name']; //Store data. Rename, add or remove columns as you like.
	$year = $row['year'];
	$country = $row['country'];
	$director = $row['director'];
	$genre = $row['genre'];
	$length = $row['length'];
	$rating = $row['rating'];
	$dateadded = $row['dateadded'];
  $actors = $row['actors'];

}


catch(PDOException $exception){ //In case of error
    die('ERROR: ' . $exception->getMessage());
}
?>
        <!-- Here is how we display our data. Rename, add or remove columns as you like-->
        <center>
            <h2>Movie Information:</h2>
            <div class="formdiv">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Name</td>
                        <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                    </tr>

                    <tr>
                        <td>mediaid</td>
                        <td><?php echo htmlspecialchars($mediaid, ENT_QUOTES);  ?></td>
                    </tr>

                    <tr>
                        <td>year</td>
                        <td><?php echo htmlspecialchars($year, ENT_QUOTES);  ?></td>
                    </tr>

                    <tr>
                        <td>country</td>
                        <td><?php echo htmlspecialchars($country, ENT_QUOTES);  ?></td>
                    </tr>

                    <tr>
                        <td>director</td>
                        <td><?php echo htmlspecialchars($director, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>actors</td>
                        <td><?php echo htmlspecialchars($actors, ENT_QUOTES);  ?></td>
                    </tr>

                    <tr>
                        <td>genre</td>
                        <td><?php echo htmlspecialchars($genre, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>length</td>
                        <td><?php echo htmlspecialchars($length, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>rating</td>
                        <td><?php echo htmlspecialchars($rating, ENT_QUOTES);  ?></td>
                    </tr>
                    <tr>
                        <td>dateadded</td>
                        <td><?php echo htmlspecialchars($dateadded, ENT_QUOTES);  ?></td>
                    </tr>






                    <tr>
                        <td></td>
                        <td>
                            <a href='movies.php' class='btn btn-danger'>Back to read products</a>
                        </td>
                    </tr>
                </table>
            </div>
</body>

</html>