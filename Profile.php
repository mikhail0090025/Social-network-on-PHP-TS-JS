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
    <b><?php echo $user->Bio; ?></b><br>
    <button id="change_bio_button" class="btn btn-primary">Change bio</button>
    <div class="container-fluid">
        <div id="change_bio_form" class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <form action="Server.php" method="post">
                <label for="new_bio">Write your new bio</label>
                <textarea name="new_bio" id="new_bio" cols="30" rows="6">
                    <?php echo $user->Bio; ?>
                </textarea>
                <input type="submit" value="Change bio" name="ChangeBio" id="ChangeBio" class="btn btn-primary">
            </form>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <div id="friends" class="border border-success rounded p-2 col-sm-5 col-lg-4 col-md-4 col-xl-3">
            <h4>My friends: </h4>
            <?php
                foreach($user->Friends as $friend){
                    echo "<div class='border border-primary rounded p-2 md-2'><h5>" . $friend->Username . "</h5></div>";
                }
            ?>
        </div>
        <div id="SearchNewPeopleBlock" class="border border-success rounded p-2 col-sm-5 col-lg-4 col-md-4 col-xl-3">
            <h3>Search new people</h3>
            <form action="Server.php" method="get">
                <input type="text" placeholder="Enter username..." name="username"><br><br>
                <input type="submit" value="Search..." class="btn btn-success" name="search_user">
                <div id="results"><?php
                if(isset($_SESSION["found_users"])){
                    if($_SESSION["found_users"] == false){
                        echo "<p>Users were not found</p>";
                    }else{
                        echo "<b>" . $_SESSION["found_users"]->Username . "</b>";
                    }
                }
                ?></div>
            </form>
        </div>
    </div>
    <a href="AllUsers.php"><button class="btn btn-success">All users</button></a>
    <script src="Profile.js"></script>
</body>
</html>