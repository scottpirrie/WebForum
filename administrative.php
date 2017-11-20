<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>

<div class="page-header col-md-offset-1">
    <h1>Administrative</h1>
</div>

<?php
if ($_SESSION['type'] > 1) {

    if (isset($_POST['clearLogin'])) {

        $sql = "DELETE FROM `Login` WHERE username <> 'admin'";
        $res = $conn->query($sql);

        if ($res) {
            ?>
            <div class="alert alert-warning">
                <strong>User accounts wiped.</strong> (Except 'admin')
            </div>
        <?php } else {

            ?>
            <div class="alert alert-danger">
                <strong>Failed to wipe user accounts; try again later.</strong>
            </div>
            <?php


        }


    } elseif (isset($_POST['clearThreads'])) {


        $sql = "DELETE FROM `Threads`";
        $conn->query($sql);
        $sql = "DELETE FROM `Posts`";
        $res = $conn->query($sql);

        if ($res) {
            ?>
            <div class="alert alert-warning">
                <strong>Threads and posts wiped.</strong>
            </div>
        <?php } else {

            ?>
            <div class="alert alert-danger">
                <strong>Failed to wipe threads; try again later.</strong>
            </div>
            <?php

        }


    } elseif (isset($_POST['assign'])) {


    }


    ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Admin Commands</div>
            <ul class="list-group">

                <li class="list-group-item">
                    <div class="panel panel-default">
                        normal commands here

                    </div>
                </li>
                <li class="list-group-item">
                    <div class="panel panel-danger">
                        <div class="panel-heading">NUCLEAR COMMANDS:</div>
                        <div class="panel-body">


                            <form class="form" method="POST" action="administrative.php"
                                  name="clearLoginDB">
                                <div class="form-group">
                                    <label class="col-md-4 col-form-label" for="clearLogin">Delete all
                                        accounts:</label>
                                    <input title="Delete ALL accounts (excluding 'admin')"
                                           class="btn btn-danger"
                                           type="submit" name="clearLogin" id="clearLogin"
                                           value="Clear Accounts DB">
                                </div>
                            </form>

                            <div class="verticalSpacer"></div>


                            <form method="POST" action="administrative.php" class="form" name="clearThreads">
                                <div class="form-group">
                                    <label class="col-md-4 col-form-label" for="clearThreads">Delete all
                                        threads/posts:</label>
                                    <input title="Delete ALL threads and posts therein." class="btn btn-danger"
                                           type="submit" name="clearThreads" id="clearThreads"
                                           value="Clear All Threads DB">
                                </div>
                            </form>

                        </div>


                    </div>

                </li>
            </ul>


        </div>
    </div>

    <form method="POST" action="administrative.php" class="form" name="assignRank">


        <input class="form-control" id="username" type=text name="target"
               required>

        <input class="form-control" id="passToBe" type=password name="newPassword" minlength="4"
               maxlength="15" required>


        <input class="btn btn-primary" type="submit" name="assign" value="Assign Rank">

    </form>

<?php } else { ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Access Denied!</div>
            <div class="panel-body">You aren't supposed to be here.</div>
        </div>
    </div>

    <?php
}

?>
</body>
</html>