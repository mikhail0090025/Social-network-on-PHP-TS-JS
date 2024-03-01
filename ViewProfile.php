<?php
session_start();
$cur_user = AccountManager::FindByUsername($_SESSION["current_user"]);
$viewed_user = AccountManager::FindByUsername($_SESSION["viewed_user"]);
require_once "Classes.php";
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
    <h2><?php echo $viewed_user->Username; ?></h2>
    <?php
    if($viewed_user->AreFriends($cur_user))
    {
        echo "<p><b>You are friends</b></p>";
    }
    else{
        echo <<<HTML
        <form action="Server.php" method="post">
            <input type="submit" value="Add friend" name="add_friend" id="add_friend">
        </form>
        HTML;
    }
    ?>
    <script>
        $("body").on("mouseenter", "#add_friend", function(){});
    </script>
</body>
</html>