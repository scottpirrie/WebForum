<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <?php
    include("calls.php");
    $conn = loadDB();
    $errUser = "";
    ?>
</head>
<body>
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["create"])){

        $createUser = cleanStr($_POST["user"], $conn);
        $createPass = cleanStr($_POST["pass"], $conn);
        $createPass = password_hash($createPass, PASSWORD_BCRYPT);
        $sql = "SELECT `username` FROM `Login`";
        $res = $conn->query($sql);
        if($res->num_rows > 0){
            while($user = $res->fetch_row()) {
                if ($user[0] == $createUser) {
                    $errUser = "A user already exists with that username.";
                    break;
                }
            }
        }
        if($errUser == ""){
            $sql = "INSERT INTO `Login` (`username`, `password`, `type`) VALUES ('$createUser', '$createPass', '2')";
            $res = $conn->query($sql);
        }
    }
}
    ?>
    <div id = "create">
        <form method = "POST" action = "create.php">
            Username<input type = text name = "user" minlength="4" maxlength="15" required> <?php echo $errUser;?><br>
            Password<input type = password name = "pass" minlength="4" maxlength="15" required><br>
            <input type = "submit" name = "create" value = "Create Account"><br>
        </form>
    </div>
</body>
</html>