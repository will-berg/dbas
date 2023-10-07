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
    $query = "SELECT subscriptionplan.card, card.ccn, card.cardtype, card.expirationdate, card.holdername
     FROM SubscriptionPlan
     JOIN Card ON subscriptionplan.card = card.cardid
     WHERE subscriptionplan.customer = :custid"; //Put query gathering the data here
    $stmt = $con->prepare( $query );

    $stmt->bindParam(':custid', $custid); //Binding ID for the query

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetching the data

    $ccn = $row['ccn'];
    $cardtype = $row['cardtype'];
    $expirationdate = $row['expirationdate'];
    $holdername = $row['holdername'];
	  $card = $row['card'];
}

catch(PDOException $exception) { //In case of error
    die('ERROR: ' . $exception->getMessage());
}


 if ($_POST) { //Has the form been submitted?
    try {
        $query = "UPDATE Card
                    SET ccn = :ccn, cardtype = :cardtype, expirationdate = :expirationdate, holdername = :holdername
                    WHERE card.cardid = :card"; //Put your query for updating data here

        $stmt = $con->prepare($query);

        $ccn=htmlspecialchars(strip_tags($_POST['ccn'])); //Rename, add or remove columns as you like
        $cardtype=htmlspecialchars(strip_tags($_POST['cardtype']));
        $expirationdate=htmlspecialchars(strip_tags($_POST['expirationdate']));
        $holdername=htmlspecialchars(strip_tags($_POST['holdername']));

        $stmt->bindParam(':card', $card); //Binding ID for the query
        $stmt->bindParam(':ccn', $ccn); //Binding parameters for query
        $stmt->bindParam(':expirationdate', $expirationdate);
        $stmt->bindParam(':holdername', $holdername);
        $stmt->bindParam(':cardtype', $cardtype);

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
                <td>CCN</td>
                <td><input type='text' name='ccn' value="<?php echo htmlspecialchars($ccn, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Cardtype</td>
                <td><input type='text' name='cardtype' value="<?php echo htmlspecialchars($cardtype, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>

            <tr>
                <td>Expiration Date</td>
                <td><input type='text' name='expirationdate' value="<?php echo htmlspecialchars($expirationdate, ENT_QUOTES);  ?>" class='form-control' /></td>
            </tr>

            <tr>
                <td>Holder Name</td>
                <td><input type='text' name='holdername' value="<?php echo htmlspecialchars($holdername, ENT_QUOTES);  ?>" class='form-control' /></td>
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
