<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <div class="container">
        <div class="page-header">
            <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
                <a class="navbar-brand" href="movies.php">Movies</a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="createmovies.php">Add movie</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                        <!--Insert your own php-file here -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="checkUsers.php">Profiles</a>
                        <!--Insert your own php-file here -->
                    </li>
                </ul>
            </nav>
        </div>



        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='keyword1' class='form-control' /></td>

                    <td>Actors</td>
                    <td><input type='text' name='keyword1' class='form-control' /></td>

                    <td>Year</td>
                    <td><input type='text' name='keyword3' class='form-control' /></td>

                    <td>Country</td>
                    <td><input type='text' name='keyword4' class='form-control' /></td>

                    <td>Director</td>
                    <td><input type='text' name='keyword5' class='form-control' /></td>

                    <td>Genre</td>
                    <td><input type='text' name='keyword6' class='form-control' /></td>

                    <td>Length</td>
                    <td><input type='text' name='keyword7' class='form-control' /></td>

                    <td>Rating</td>
                    <td><input type='text' name='keyword8' class='form-control' /></td>

                    <td><input type='submit' name='submit' value='Find' /></td>
                </tr>
            </table>
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>

                </tr>
            </table>
        </form>



        <!--Styling HTML ends and the real work begins below-->

        <?php


include 'connection.php'; //Init a connection


$query = "SELECT media.mediaid, media.name, media.year, media.country, directors.name AS director,
media.genre, media.length, media.rating, CASE count(actors.name) WHEN 0 THEN '' ELSE string_agg(actors.name, ', ') END AS actors
FROM Media
JOIN Directors ON directors.directorid = media.director
FULL OUTER JOIN MediaActors ON mediaactors.movie = media.mediaid
FULL OUTER JOIN Actors ON actors.actorid = mediaactors.actor
WHERE LOWER(media.name) LIKE LOWER(:keyword1)
AND LOWER(actors.name) LIKE LOWER(:keyword2)
AND LOWER(genre) LIKE LOWER(:keyword6)
AND CAST(year AS TEXT) LIKE :keyword3
AND LOWER(country) LIKE LOWER(:keyword4)
AND LOWER(directors.name) LIKE LOWER(:keyword5)
AND CAST(length AS TEXT) LIKE :keyword7
AND CAST(rating AS TEXT) LIKE :keyword8
GROUP BY media.name, media.country, directors.name, media.genre, media.length, media.rating, media.year, media.mediaid";

$stmt = $con->prepare($query);
$keyword1= isset($_POST['keyword1']) ? $_POST['keyword1'] : ''; //Is there any data sent from the form?

$keyword1 = "%".$keyword1."%";
$stmt->bindParam(':keyword1', $keyword1);

$keyword2= isset($_POST['keyword2']) ? $_POST['keyword2'] : ''; //Is there any data sent from the form?

$keyword2 = "%".$keyword2."%";
$stmt->bindParam(':keyword2', $keyword2);

$keyword3= isset($_POST['keyword3']) ? $_POST['keyword3'] : ''; //Is there any data sent from the form?

$keyword3 = "%".$keyword3."%";
$stmt->bindParam(':keyword3', $keyword3);

$keyword4= isset($_POST['keyword4']) ? $_POST['keyword4'] : ''; //Is there any data sent from the form?

$keyword4 = "%".$keyword4."%";
$stmt->bindParam(':keyword4', $keyword4);

$keyword5= isset($_POST['keyword5']) ? $_POST['keyword5'] : ''; //Is there any data sent from the form?

$keyword5 = "%".$keyword5."%";
$stmt->bindParam(':keyword5', $keyword5);

$keyword6= isset($_POST['keyword6']) ? $_POST['keyword6'] : ''; //Is there any data sent from the form?

$keyword6 = "%".$keyword6."%";
$stmt->bindParam(':keyword6', $keyword6);

$keyword7= isset($_POST['keyword7']) ? $_POST['keyword7'] : ''; //Is there any data sent from the form?

$keyword7 = "%".$keyword7."%";
$stmt->bindParam(':keyword7', $keyword7);

$keyword8= isset($_POST['keyword8']) ? $_POST['keyword8'] : ''; //Is there any data sent from the form?

$keyword8 = "%".$keyword8."%";
$stmt->bindParam(':keyword8', $keyword8);

$stmt->execute();

$num = $stmt->rowCount(); //Aquire number of rows

if($num>0){ //Is there any data/rows?
    echo "<table class='table table-responsive table-fix table-bordered'><thead class='thead-light'>";
    echo "<tr>";
        echo "<th>name</th>"; // Rename, add or remove columns as you like.
		echo "<th>mediaid</th>";
    echo "</tr>";
while ($rad = $stmt->fetch(PDO::FETCH_ASSOC)){ //Fetches data
    extract($rad);
    echo "<tr>";

		// Here is the data added to the table
        echo "<td>{$name}</td>"; //Rename, add or remove columns as you like
		echo "<td>{$mediaid}</td>";
		echo "<td>";

		//Here are the buttons for update, delete and read.
		echo "<a href='readMovies.php?mediaid={$mediaid}'class='btn btn-info m-r-1em'>Read</a>"; // Replace with ID-variable, to make the buttons work
		echo "<a href='updateMovies.php?mediaid={$mediaid}' class='btn btn-primary m-r-1em'>Update</a>";// Replace with ID-variable, to make the buttons work
		echo "<a href='deleteMovies.php?mediaid={$mediaid}' class='btn btn-danger'>Delete</a>";// Replace with ID-variable, to make the buttons work
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