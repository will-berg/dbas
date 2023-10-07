<?php
$custid=isset($_GET['custid']) ? $_GET['custid'] : die('ERROR: ID not found'); //Aquire the ID

include 'connection.php'; //Init the connection

try {
    $query = "DELETE FROM Customers WHERE customer = :custid"; // Insert your DELETE query here
    $stmt = $con->prepare($query);
    $stmt->bindParam(':custid', $custid); //Binding the ID for the query

    if($stmt->execute()){
        header('Location: users.php'); //Redirecting back to the main page
        echo "<div class='alert alert-success'>The user was removed.</div>";
    }else{
        die('Could not remove'); //Something went wrong
    }
}

catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>