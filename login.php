<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
    include("calls.php");
    $conn = loadDB();

    ?>
</head>
<body>
    <?php
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            if(isset($_POST["login"])){
                $loginUser = cleanStr($_POST["user"], $conn);
                $loginPass = cleanStr($_POST["pass"], $conn);
                $sql = "SELECT `username` FROM `Login`";
                $resU = $conn->query($sql);
                $sql = "SELECT `password` FROM `Login`";
                $resP = $conn->query($sql);
                if(($resU->num_rows > 0) && ($resP->num_rows > 0)){
                    while(($user = $resU->fetch_row()) &&($pass = $resP->fetch_row())){
                        if($user[0] == $loginUser){
                            $user = $user[0];
                            if(password_verify($loginPass,  $pass[0])){
                                $sql = "SELECT `type` FROM `Login` WHERE `username` = '$user'";
                                $res = $conn->query($sql);
                                if($res->num_rows > 0) {
                                    $details = $res->fetch_row();
                                    $_SESSION['type'] = $details[0];
                                }
                                break;
                            }
                        }
                    }
                }
            }

        }

    if(!isset($_SESSION['type'])){


    ?>

    <div id = "login">
        <form method = "POST" action = "login.php">
            Username<input type = text name = "user" minlength="4" maxlength="15" required><br>
            Password<input type = password name = "pass" minlength="4" maxlength="15" required><br>
            <input type = "submit" name = "login" value = "Login"><br>
        </form>
    </div>
<?php }?>
</body>
</html>