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
    <h1>About</h1>
</div>


User rankings: <br>
-1: BANNED <br>
0: Not logged in <br>
1: Normal user <br>
2: Moderator <br>
3: Admin <br>

bootstrap/3.3.7
</body>
</html>