<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All users</title>
    <link rel="stylesheet" href="Other/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid row">
    <?php
    require("Classes.php");

    session_start();
    $users = AccountManager::GetDB();

    foreach ($users as $user) {
        echo "<div class='col-sm-6 col-lg-4 col-md-4 col-xl-3 border border-primary rounded p-3 m-3'><b>" . $user->Username . "</b><br><b>" . count($user->Friends) . " friends</b><br><b>Bio: " . $user->Bio . "</b><br><b>Birthday: " . $user->Birthday->format("Y.m.d") . "</b></div>";
    }
    ?>
    </div>
    <a href="Login.php">Log in</a>
</body>
</html>