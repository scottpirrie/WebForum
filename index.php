<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home Page</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>
<br>
<br>
<br>
<br>


<div class="container">
    <div class="jumbotron">
        <h1>Grp.K Forums</h1>
        <p>Browse topics and discuss with other users.
            <?php if($_SESSION['type'] == 0){?> <a href="register.php">Sign up now.</a><?php }?></p>
    </div>

    <div class="container col-md-10 col-md-offset-1">
        <div class="page-header">
            <h1>Ready to go?</h1>
            <div class="col-md-offset-1">
                <h2><a href="topics.php">Start browsing</a> </h2>
            </div>
        </div>
    </div>
</div>



</body>
</html>