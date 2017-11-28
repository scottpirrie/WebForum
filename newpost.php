<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Post</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>


<div class="page-header col-md-offset-1">
    <h1>New Post</h1>
</div>

<?php

if(!isset($_SESSION['threadID'])){
    echo "<script> redirectTopics();</script>";
}

if($_SESSION["type"]==0){ ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Not logged in!</div>
            <div class="panel-body">You need to be logged in to post!</div>
        </div>
    </div>
<?php } elseif ($_SESSION['type'] == -1) {

    //todo this should really check what type of account is logged in at this time as well.
    // posting to unviewable threads may be circumventable with session variables
    ?>

    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Permissions Error!</div>
            <div class="panel-body">You do not have required permissions to post.</div>
        </div>
    </div>

<?php
} else{
    $_SESSION["hasPosted"] = false;
    ?>



    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Create a new post.</div>
            <div class="panel-body">
                <form id = "postForm" class="form" method="post" action="posts.php">
                    <div class="form-group  col-md-12 ">
                        <label class="col-form-label" for="post">Post:</label>
                        <textarea class="form-control" rows="20" form="postForm" name="postContent" form="create-thread" maxlength="1000" required placeholder="Enter text..."></textarea><br>
                    </div>

                    <div class="form-group  col-md-2 ">
                        <input class="form-control"  type="submit" name="createPost" value="Post!">
                    </div>

                </form>
            </div>
        </div>
    </div>
    </form>
<?php } ?>
</body>
</html>