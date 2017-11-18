<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account</title>
    <?php
    $currentPath = basename(__FILE__);
    include_once("menu.php");
    ?>
</head>
<body>
<div class="page-header col-md-offset-1">
    <h1>Administrative</h1>
</div>

<?php
if ($_SESSION['type'] > 1) { ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Welcome</div>
            <div class="panel-body">Administrative Commands.</div>
        </div>
    </div>

<?php } else { ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Access Denied!</div>
            <div class="panel-body">You aren't supposed to be here.</div>
        </div>
    </div>

    <?php
}

?>
</body>
</html>