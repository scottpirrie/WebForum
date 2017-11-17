<?php include_once("calls.php");

if (!isset($currentPath)) {
    $currentPath = "";
}

?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Meme Forum</a>
        </div>
        <ul class="nav navbar-nav">
            <li <?php compareFile("Topics.php", $currentPath) ?>><a href="topics.php">Topics</a></li>
            <li <?php compareFile("create.php", $currentPath) ?>><a href="create.php">Sign Up</a></li>
            <li <?php compareFile("login.php", $currentPath) ?>><a href="login.php">Login</a></li>
        </ul>
    </div>
</nav>