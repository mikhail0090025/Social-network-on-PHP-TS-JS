<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="Other/bootstrap.min.css">
    <link rel="stylesheet" href="Other/style.css">
</head>
<body>
    <div class="container-fluid">
        <center>
            <div class="col-sm-8 col-md-5 col-lg-4 col-xl-3 border border-primary rounded p-3" id="MainForm">
                <form action="Server.php" method="post">
                    <label for="login">Come up with new login:</label>
                    <input type="text" id="login" name="login" required value="user111"><br>
                    <label for="password">Come up with new password:</label>
                    <input type="password" name="password" id="password" required value="MyPassword123"><br>
                    <label for="password">Confirm password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required value="MyPassword123"><br>
                    <label for="birthday">Write your birthday:</label>
                    <input type="datetime" name="birthday" id="birthday" required value="2001-02-12"><br>
                    <input type="submit" name="Registrate" id="Registrate" value="Registrate" class="btn btn-success">
                    <input type="reset" class="btn btn-danger" value="Reset">
                </form>
            </div>
        </center>
    </div>
</body>
</html>