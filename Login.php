<?phph
include "Classes.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Other/bootstrap.min.css">
    <link rel="stylesheet" href="Other/style.css">
</head>
<body>
    <div class="container-fluid">
        <center>
            <div class="col-sm-8 col-md-5 col-lg-4 col-xl-3 border border-primary rounded p-3" id="MainForm">
                <form action="Server.php" method="post">
                    <label for="login">Login:</label>
                    <input type="text" id="login" name="login"><br>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password"><br>
                    <input type="submit" name="LogInAccount" id="LogInAccount" class="btn btn-success" value="Log in">&nbsp;
                    <input type="reset" class="btn btn-danger" value="Reset">
                </form>
                <a href="Registration.php"><button class="btn btn-primary">Registration</button></a>
            </div>
        </center>
    </div>
</body>
</html>