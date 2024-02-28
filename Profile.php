<?php
    session_start();
    include "Classes.php";
    $user = AccountManager::FindByUsername($_SESSION["current_user"]);
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
    <h3><?php echo $user->Username; ?></h3>
    <b><?php echo $user->Birthday->diff(new DateTime())->y; ?> years</b><br>
    <p>My bio:</p>
    <b><?php echo $user->Bio; ?></b>
</body>
</html>