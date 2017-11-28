<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>


<div class="page-header col-md-offset-1">
    <h1>Register</h1>
</div>

<?php

$accountCreationSuccess = false;
$usernameTaken = false;
if (isset($_POST["create"])) {
    if ($_POST["newPassword"] != $_POST["newPasswordRepeat"]) {?>
        <div class="alert alert-danger">
            <strong>Passwords did not match.</strong>
        </div> <?php
        $accountCreationSuccess = false;
    } else {
        $uncleanedUser = $_POST['newUsername'];
        $createUser = cleanStr($_POST["newUsername"], $conn);
        $createPass = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
        $accountCreationSuccess = true;

        $sql = "SELECT username FROM `Login`";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                if (strtoupper($row["username"]) == strtoupper($createUser)) {
                    $usernameTaken = true;
                    $accountCreationSuccess = false;
                    break;
                }
            }
        }
    }
    if ($accountCreationSuccess) {
        $sql = "INSERT INTO `Login` (`username`, `password`, `type`) VALUES ('$createUser', '$createPass', '1')";
        $conn->query($sql);

        /*todo change privilege level*/
        $_SESSION['user'] = $uncleanedUser;
        $_SESSION['type'] = 2;
        ?>

        <script>
            redirect();
        </script> <?php
    }
}

if ($usernameTaken) { ?>
    <div class="alert alert-danger">
        <strong>Username taken.</strong>
    </div> <?php
}


if ($accountCreationSuccess) { ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Successfully registered an account, redirect failed.</div>
            <div class="panel-body">Please navigate using the menu bar. <br>
                To make a new account, log out.
            </div>
        </div>
    </div>
    <?php
} else {
    if ($_SESSION['type'] > 0) { ?>
        <div class="container col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading">Can not register an account.</div>
                <div class="panel-body">You are currently logged in. <br>
                    To make a new account, log out.
                </div>
            </div>
        </div>

        <?php
    } else { ?>
        <form method="POST" action="register.php" class="form" name="register" onsubmit="return checkUsernameSpaces();">

            <div class="container col-md-4 col-md-offset-4">
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="userToBe"> Username </label>
                    <input class="form-control" id="userToBe" type=text name="newUsername"
                           minlength="4"
                           maxlength="15"
                           required>

                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="passToBe">Password</label>
                    <input class="form-control" id="passToBe" type=password name="newPassword" minlength="4"
                           maxlength="15" required>

                </div>
                <div class="form-group row">

                    <label class="col-sm-8 col-form-label" for="passToBeRepeat">Repeat Password:</label>
                    <input class="form-control" id="passToBeRepeat" type=password name="newPasswordRepeat" minlength="4"
                           maxlength="15" required>

                </div>


                <div class="form-group row">
                    <div class="col-xs-2">
                        <input class="btn btn-primary" type="submit" name="create" value="Create Account">
                    </div>
                </div>

            </div>


        </form>
    <?php }
} ?>
