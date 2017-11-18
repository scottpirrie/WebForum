<?php include_once("calls.php");

echo "<link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\"
          integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">";

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

<ul class="navbar navbar-inverse">
    <div class="container-fluid">

        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Meme Forum</a>
        </div>

        <ul class="nav navbar-nav">
            <li class="nav-link<?php compareFile("home.php", $currentPath) ?>"><a href="home.php">Topics</a></li>
            <li class="nav-link<?php compareFile("register.php", $currentPath) ?>"><a href="register.php">Register</a>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <?php
            $_SESSION['type'] = isset($_SESSION['type']) ? $_SESSION['type'] : 0;

            if ($_SESSION['type'] > 0) {
                ?><li class="nav-item">
                    <form class="navbar-form" action="<?php echo $currentPath ?>" method="post">
                        <input name="logoff" type="submit" value="Log Out" class="btn btn-sm"/>
                    </form>
                </li>

                <?php
            } else {
                ?><li class="nav-item">
                    <form class="navbar-form" action="<?php echo $currentPath ?>" method="post">

                        <input class="form-control" type=text name="user" minlength="4" maxlength="15"
                               placeholder="username"
                               required>
                        <input class="form-control" type=password name="pass" minlength="4" maxlength="15"
                               placeholder="password"
                               required>

                        <input name="login" type="submit" value="Log In" class="form-control btn btn-sm"/>

                    </form>
                </li>
                <?php
            }
            ?></ul>

    </div>
</ul>

