<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Topic</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>


<div class="page-header col-md-offset-1">
    <h1>New Topic</h1>
</div>

<?php
if ($_SESSION["type"] > 1) {
    $_SESSION["hasCreated"] = false; ?>


    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Create a new topic.</div>
            <div class="panel-body">
                <form id="create-topic" class="form" method="post" action="topics.php">

                    <div class="form-group  col-md-4 ">
                        <label class="col-form-label" for="topicName">Topic name:</label>
                        <input class="form-control" type="text" id="topicName" name="topicName" required minlength="2"
                               maxlength="30">
                    </div>

                    <div class="form-group  col-md-12 ">
                        <label class="col-form-label" for="type">Viewing Permissions:</label>
                        <select class="form-control" name="type" >
                            <option value="-1"> Any User<br>
                            <option value="1" > Normal Member<br>
                            <option value="2"> Moderator<br>
                            <option value="3"> Admin<br>
                        </select><br>
                    </div>

                    <div class="form-group  col-md-2 ">
                        <input class="form-control" type="submit" name="create" value="Create!">
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php
} elseif ($_SESSION["type"] == 1){ ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Insufficient Permission!</div>
            <div class="panel-body">You do not have a sufficient level of permissions to create a new topic!</div>
        </div>
    </div> <?php

} elseif($_SESSION["type"] == 0) { ?>
    <div class="container col-md-8 col-md-offset-2">
        <div class="panel panel-warning">
            <div class="panel-heading">Not logged in!</div>
            <div class="panel-body">You need to be logged in as a moderator/admin to create a topic!</div>
        </div>
    </div> <?php
} elseif ($_SESSION["type"] == -1){?>
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
