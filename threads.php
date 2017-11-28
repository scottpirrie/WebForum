<!DOCTYPE html>
<html lang="en">
<head>
    <title>Threads</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");


$topicName = "";
if (isset($_GET["topicID"]) || isset($_SESSION['topicID'])) {
    if (isset($_GET["topicID"])) {
        $topicName = $_GET["topicID"];
        $_SESSION['topicID'] = $topicName;
    } else {
        $topicName = $_SESSION["topicID"];
    }

} else { ?>
    <script> redirectTopics();</script> <?php
}
?>


<div class="page-header col-md-offset-1">
    <h1>Threads: Topic ID - <?php echo $topicName; ?></h1>
</div>


<?php


$sql = "SELECT type FROM `Topics` WHERE id = '$topicName'";
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

if (isset($_POST["topicID"])) {
    $topicID = $_POST["topicID"];
} else {
    $topicID = $_SESSION["topicID"];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create"])) {
        if (isset($_SESSION["hasPosted"])) {
            if ($_SESSION["hasPosted"] == false) {
                $threadName = cleanStr($_POST["threadName"], $conn);
                $post = cleanStr($_POST["post"], $conn);
                $user = $_SESSION["user"];
                $date = date('Y-m-d H:m:s', time());
                $sql = "INSERT INTO `Threads` (`threadname`, `creator`, `date`, `datelast`, `topic`) VALUES ('$threadName', '$user', '$date', '$date', '$topicID')";

                if ($conn->query($sql)) {
                    echo "<p>Thread created successfully</p>";
                    $sql = "SELECT `id` FROM `Threads` WHERE `threadname` = '$threadName' AND `creator` = '$user' AND `date` = '$date'";
                    $res = $conn->query($sql);
                    if ($res->num_rows > 0) {
                        $row = $res->fetch_row();
                        $threadID = $row[0];
                        echo $post;
                        $sql = "INSERT INTO `Posts`(`threadid`, `creator`, `date`, `content`) VALUES ('$threadID','$user','$date','$post')";
                        if ($conn->query($sql)) {
                            echo "<p>Post added to thread successfully!</p>";
                        }

                    }

                }
                $_SESSION["hasPosted"] = true;
            }
        }
    }
}

$last = false;
$sql = "SELECT * FROM `Threads` WHERE `topic` = '$topicID' ORDER BY `datelast` DESC";
if ($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        $threadNum = $_SESSION["page"] * 10;
        while ($row = $result->fetch_assoc()) {
            $out[] = $row;
        }
        $out[] = null;
        for ($i = $threadNum - 10; $i < $threadNum; $i++) {

            if ($out[$i] == null) {
                $last = true;
                break;
            } else {
                $last = false;
            }
        }
    }
}
if (isset($_GET["nextpage"])) {
    if (!$last) {
        $_SESSION["page"]++;
    }
} elseif (isset($_GET["prevpage"])) {
    if ($_SESSION["page"] > 1) {
        $_SESSION["page"]--;
    }
} else {
    $_SESSION["page"] = 1;
}


$sql = "SELECT * FROM `Threads` WHERE `topic` = '$topicID' ORDER BY `datelast` DESC";
if ($result = $conn->query($sql)) { ?>
<div class="container col-md-10 col-md-offset-1">
    <div class="panel panel-default">

        <table class="table-striped table-hover table-responsive table-bordered">
            <tr>
                <th class="col-md-4 nopadding">Threads</th>
                <th class="col-md-2">Creator</th>
                <th class="col-md-2">Last Updated</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                $threadNum = $_SESSION["page"] * 10;
                while ($row = $result->fetch_assoc()) {
                    $out[] = $row;
                }
                $out[] = null;
                for ($i = $threadNum - 10; $i < $threadNum; $i++) {

                    if ($out[$i] == null) {
                        $last = true;
                        break;
                    } else {
                        $last = false;
                    }
                    $threadID = $out[$i]["id"];
                    $threadName = $out[$i]["threadname"];
                    $date = $out[$i]["datelast"];
                    $creator = $out[$i]["creator"];
                    ?>
                    <tr id=<?php echo $threadID; ?> onclick="redirectPost(id)">
                        <td><?php echo $threadName; ?></td>
                        <td><?php echo $creator; ?></td>
                        <td><?php echo $date; ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <div class="panel-footer"><?php
            $page = $_SESSION["page"];
            ?>
            <form class="form-inline" method="GET" action="threads.php"><?php
                if ($page > 1) {
                    ?>
                    <div class="form-group col-md-1 ">
                        <input class="btn btn-sm reducedPadding" type="submit" name="prevpage" value="Prev Page">
                    </div><?php
                }
                if (!$last) {
                    ?>
                    <div class="form-group col-md-1  ">
                        <input class="btn btn-sm reducedPadding" type="submit" name="nextpage" value="Next Page">
                    </div>
                    <?php
                }

                ?>
                <input type="hidden" name="topicID" value= <?php echo $topicID; ?>>
            </form>
            <div class="alignRight"> Page
                <?php echo $_SESSION["page"]; ?>
            </div>


        </div>
    </div>
</div>
    <?php } ?>

    <div class="container col-md-3 col-md-offset-1">
        <form class="form" method="GET" action="newthread.php">
            <div class="form-group">
            <input   class="form-control col-md-2" type="submit" name="submit" value="Create Thread"/>
            <input type="hidden" name="topicID" value="<?php echo $topicID; ?>">
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


    <?php } ?>


</body>
</html>
