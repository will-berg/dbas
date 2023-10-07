<?php
$mediaid=isset($_GET['mediaid']) ? $_GET['mediaid'] : die('ERROR: ID not found'); //Aquire the ID

include 'connection.php'; //Init the connection

try {
    $query = "DELETE FROM Media WHERE mediaid = :mediaid"; // Insert your DELETE query here
    $stmt = $con->prepare($query);
    $stmt->bindParam(':mediaid', $mediaid); //Binding the ID for the query

    if($stmt->execute()){
        header('Location: movies.php'); //Redirecting back to the main page
        echo "<div class='alert alert-success'>The movie was removed.</div>";
    }else{
        die('Could not remove'); //Something went wrong
    }
}

catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>