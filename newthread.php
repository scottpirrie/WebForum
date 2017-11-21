<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Thread</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>


<div class="page-header col-md-offset-1">
    <h1>New Thread Topic</h1>
</div>

<?php
if ($_SESSION["type"] > 0) {
    $_SESSION["hasPosted"] = false; ?>


    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Create a new thread topic.</div>
            <div class="panel-body">
                <form id="create-thread" class="form" method="post" action="home.php">

                    <div class="form-group  col-md-4 ">
                        <label for="threadName">Thread name:</label>
                        <input class="form-control" type="text" id="threadName" name="threadName" required
                               minlength="2" maxlength="30">
                    </div>

                    <div class="form-group  col-md-12 ">
                        <label for="post">Post:</label>
                        <textarea class="form-control" rows="15"  name="post"
                                  form="create-thread"></textarea><br>

            </div>
                    <div class="form-group  col-md-12 ">
                        <input type="submit" name="create" value="Create!"></div>
                </form>
            </div>
        </div>
    </div>

    <?php
} elseif ($_SESSION["type"] == 0) { ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Not logged in!</div>
            <div class="panel-body">You need to be logged in to create a thread!</div>
        </div>
    </div> <?php
} elseif ($_SESSION["type"] == -1) { ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Banned!</div>
            <div class="panel-body">You are banned!</div>
        </div>
    </div> <?php


}
?>
</body>
</html>