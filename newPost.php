<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Post</title>
    <?php
    include_once("menu.php");
    include_once("includeHeader.php");
    $conn = loadDB();
    ?>
</head>
<body>
<h1>Create Post</h1>
<?php
if($_SESSION["type"]==0){
    echo "<h2>You need to be logged in to create a post!</h2>";
} else{
    $_SESSION["hasPosted"] = false;
    ?>
    <form id="postForm" method="post" action = "posts.php">
        <h4>Post Content</h4>
        <textarea rows="5" cols="50" name="postContent" form="postForm">Enter text here...</textarea>
        <br>
        <button type="submit" name="createPost">Post</button>
    </form>
<?php } ?>
</body>
</html>