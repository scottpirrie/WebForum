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

<h1>Register</h1>

<?php

$accountCreationSuccess = false;

if (isset($_POST["create"])) {
    $createUser = cleanStr($_POST["newUsername"], $conn);
    $createPass = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
    $accountCreationSuccess = true;

    $sql = "SELECT `username` FROM `Login`";
    $res = $conn->query($sql);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            if ($serverPass = $row["username"] == $createUser) {
                ?>
                <script>usernameTaken();</script><?php
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

        <script>alert("Account sucessfully created; attempting to redirect." + "\n" +
                "(In the event of failure; please manually navigate.")</script>
        <script>window.location = "home.php";</script> <?php


    }
}

if ($accountCreationSuccess) {
    echo "account made, show msg, and auto log them in";

} else {
    if ($_SESSION['type'] > 0) {
        echo "log off ples";
    } else { ?>
        <form method="POST" action="register.php">
            <div class="form-group">
                <div class="form-group">
                    <label for="userToBe"> Username </label>
                    <input id="userToBe" type=text name="newUsername" minlength="4" maxlength="15" required>
                </div>

                <div class="form-group">
                    <label for="passToBe">Password</label>
                    <input id="passToBe" type=password name="newPassword" minlength="4" maxlength="15" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="create" value="Create Account"><br>
                </div>
            </div>
        </form>
    <?php }
} ?>


</body>
</html>
