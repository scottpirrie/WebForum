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

    $sql = "DELETE FROM `Login` WHERE type < 3";
    $res = $conn->query($sql);

if ($res) {
    ?>
    <div class="alert alert-warning">
        <strong>User accounts wiped.</strong> (Except Admins)
    </div>
<?php } else {

    ?>
    <div class="alert alert-danger">
        <strong>Failed to wipe user accounts; try again later.</strong>
    </div>
<?php


}


} elseif (isset($_POST['clearThreads'])) {

    $success = true;

    $sql = "DELETE FROM `Threads`";
    $res = $conn->query($sql);
    if (!$res) {
        $success = false;
    }

    $sql = "DELETE FROM `Posts`";
    $res = $conn->query($sql);
    if (!$res) {
        $success = false;
    }

    $sql = "DELETE FROM `Topics`";
    $res = $conn->query($sql);
    if (!$res) {
        $success = false;
    }

    if ($success) {
    ?>
        <div class="alert alert-warning">
            <strong>Topics, Threads and Posts wiped.</strong>
        </div>
    <?php } else {

        ?>
        <div class="alert alert-danger">
            <strong>Failed to wipe topics and contents; try again later.</strong>
        </div>
    <?php

    }
} elseif (isset($_POST['assign'])) {

$targetUsername = isset($_POST['targetUsername']) ? $_POST['targetUsername'] : "";
$targetRank = isset($_POST['selectPower']) ? $_POST['selectPower'] : "";

$targetUsername = cleanStr($targetUsername, $conn);
$successfulPrivilegeChange = false;
$targetUserExists = true;
if (strtoupper($targetUsername) == "ADMIN") {
?>
    <div class="alert alert-danger">
        <strong>Admin is too stronk.</strong>
    </div><?php
} else {
    $sql = "SELECT * FROM `Login` WHERE username = '$targetUsername'";
    $resultSelect = $conn->query($sql);

    if ($resultSelect->num_rows > 0) {
        $sql = "UPDATE `Login` SET `type`= $targetRank WHERE username = '$targetUsername'";
        $resultUpdate = $conn->query($sql);

        if ($resultUpdate) {
            $successfulPrivilegeChange = true;
        }
    } else {
        $targetUserExists = false;
    }


    if ($targetRank == -1) {
        $targetRank = "BANNED";
    } elseif ($targetRank == 1) {
        $targetRank = "Normal";
    } elseif ($targetRank == 2) {
        $targetRank = "Moderator";
    }

if ($successfulPrivilegeChange) { ?>

    <div class="alert alert-success">
        <strong>Specified user '<?php echo $_POST['targetUsername']?>' was changed to '<?php echo $targetRank?>'.</strong>
    </div>
<?php } else {

    ?>
    <div class="alert alert-danger">
        <strong>Failed to change rank of '<?php echo $_POST['targetUsername']?>' to '<?php echo $targetRank?>'.</strong>
        <?php if (!$targetUserExists) {echo "User does not exist";} else {echo"Please try again later.";}?>
    </div>
<?php
}

}


}
elseif (isset($_POST['setAllUserDefaultPrivilege'])) {
    $sql = "UPDATE `Login` SET `type`= 1 WHERE type < 3 AND type >= 0";
    $res = $conn->query($sql);

    if ($res) { ?>
        <div class="alert alert-warning">
            <strong>All users are now normal users.</strong> (Except Admins and Banned users.)
        </div>
    <?php } else {

        ?>
        <div class="alert alert-danger">
            <strong>Failed to set all users to normal accounts; try again later.</strong>
        </div>
    <?php
    }
}

?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Admin Commands</div>
            <ul class="list-group">

                <li class="list-group-item">
                    <div class="panel panel-default">
                        <div class="panel-heading">Standard Commands:</div>
                        <div class="panel-body">


                            <form method="POST" action="administrative.php" class="form form-inline" name="assignRank">

                                <label class="col-form-label col-md-4 " for="targetUsername">Set user rank:</label>

                                <input class="form-control col-md-4 horizontalRightSpacer" id="targetUsername"
                                       name="targetUsername"
                                       placeholder="username"
                                       required>


                                <select class="form-control horizontalRightSpacer"
                                        name="selectPower" id="selectPower">
                                    <option value="1">Normal user</option>
                                    <option value="2">Moderator</option>
                                    <option value="-1">BAN THEM</option>
                                </select>

                                <input title="Assign specified user selected rank." class="btn btn-primary"
                                       type="submit" name="assign" value="Assign Rank">


                            </form>


                            <div class="verticalSpacer"></div>


                            <?php
                            if ($_SESSION['type'] > 2) {

                            ?>

                            <form class="form" method="POST" action="administrative.php"
                                  name="setAllUserDefaultPrivilege">
                                <div class="form-group">
                                    <label class="col-md-4 col" for="clearLogin">Remove all Moderator powers:</label>
                                    <input title="Set everyone to a normal user, excluding Admins and Banned users"
                                           class="btn btn-warning"
                                           type="submit" name="setAllUserDefaultPrivilege"
                                           id="setAllUserDefaultPrivilege"
                                           value="Remove all Moderator Powers">
                                </div>
                            </form>
                            <?php


                            }?>

                        </div>

                    </div>
                </li>

                <?php
                if ($_SESSION['type'] > 2) {

                ?>
                <li class="list-group-item">
                    <div class="panel panel-danger">
                        <div class="panel-heading">NUCLEAR COMMANDS:</div>
                        <div class="panel-body">


                            <form class="form" method="POST" action="administrative.php"
                                  name="clearLoginDB">
                                <div class="form-group">
                                    <label class="col-md-4" for="clearLogin">Delete all
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
                                    <label class="col-md-4" for="clearThreads">Delete all
                                        topics & content:</label>
                                    <input title="Delete ALL threads and posts therein." class="btn btn-danger"
                                           type="submit" name="clearThreads" id="clearThreads"
                                           value="Clear All Threads DB">
                                </div>
                            </form>

                        </div>


                    </div>

                </li>
                <?php

                }?>
            </ul>


        </div>
    </div>


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