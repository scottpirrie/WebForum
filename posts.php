<!DOCTYPE html>
<html lang="en">
<head>
    <title>Posts</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");


$topicName = "";
if (isset($_GET["threadID"]) || isset($_SESSION['threadID'])) {
    if (isset($_GET["threadID"])) {
        $threadIDnumber = $_GET["threadID"];
        $_SESSION['threadID'] = $threadIDnumber;
    } else {
        $threadIDnumber = $_SESSION['threadID'];
    }
} else { ?>
    <script> redirectTopics();</script> <?php
}

?>

<div class="page-header col-md-offset-1">
    <h1>Posts: Thread ID - <?php echo $_SESSION["threadID"]; ?> </h1>
</div>

<?php


$sql = "SELECT topic FROM `Threads` WHERE id = '$threadIDnumber'";
$res = $conn->query($sql);

$currentTopic = -1;
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $currentTopic = $row['topic'];
    }
}

$sql = "SELECT type FROM `Topics` WHERE id = '$currentTopic'";
$res = $conn->query($sql);

$requiredPermission = false;
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        if ($row["type"] <= $_SESSION['type']) {
            $requiredPermission = true;
        }
    }
}

if ($requiredPermission) {

$threadID = $_SESSION["threadID"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["createPost"])) {
        if (isset($_SESSION["hasPosted"])) {
            if ($_SESSION["hasPosted"] == false) {
                $postContent = cleanStr($_POST["postContent"], $conn); //Do we want to clean the post??

                $user = $_SESSION["user"];
                $date = date('Y-m-d H:m:s', time());
                $sql = "INSERT INTO `Posts`(`threadid`, `creator`, `date`, `content`) VALUES ('$threadID','$user','$date','$postContent')";

                if ($conn->query($sql)) {
                    echo "<p>Post created successfully</p>";
                    // todo make this not a print
                    $sql = "UPDATE `Threads` SET `datelast` = '$date' WHERE `id` = '$threadID'";
                    $conn->query($sql);
                } else {
                    echo "<p>Post not created. An error has occurred.</p>";
                }
                $_SESSION["hasPosted"] = true;
            }
        }
    }
}


$sql = "SELECT * FROM `Posts` WHERE `threadid` = '$threadID'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    if (!isset($_SESSION['postPage'])) {
        $_SESSION['postPage'] = 1;
    }
    $postNum = $_SESSION["postPage"] * 10;
    while ($row = $result->fetch_assoc()) {
        $out[] = $row;
    }
    $out[] = null;
    for ($i = $postNum - 10; $i < $postNum; $i++) {

        if ($out[$i] == null) {
            $last = true;
            break;
        } else {
            $last = false;
        }
    }
} elseif ($result->num_rows == 0) {
    $last = true;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["nextpostpage"])) {
        if (!$last) {
            $_SESSION["postPage"]++;
        }
    } elseif (isset($_GET["prevpostpage"])) {
        if ($_SESSION["postPage"] > 1) {
            $_SESSION["postPage"]--;
        }
    } else {
        $_SESSION["postPage"] = 1;
    }

}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["threadID"])) {
        $threadID = $_GET["threadID"];
        $_SESSION["threadID"] = $threadID;
    } elseif (isset($_SESSION["threadID"])) {
        $threadID = $_SESSION["threadID"];
    }
} else {
    $threadID = $_SESSION["threadID"];
}

$sql = "SELECT * FROM `Posts` WHERE `threadid` = '$threadID'";
$result = $conn->query($sql); ?>

<div class="container col-md-10 col-md-offset-1">
    <div class="panel panel-default">

        <table class="table-striped table-hover table-responsive table-bordered">
            <tr>
                <th class="col-md-2 nopadding">User</th>
                <th class=" nopadding">Post</th>
                <th class="col-md-2 nopadding">Date</th>
            </tr>


            <?php
            if ($result->num_rows > 0) {
                $postNum = $_SESSION["postPage"] * 10;
                while ($row = $result->fetch_assoc()) {
                    $out[] = $row;
                }
                $out[] = null;
                for ($i = $postNum - 10; $i < $postNum; $i++) {

                    if ($out[$i] == null) {
                        $last = true;
                        break;
                    } else {
                        $last = false;
                    }
                    $creator = $out[$i]["creator"];
                    $content = $out[$i]["content"];
                    $date = $out[$i]["date"];
                    ?>
                    <tr>
                        <td> <?php echo $creator; ?> </td>
                        <td> <?php echo $content; ?></td>
                        <td> <?php echo $date; ?></td>
                    </tr>

                    <?php
                }
            } elseif ($result->num_rows == 0) {
                $last = true;
            } ?>
        </table>
        <div class="panel-footer">
            <div>

                <form class="form-inline" name="changePostPage" method="GET" action="posts.php">
                    <?php

                    $postPage = $_SESSION["postPage"];

                    if ($postPage > 1) {
                        ?>
                        <div class="form-group col-md-1 ">
                            <input class="btn btn-sm reducedPadding" type="submit" name="prevpostpage"
                                   value="Previous Page">
                        </div><?php
                    }
                    if (!$last) {
                        ?>
                        <div class="form-group col-md-1 ">
                            <input class="btn btn-sm reducedPadding" type="submit" name="nextpostpage"
                                   value="Next Page">
                        </div><?php
                    }
                    ?>
                    <div class="alignRight"> Page <?php
                        echo $_SESSION["postPage"]; ?></div>

                </form>
            </div>
        </div>
    </div>
</div>
    <div class="container col-md-3 col-md-offset-1">
        <form class="form" name="newpost" method="POST" action="newpost.php">
            <div class="form-group">
                <input class="form-control col-md-2" type="submit" name="submit" value="Create new post"/>
            </div>
        </form>
    </div>


    <?php } else { ?>
        <div class="container col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading">Insufficient Permission!</div>
                <div class="panel-body">You are not allowed to view this content.</div>
            </div>
        </div>
        <?php
    } ?>


</body>
</html>