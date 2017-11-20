<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Account</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>

<div class="page-header col-md-offset-1">
    <h1>My Account</h1>
</div>
<?php
if ($_SESSION["type"] > 0 || $_SESSION["type"] < 0) { ?>

    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Account details</div>

            <ul class="list-group">

                <li class="list-group-item">
                    <div class="panel panel-default">
                        <div class="panel-heading">Username:</div>
                        <div class="panel-body"><?php echo $_SESSION['user']?></div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="panel panel-default">
                        <div class="panel-heading">Privilege Level:</div>
                        <div class="panel-body"><?php
                            if ($_SESSION['type'] == -1) {
                                echo "BANNED";
                            } elseif($_SESSION['type'] == 1){
                                echo "Normal user";
                            } elseif($_SESSION['type'] == 2){
                                echo "Moderator";
                            } elseif($_SESSION['type'] == 3){
                                echo "Admin";
                            }
                            ?></div>
                    </div>
                </li>
            </ul>



        </div>
    </div>
    <?php
} else { ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Not logged in!</div>
            <div class="panel-body">To view your account details, log in first.</div>
        </div>
    </div> <?php
}
?>


</body>
</html>