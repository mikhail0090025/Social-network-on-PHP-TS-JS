<?php
    session_start();
    require_once "Classes.php";
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
    <script src="Other\jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="MainBlock" class="p-5 md-5">
        <div id="TopBlock">
            <h3><?php echo $user->Username; ?></h3>
            <b><?php echo $user->Birthday->diff(new DateTime())->y; ?> years</b><br>
            <b>My bio:</b>
            <p><?php echo $user->Bio; ?></p><br>
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
        </div>
    <br>
        <div class="container-fluid">
            <div id="friends" class="border border-success rounded p-2 col-sm-5 col-lg-4 col-md-4 col-xl-3">
                <h4>My friends: </h4>
                <?php
                    foreach($user->Friends as $friend){
                        echo <<<HTML
                        <div class='border border-primary rounded p-2 md-2'><h5>{$friend}</h5>
                            <form action='Server.php' method='post'>
                                <input type="hidden" name="username" value="{$friend}">
                                <input type="submit" name="view_page" id="view_page" value="View page" class="btn btn-primary">
                            </form>
                        </div>
                        HTML;
                    }
                    echo <<<HTML
                    <form action='Server.php' method='post'>
                        <input type="hidden" name="username" value="{$user->Username}">
                        <input type="submit" name="remove_all_friends" id="remove_all_friends" value="Remove ALL friends" class="btn btn-danger">
                    </form>
                    HTML;
                ?>
            </div>
            <div id="SearchNewPeopleBlock" class="border border-success rounded p-2 col-sm-5 col-lg-4 col-md-4 col-xl-3">
                <h3>Search new people</h3>
                <form action="Server.php" method="get" class="form-inline">
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="text" name="username_to_search" id="username_to_search" placeholder="Write username..." class="form-control">
                        <input type="submit" value="Search..." class="btn btn-primary mb-2" name="search_user_by_name">
                    </div>
                </form>
                <div id="results">
                    <?php
                    if(isset($_SESSION["found_users"], $_SESSION["found_users"]["status"], $_SESSION["found_users"]["data"])){
                        if($_SESSION["found_users"]["status"] == false){
                            //echo serialize($_SESSION["found_users"]);
                            echo "<p><b>User " . $_SESSION["found_users"]["data"] . " was not found</b></p>";
                        }
                        else{
                            //echo serialize($_SESSION["found_users"]);
                            $unserializedData = unserialize($_SESSION["found_users"]["data"]);
                            echo <<<HTML
                            <div class='border rounded border-primary p-3'>
                                <p><b>{$unserializedData->Username}</b></p>
                                <p>{$unserializedData->Birthday->diff(new DateTime())->y} years</p>
                                <p>{$unserializedData->Bio}</p>
                                <form action='Server.php' method='post'>
                                    <input type="hidden" name="username" value="{$unserializedData->Username}">
                                    <input type="submit" name="view_page" id="view_page" value="View page" class="btn btn-primary">
                                </form>
                            </div>
                            HTML;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <a href="AllUsers.php"><button class="btn btn-success">All users</button></a>
    <script src="Profile.js"></script>
</body>
</html>