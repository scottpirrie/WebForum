
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
    <form method="post" action = "home.php">
        Thread title<input type="text" name="threadName" required>
        <button type="submit" name = "create">Post</button>
    </form>
</body>
</html>