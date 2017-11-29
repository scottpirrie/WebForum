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
if ($_SESSION["type"] > 0 || $_SESSION["type"] < 0) {

    if (isset($_POST["change"])) {
        $curPass = $_POST['curPassword'];
        $newPass = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);

        $loginUser = cleanStr($_SESSION["user"], $conn);

        $sql = "SELECT * FROM `Login` WHERE username = '$loginUser'";
        $resUsers = $conn->query($sql);

        if ($resUsers->num_rows > 0) {
            while ($row = $resUsers->fetch_assoc()) {
                if (password_verify($curPass, $row["password"])) {
                    if ($_POST["newPassword"] != $_POST["newPasswordRepeat"]) { ?>
                        <div class="alert alert-danger">
                            <strong>New Passwords did not match.</strong>
                        </div><?php } else {

                        $sql = "UPDATE `Login` SET `password` = '$newPass' where username = '$loginUser'";
                        $res = $conn->query($sql);
                        if ($res) {?>
                            <div class="alert alert-success">
                        <strong>Password Changed.</strong>
                    </div> <?php
                        } else { ?>

                            <div class="alert alert-danger">
                                <strong>Password Change failed.</strong> Please try again later.
                            </div>


                            <?php
                        }
                    }

                } else {
                    ?>
                    <div class="alert alert-danger">
                        <strong>Current Password is incorrect.</strong>
                    </div> <?php
                }
            }
        }
    }
    ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Account details</div>

            <ul class="list-group">

                <li class="list-group-item">
                    <div class="panel panel-default">
                        <div class="panel-heading">Username:</div>
                        <div class="panel-body"><?php echo $_SESSION['user'] ?></div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="panel panel-default">
                        <div class="panel-heading">Privilege Level:</div>
                        <div class="panel-body"><?php
                            if ($_SESSION['type'] == -1) {
                                echo "BANNED";
                            } elseif ($_SESSION['type'] == 1) {
                                echo "Normal user";
                            } elseif ($_SESSION['type'] == 2) {
                                echo "Moderator";
                            } elseif ($_SESSION['type'] == 3) {
                                echo "Admin";
                            }
                            ?></div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="panel panel-warning">
                        <div class="panel-heading">Change Password:</div>
                        <div class="panel-body">
                            <form method="POST" action="me.php" class="form" name="register"
                                  onsubmit="return checkUsernameSpaces();">

                                <div class="container col-md-6">
                                    <div class="form-group row">

                                        <label class="col-form-label" for="curPassword"> Current Password: </label>
                                        <input class="form-control col-md-4" id="curPassword" type=password name="curPassword"
                                               minlength="4"
                                               maxlength="15"
                                               required>

                                    </div>

                                    <div class="form-group row">

                                        <label class="col-form-label" for="passToBe">New Password:</label>
                                        <input class="form-control col-md-4" id="passToBe" type=password name="newPassword"
                                               minlength="4"
                                               maxlength="15" required>

                                    </div>
                                    <div class="form-group row">

                                        <label class="col-form-label" for="passToBeRepeat">Repeat New
                                            Password:</label>
                                        <input class="form-control col-md-4" id="passToBeRepeat" type=password
                                               name="newPasswordRepeat" minlength="4"
                                               maxlength="15" required>

                                    </div>


                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input class="btn btn-warning" type="submit" name="change"
                                                   value="Change Password">
                                        </div>
                                    </div>

                                </div>


                            </form>
                        </div>
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