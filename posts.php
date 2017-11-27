<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
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


////////////////////////////////todo permission to check if you should be able to see this

//because weirdly, posts uses post where as threads used get.. this is only reachable if someone with permission logs in
//views, logs out, logs in as banned user, jumps straight to posts.php without going through topics ...

// first get the topic number


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


    <table>
        <tr>
            <th>User</th>
            <th>Content</th>
            <th>Date</th>
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


    <?php
    $postPage = $_SESSION["postPage"];
    echo "<p>Page $postPage</p>"
    ?>
    <form name="changePostPage" method="GET" action="posts.php">
        <?php
        if ($postPage > 1) {
            ?>
            <input type="submit" name="prevpostpage" value="Previous Page">
            <?php
        }
        if (!$last) {
            ?>
            <input type="submit" name="nextpostpage" value="Next Page">
            <?php
        }
        ?>
    </form>
    <form name="newPost" method="POST" action="newPost.php">
        <input type="submit" name="submit" value="Create new post"/>
    </form>

<?php } else {


    echo "why are you here, again";
} ?>


</body>
</html>