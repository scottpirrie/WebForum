<?php include_once("calls.php");
?>



<?php


if (!isset($currentPath)) {
    $currentPath = "menu.php";
}

if ($currentPath != "posts.php" && $currentPath != "newPost.php"){
    unset($_SESSION['threadID']);
}

if ($currentPath != "posts.php" && $currentPath != "newPost.php" &&
    $currentPath != "threads.php" && $currentPath != "newthread.php"){
    unset($_SESSION['topicID']);
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
                $_SESSION['user'] = $row["username"];
                $_SESSION['type'] = $row["type"];
            }
        }
    }

    if ($_SESSION['type'] == 0) {
        ?>
        <script>incorrectLogin()</script><?php
    }
}


if ($_SESSION['user'] != "") {
    $loginUser = cleanStr($_SESSION['user'], $conn);
    $sql = "SELECT * FROM `Login` WHERE username = '$loginUser'";
    $resUsers = $conn->query($sql);

    if ($resUsers->num_rows > 0) {
        while ($row = $resUsers->fetch_assoc()) {
            //should be logged in now
            $_SESSION['type'] = $row["type"];
        }
    }
}


?>
<nav class="navbar navbar-inverse navbar-static-top">
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
                <li class="nav-link<?php compareFile("topics.php", $currentPath) ?>"><a href="topics.php">Topics</a></li>
                <?php if ($_SESSION['type'] == 0) {
                ?>
                <li class="nav-link<?php compareFile("register.php", $currentPath) ?>"><a
                            href="register.php">Register</a>
                    <?php
                    }

                    if ($_SESSION['type'] > 0 || $_SESSION['type'] == -1) {
                    ?>
                <li class="nav-link<?php compareFile("me.php", $currentPath) ?>"><a href="me.php">My Account</a><?php
                    }

                    if ($_SESSION['type'] > 1) {
                    ?>
                <li class="nav-link<?php compareFile("administrative.php", $currentPath) ?>"><a
                            href="administrative.php">AdminHub</a><?php
                    } ?>

                </li>

                <li class="nav-link<?php compareFile("about.php", $currentPath) ?>"><a href="about.php">About</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($_SESSION['type'] > 0 || $_SESSION['type'] == -1) {
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
                            echo "threads.php";
                        } else {
                            echo $currentPath;
                        }

                        ?>" method="post">

                            <input class="form-control col-2" type=text name="user" placeholder="username"
                                   required>

                            <input class="form-control col-2" type=password name="pass" placeholder="password"
                                   required>

                            <input name="login" type="submit" value="Log In" class="form-control btn btn-sm"/>
                        </form>
                    </li>
                    <?php
                }
                ?></ul>
        </div>
    </div>
</nav>


