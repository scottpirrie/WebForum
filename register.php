<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <?php
    $currentPath = basename(__FILE__);
    include_once("menu.php");
    ?>
</head>
<body>

<h1 class="page-header">Register</h1>

<?php

$accountCreationSuccess = false;
$usernameTaken = false;
if (isset($_POST["create"])) {
    $createUser = cleanStr($_POST["newUsername"], $conn);
    $createPass = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
    $accountCreationSuccess = true;

    $sql = "SELECT `username` FROM `Login`";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            if ($serverPass = $row["username"] == $createUser) {
                $usernameTaken = true;
                $accountCreationSuccess = false;
                break;
            }
        }
    }

    if ($accountCreationSuccess) {
        $sql = "INSERT INTO `Login` (`username`, `password`, `type`) VALUES ('$createUser', '$createPass', '2')";
        $conn->query($sql);

        $_SESSION['user'] = $createUser;
        $_SESSION['type'] = 2;
        ?>

        <script>
            accountCreated();
            redirect();
        </script> <?php
    }
}

if ($usernameTaken) { ?>
    <script>usernameTaken();</script> <?php
}


if ($accountCreationSuccess) {
    echo "account made, show msg, and auto log them in";

} else {
    if ($_SESSION['type'] > 0) {
        echo "log off ples";
    } else { ?>
        <form method="POST" action="register.php" class="form">


            <div class="container center-block">


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
                    <div class="col-xs-2">
                        <input class="btn btn-primary" type="submit" name="create" value="Create Account"><br>
                    </div>
                </div>

            </div>


        </form>
    <?php }
} ?>
