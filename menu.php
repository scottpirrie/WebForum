<?php include_once("calls.php");
$conn = loadDB();

if (!isset($currentPath)) {
    $currentPath = "menu.php";
}

if (isset($_POST['logoff'])) {
    logOff();
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $loginUser = cleanStr($_POST["user"], $conn);
    $loginPass = cleanStr($_POST["pass"], $conn);
    $sql = "SELECT `username` FROM `Login`";
    $resU = $conn->query($sql);
    $sql = "SELECT `password` FROM `Login`";
    $resP = $conn->query($sql);
    if (($resU->num_rows > 0) && ($resP->num_rows > 0)) {
        while (($user = $resU->fetch_row()) && ($pass = $resP->fetch_row())) {
            if ($user[0] == $loginUser) {
                $user = $user[0];
                if (password_verify($loginPass, $pass[0])) {
                    $sql = "SELECT `type` FROM `Login` WHERE `username` = '$user'";
                    $res = $conn->query($sql);
                    if ($res->num_rows > 0) {
                        $details = $res->fetch_row();
                        $_SESSION['type'] = $details[0];
                    }
                    $_SESSION['user'] = $user;
                    break;
                }
            }
        }
    }
}
?>
 
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Meme Forum</a>
        </div>
        <ul class="nav navbar-nav">
            <li <?php compareFile("topics.php", $currentPath) ?>><a href="topics.php">Topics</a></li>
            <li <?php compareFile("create.php", $currentPath) ?>><a href="create.php">Sign Up</a></li>

            <?php
            $_SESSION['type'] = isset($_SESSION['type']) ? $_SESSION['type'] : 0;

            if ($_SESSION['type'] > 0) { ?>
                <form action="<?php echo $currentPath ?>" method="post">
                    <li><input name="logoff" type="submit" value="Log Off" class="btn btn-default"/></li>
                </form>
                <?php
            } else { ?>

                <form action="<?php echo $currentPath ?>" method="post">
                    <ul class="dropdown-menu">
                        <li></li>
                        <label>
                            <input type=text name="user" minlength="4" maxlength="15" placeholder="username" required>
                        </label>
                        <label>
                            <input type=password name="pass" minlength="4" maxlength="15" placeholder="password" required>
                        </label>
                        <li><input name="login" type="submit" value="Log In" class="btn btn-default"/></li>
                    </ul>
                </form>
                <?php
            }
            ?>
        </ul>
    </div>
</nav>
