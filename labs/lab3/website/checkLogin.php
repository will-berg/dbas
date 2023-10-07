<?php


$email = $_POST['email'];
$psw = $_POST['psw'];


include 'connection.php'; //Always include connection when handling the database

try {
    $query = "SELECT * FROM Customers WHERE email = :email";

    $stmt = $con->prepare( $query );

    $stmt->bindParam(':email', $email);

    $stmt->execute(); //Execute query

    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetchs data
    if ($row['password'] != $psw || $row['email'] != $email) {
        echo "<script> window.location.assign('login.php'); </script>";
    } else {
        session_start();
        $_SESSION['customerID'] = $row['custid'];
        echo "<script> window.location.assign('checkUsers.php'); </script>";
    }
}

catch(PDOException $exception) { //In case of error
    die('ERROR: ' . $exception->getMessage());
}

?>
