<?php include_once("calls.php");
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
    @media (max-width: 767px) {
        .navbar-nav {
            margin: 0;
            padding: 0;
        }
    }
</style>

<?php

if (!isset($currentPath)) {
    $currentPath = "menu.php";
}

if (isset($_POST['logoff'])) {
    logOff();
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $loginUser = cleanStr($_POST["user"], $conn);
    $loginPass = $_POST["pass"];

    $sql = "SELECT * FROM `Login` WHERE username = '$loginUser'";
    $resUsers = $conn->query($sql);

    if ($resUsers->num_rows > 0) {
        while ($row = $resUsers->fetch_assoc()) {
            if (password_verify($loginPass, $row["password"])) {
                //should be logged in now
                $_SESSION['type'] = $row["type"];
                $_SESSION['user'] = $row["username"];
            }
        }
    }

    if ($_SESSION['type'] == 0) {
        ?>
        <script>incorrectLogin()</script><?php
    }
}
?>

<ul class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="index.php">Meme Forum</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="nav-link<?php compareFile("home.php", $currentPath) ?>"><a href="home.php">Topics</a></li>
                <?php if ($_SESSION['type'] == 0) {
                ?>
                <li class="nav-link<?php compareFile("register.php", $currentPath) ?>"><a
                            href="register.php">Register</a>
                    <?php
                    }

                    if ($_SESSION['type'] > 0) {
                    ?>
                <li class="nav-link<?php compareFile("me.php", $currentPath) ?>"><a href="me.php">My Account</a><?php
                    }

                    if ($_SESSION['type'] > 1) {
                    ?>
                <li class="nav-link<?php compareFile("administrative.php", $currentPath) ?>"><a
                            href="administrative.php">AdminHub</a><?php
                    } ?>

                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php
                $_SESSION['type'] = isset($_SESSION['type']) ? $_SESSION['type'] : 0;

                if ($_SESSION['type'] > 0) {
                    ?>
                    <li class="nav-item">
                        <form class="navbar-form" action="index.php" method="post">
                            <input name="logoff" type="submit" value="Log Out" class="btn btn-sm"/>
                        </form>
                    </li>

                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <form class="navbar-form" action="<?php if ($currentPath == "register.php") {
                            echo "home.php";
                        } else {
                            echo $currentPath;
                        }

                        ?>" method="post">

                                <input class="form-control col-2" type=text name="user" minlength="4" maxlength="15"
                                       placeholder="username"
                                       required>

                                <input class="form-control col-2" type=password name="pass" minlength="4" maxlength="15"
                                       placeholder="password"
                                       required>

                                <input name="login" type="submit" value="Log In" class="form-control btn btn-sm"/>
                        </form>
                    </li>
                    <?php
                }
                ?></ul>
        </div>
    </div>
</ul>

