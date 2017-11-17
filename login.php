<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php
    $currentPath = basename(__FILE__);
    include_once("menu.php");

    ?>

</head>
<body>


<h1>Header</h1>

<p>Currently logged in as: <?php echo $_SESSION['user']?></p>
<p>Currently logged in as: <?php echo $_SESSION['type']?></p>


</body>
</html>
