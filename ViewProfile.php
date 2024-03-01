<?php
session_start();
require_once "Classes.php";

$cur_user = AccountManager::FindByUsername($_SESSION["current_user"]);
$viewed_user = AccountManager::FindByUsername($_SESSION["viewed_user"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Other/bootstrap.min.css">
    <script src="Other/jquery-3.6.0.min.js"></script>
</head>
<body>
    <a href="Profile.php"><button class="btn btn-primary">Home</button></a>
    <h2><?php echo $viewed_user->Username; ?></h2>
    <form action="Server.php" method="post">
    <?php
    if($cur_user->AreFriends($viewed_user->Username))
    {
        echo <<<HTML
            <input type="submit" value="Remove friend" name="remove_friend" id="remove_friend">
            <input type="hidden" name="requesting_user" value="{$cur_user->Username}">
            <input type="hidden" name="accepting_user" value="{$viewed_user->Username}">
        HTML;
    }
    else{
        echo <<<HTML
            <input type="submit" value="Add friend" name="add_friend" id="add_friend">
            <input type="hidden" name="requesting_user" value="{$cur_user->Username}">
            <input type="hidden" name="accepting_user" value="{$viewed_user->Username}">
        HTML;
    }
    ?>
    </form>
    <script>
        $("#add_friend").attr("class", "btn btn-primary");
        $("#remove_friend").attr("class", "btn btn-danger");
        $("body").on("mouseenter", "#add_friend", function(){ $(this).attr("class", "btn btn-secondary"); });
        $("body").on("mouseleave", "#add_friend", function(){ $(this).attr("class", "btn btn-primary"); });
        $("body").on("mouseenter", "#remove_friend", function(){ $(this).attr("class", "btn btn-secondary"); });
        $("body").on("mouseleave", "#remove_friend", function(){ $(this).attr("class", "btn btn-danger"); });
    </script>
</body>
</html>