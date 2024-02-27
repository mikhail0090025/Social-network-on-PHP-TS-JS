
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server page</title>
</head>
<body>
<?php
session_start();
include "Classes.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Logging into account
if(isset($_POST["LogInAccount"], $_POST["login"], $_POST["password"])){
    try{
        $user = AccountManager::FindByUsername($_POST["login"]);
        echo "<script>alert(" . serialize($user) . ");</script>";
        if(password_verify($_POST["password"], $user->EncryptedPassword)) {
            $_SESSION["current_user"] = $_POST["login"];
            header("Location: Profile.php");
            exit();
        }
        else{
            echo "<p>Password is incorrect</p>";
        }
    }
    catch(Exception $ex){
        echo "<p>Account was not found</p>";
    }
}
// Creating new account
if(isset($_POST["Registrate"])){
    $login = $_POST["login"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];
    $birthday = $_POST["birthday"];
    if($password != $password_confirmation){
        echo "<p>Passwords do not match!</p>";
        return;
    }
    if(AccountManager::UsernameIsFree($login)){
        $new_user = new User($login, password_hash($password, 0), new DateTime($birthday), "");
        AccountManager::AddUser($new_user);
        echo "<p>User was added successfully</p>";
    }
    else {
        echo "<p>Username " . $login . " is not free. Try another username</p>";
    }
}
?>    
</body>
</html>