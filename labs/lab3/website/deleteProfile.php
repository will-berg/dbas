<?php
$upid=isset($_GET['upid']) ? $_GET['upid'] : die('ERROR: ID not found'); //Aquire the ID

include 'connection.php'; //Init the connection

try {
    $query = "DELETE FROM Userprofiles WHERE upid = :upid"; // Insert your DELETE query here
    $stmt = $con->prepare($query);
    $stmt->bindParam(':upid', $upid); //Binding the ID for the query

    if($stmt->execute()){
        echo "<div class='alert alert-success'>The profile was removed.</div>";
        header('Location: checkUsers.php'); //Redirecting back to the main page

    }else{
        die('Could not remove'); //Something went wrong
    }
}

catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>
