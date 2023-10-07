<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE HTML>
<html>
<head>
    <title>Update User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div class="container">


<!--Styling HTML ends and the real work begins below-->
<?php


$custid=isset($_GET['custid']) ? $_GET['custid'] : die('ERROR: Customer ID not found.'); //The parameter value from the click is aquired

include 'connection.php'; //Init the connection

try { //Aquire the already existing data
    $query = "SELECT name, email, phonenumber, address FROM Customers WHERE custid = :custid"; //Put query gathering the data here
    $stmt = $con->prepare( $query );

    $stmt->bindParam(':custid', $custid); //Binding ID for the query

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetching the data

    $name = $row['name']; //Rename, add or remove columns as you like
	$email = $row['email'];
	$phonenumber = $row['phonenumber'];
	$address = $row['address'];
}

catch(PDOException $exception) { //In case of error
    die('ERROR: ' . $exception->getMessage());
}


 if ($_POST) { //Has the form been submitted?
    try {
        $query = "UPDATE Customers
                    SET name = :name, email = :email, phonenumber = :phonenumber, address = :address
                    WHERE customers.custid = :custid"; //Put your query for updating data here

        $stmt = $con->prepare($query);

        $name=htmlspecialchars(strip_tags($_POST['name'])); //Rename, add or remove columns as you like
        $email=htmlspecialchars(strip_tags($_POST['email']));
        $phonenumber=htmlspecialchars(strip_tags($_POST['phonenumber']));
        $address=htmlspecialchars(strip_tags($_POST['address']));

        $stmt->bindParam(':custid', $custid); //Binding ID for the query
        $stmt->bindParam(':name', $name); //Binding parameters for query
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phonenumber', $phonenumber);
        $stmt->bindParam(':address', $address);

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
<center><h3>Update Customer Information:</h3></center>
<div class="formdiv">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?custid={$custid}");?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Name</td>
                <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type='text' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>

            <tr>
                <td>Phone Number</td>
                <td><input type='text' name='phonenumber' value="<?php echo htmlspecialchars($phonenumber, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>

            <tr>
                <td>Address</td>
                <td><input type='text' name='address' value="<?php echo htmlspecialchars($address, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Save Changes' class='btn btn-primary' />
                    <a href='users.php' class='btn btn-danger'>Back to users</a>
                </td>
            </tr>
        </table>
    </form>
</div>
</div>
</body>
</html>
