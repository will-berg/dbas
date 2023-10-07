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


$listentryid=isset($_GET['listentryid']) ? $_GET['listentryid'] : die('ERROR: Record ID not found.'); //The parameter value from the click is aquired

include 'connection.php'; //Init the connection

try { //Aquire the already existing data
    $query = "SELECT rating FROM Watchlist WHERE listentryid = :listentryid"; //Put query gathering the data here
    $stmt = $con->prepare( $query );

    $stmt->bindParam(':listentryid', $listentryid); //Binding ID for the query

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetching the data

	  $rating = $row['rating'];
}

catch(PDOException $exception) { //In case of error
    die('ERROR: ' . $exception->getMessage());
}


 if ($_POST) { //Has the form been submitted?
    try {
        $query = "UPDATE Watchlist
                    SET rating = :rating
                    WHERE listentryid = :listentryid"; //Put your query for updating data here

        $stmt = $con->prepare($query);

        $rating=htmlspecialchars(strip_tags($_POST['rating']));

        $stmt->bindParam(':listentryid', $listentryid); //Binding ID for the query
        $stmt->bindParam(':rating', $rating);

        // Execute the query
        if ($stmt->execute()) {//Executes and check if correctly executed
            echo "<div class='alert alert-success'>Rating was updated.</div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to update rating. Please try again.</div>";
        }
    }

    catch (PDOException $exception) { //In case of error
        die ('ERROR: ' . $exception->getMessage());
    }
}
?>

<!-- The HTML-Form. Rename, add or remove columns for your update here -->
<center><h3>Update rating:</h3></center>
<div class="formdiv">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?listentryid={$listentryid}");?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Rating</td>
                <td><input type='number' name='rating' value="<?php echo htmlspecialchars($rating, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Save Changes' class='btn btn-primary' />
                    <a href='checkUsers.php' class='btn btn-danger'>Back to profiles</a>
                </td>
            </tr>
        </table>
    </form>
</div>
</div>
</body>
</html>
