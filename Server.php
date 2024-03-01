
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server page</title>
</head>
<body>
    <h2>Server page</h2>
    <p>This is server page. You have to be redirected from it in several seconds. If you stay here for a long time, it seems to be an error.</p>
    <a href="Profile.php">Back to profile</a>
<?php
session_start();
require_once "Classes.php";

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

// Change bio
if(isset($_POST["ChangeBio"])){
    $new_bio = $_POST["new_bio"];
    $cur_user = AccountManager::FindByUsername($_SESSION["current_user"]);
    $cur_user->Bio = $new_bio;
    AccountManager::UpdateUser($cur_user);
    echo "<script>window.location.href = 'Profile.php';</script>";
}

// Search users
if(isset($_GET["search_user_by_name"])){
    $username = $_GET["username_to_search"];
    try{
        $result = AccountManager::FindByUsername($username);
        $_SESSION["found_users"] = ["status" => true, "data" => serialize($result)];
    }
    catch(Throwable $th){
        $_SESSION["found_users"] = ["status" => false, "data" => $username];
    }
    echo "<script>window.location.href = 'Profile.php';</script>";
}

// View some user
if(isset($_POST["view_page"])){
    $username = $_POST["username"];
    $_SESSION["viewed_user"] = $username;
    echo "<script>window.location.href = 'ViewProfile.php';</script>";
}

//Add friend
if(isset($_POST["add_friend"])){
    $requesting_user = AccountManager::FindByUsername($_POST["requesting_user"]);
    $accepting_user = AccountManager::FindByUsername($_POST["accepting_user"]);

    $requesting_user->AddFriend($accepting_user->Username);
    echo "<script>window.location.href = 'ViewProfile.php';</script>";
}

//Remove friend
if(isset($_POST["remove_friend"])){
    $requesting_user = AccountManager::FindByUsername($_POST["requesting_user"]);
    $accepting_user = AccountManager::FindByUsername($_POST["accepting_user"]);

    $requesting_user->RemoveFriend($accepting_user->Username);
    echo "<script>window.location.href = 'ViewProfile.php';</script>";
}

//Remove all friends
if(isset($_POST["remove_all_friends"])){
    $requesting_user = AccountManager::FindByUsername($_POST["username"]);

    $requesting_user->Friends = [];
    AccountManager::UpdateUser($requesting_user);
    echo "<script>window.location.href = 'Profile.php';</script>";
}
?>
</body>
</html>