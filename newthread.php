
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Thread</title>
    <?php
    include("calls.php");
    $conn = loadDB();

    ?>
</head>
<body>
<h1>Create Thread</h1>
<?php
if($_SESSION["type"]==0){
    echo "<h2>You need to be logged in to create a thread!</h2>";
} else{

?>
    <form method="post" action = "home.php">
        Thread title<input type="text" name="threadName" required>
        <button type="submit" name = "create">Post</button>
    </form>
<?php } ?>
</body>
</html>