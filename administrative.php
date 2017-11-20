<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>

<div class="page-header col-md-offset-1">
    <h1>Administrative</h1>
</div>

<?php
if ($_SESSION['type'] > 1) {

    if (isset($_POST['clearLogin'])) {
    ?><script>alert("NO LOGIN CLEAR");</script><?php
        $sql = "DELETE FROM `Login` WHERE username <> 'admin'";
        $conn->query($sql);

    } elseif (isset($_POST['clearThreads'])) {

        ?><script>alert("FAK");</script><?php

        $sql = "DELETE FROM `Threads`";
        $conn->query($sql);
        $sql = "DELETE FROM `Posts`";
        $conn->query($sql);

    } elseif (isset($_POST['assign'])) {


    }


    ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Welcome</div>
            <div class="panel-body">Administrative Commands.</div>
        </div>
    </div>


    <form method="POST" action="administrative.php" class="form" name="assignRank">


        <input class="form-control" id="username" type=text name="target"
               required>

        <input class="form-control" id="passToBe" type=password name="newPassword" minlength="4"
               maxlength="15" required>


        <input class="btn btn-primary" type="submit" name="assign" value="Assign Rank">

    </form>


    <br><br><br>

    <h2>NUCLEAR OPTIONS</h2>
    <form method="POST" action="administrative.php" class="form" name="clearLoginDB">

        <input title="Delete ALL accounts (excluding 'admin')" class="btn btn-primary" type="submit" name="clearLogin"
               value="Clear Accounts DB">

    </form>

    <form method="POST" action="administrative.php" class="form" name="clearThreads">

        <input title="Delete ALL threads and posts therein." class="btn btn-primary" type="submit" name="clearAccounts"
               value="Clear All Threads DB">

    </form>


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