<!--Here is some styling HTML you don't need to pay attention to-->
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <div class="container">


        <!--Styling HTML ends and the real work begins below-->

<?php


$custid=isset($_GET['custid']) ? $_GET['custid'] : die('ERROR: Customer ID not found.'); //The parameter value from the click is aquired

include 'connection.php'; //Init the connection

try { //Aquire the already existing data
    $query = "SELECT subtype, subid FROM SubscriptionPlan WHERE customer = :custid"; //Put query gathering the data here
    $stmt = $con->prepare( $query );

    $stmt->bindParam(':custid', $custid); //Binding ID for the query

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC); //Fetching the data

    $subtype = $row['subtype'];
    //$subid = $row['subid'];
}

catch(PDOException $exception) { //In case of error
    die('ERROR: ' . $exception->getMessage());
}


if ($_POST) { //Has the form been submitted?
   try {
       $query = "UPDATE SubscriptionPlan SET subtype = :subtype WHERE subid = :subid";
                  //Put your query for updating data here

       $stmt = $con->prepare($query);

       $subtype=htmlspecialchars(strip_tags($_POST['subtype']));

       $stmt->bindParam(':subid', $subid);
       //$stmt->bindParam(':custid', $custid); //Binding ID for the query
       $stmt->bindParam(':subtype', $subtype);


       // Execute the query
       if ($stmt->execute()) {//Executes and check if correctly executed
           echo "<div class='alert alert-success'>Subtype was updated.</div>";
       } else {
           echo "<div class='alert alert-danger'>Unable to update subtype. Please try again.</div>";
       }
   }

   catch (PDOException $exception) { //In case of error
       die ('ERROR: ' . $exception->getMessage());
   }
}
?>

        <!-- The HTML-Form. Rename, add or remove columns for your update here -->
        <center>
            <h3>Update Subtype:</h3>
        </center>
        <div class="formdiv">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?custid={$custid}");?>" method="post">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td>Subtype</td>
                        <td><input type='text' name='name'
                                value="<?php echo htmlspecialchars($subtype, ENT_QUOTES);  ?>" class='form-control' />
                        </td>
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