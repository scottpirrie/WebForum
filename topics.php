<!DOCTYPE html>
<html lang="en">
<head>
    <title>Topics</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>


<div class="page-header col-md-offset-1">
    <h1>Topics</h1>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create"])) {
        if (isset($_SESSION["hasCreated"])) {
            if ($_SESSION["hasCreated"] == false) {
                $topicName = cleanStr($_POST["topicName"], $conn);
                $type = $_POST["type"];
                $date = date('Y-m-d H:m:s', time());
                $sql = "INSERT INTO `Topics` (`name`, `type`) VALUES ('$topicName', '$type')";

                if ($conn->query($sql)) {

                    ?>
                    <div class="alert alert-success">
                        <strong>Topic created successfully.</strong>
                    </div> <?php
                }
                $_SESSION["hasCreated"] = true;
            }
        }
    }
}


$sql = "SELECT * FROM `Topics`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    if (!isset($_SESSION['page'])) {
        $_SESSION['page'] = 1;
    }
    $topicNum = $_SESSION["page"] * 10;
    while ($row = $result->fetch_assoc()) {
        $out[] = $row;
    }
    $out[] = null;
    for ($i = $topicNum - 10; $i < $topicNum; $i++) {

        if ($out[$i] == null) {
            $last = true;
            break;
        } else {
            $last = false;
        }
    }
} else {
    $last = true;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
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

}
$sql = "SELECT * FROM `Topics`";
$result = $conn->query($sql);
?>
<div class="container col-md-10 col-md-offset-1">
    <div class="panel panel-default">

        <table class="table-striped table-hover table-responsive table-bordered">
            <tr>
                <th class="col-md-4 nopadding">Topics</th>
                <th>Required Permissions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                $topicNum = $_SESSION["page"] * 10;
                while ($row = $result->fetch_assoc()) {
                    $out[] = $row;
                }
                $out[] = null;
                for ($i = $topicNum - 10; $i < $topicNum; $i++) {

                    if ($out[$i] == null) {
                        $last = true;
                        break;
                    } else {
                        $last = false;
                    }
                    $topicID = $out[$i]["id"];
                    $topicName = $out[$i]["name"];
                    $type = $out[$i]["type"];

                    if ($_SESSION['type'] >= $type) {
                        ?>


                        <tr id="<?php echo $topicID; ?>" onclick="redirectThread(id)">
                            <td><?php echo $topicName; ?></td>
                            <td><?php
                                if ($type < 1) {
                                    echo "Anyone";
                                } else if ($type == 1) {
                                    echo "Logged in & Good Standing";
                                } elseif ($type == 2) {
                                    echo "Moderators";
                                } elseif ($type == 3) {
                                    echo "Admins";
                                }

                                ?></td>
                        </tr>


                        <?php
                    }


                }
            } else {
                $last = true;
            }


            ?>
        </table>

        <div class="panel-footer">

            <div>
                <form class="form-inline" method="GET" action="topics.php">
                    <?php
                    $page = $_SESSION['page'];
                    if ($page > 1) {
                    ?>
                    <div class="form-group col-md-1 ">
                        <input class="btn btn-sm reducedPadding" type="submit" name="prevpage" value="Prev Page">
                    </div>
                       <?php
                        } ?> <?php
                    if (!$last) {
                        ?>
                        <div class="form-group col-md-1  ">
                            <input class="btn btn-sm reducedPadding" type="submit" name="nextpage"
                                   value="Next Page">
                        </div>
                    <?php } ?>
                    <div class="alignRight"> Page
                        <?php echo $_SESSION["page"]; ?>
                    </div>
                </form>
            </div>

        </div>


    </div>
</div>


<?php
if ($_SESSION['type'] > 1) { ?>


    <div class="container col-md-3 col-md-offset-1">

        <form class="form" method="GET" action="newtopic.php">
            <div class="form-group">
                <input class="form-control col-md-2" type="submit" name="submit" value="Create New Topic"/>

            </div>

        </form>


    </div>


<?php }

?>


</body>
</html>
