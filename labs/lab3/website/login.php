<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="loginstyle.css">
</head>
<body>
    <div id="frm">
        <form action="checkLogin.php" method="POST">
            <center>
            <p>
                <input type="text" id="email" placeholder="Enter email here" name="email"/>
            </p>
                <input type="password" id="psw" placeholder="Enter password here" name="psw"/>
            <p>
                <input type="submit" id="btn" value="login"/>
            </p>
            </center>
        </form>
    </div>
</body>
</html>
