<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forum</title>
    <?php
    $currentPath = basename(__FILE__);
    include_once("includeHeader.php");
    include_once("menu.php");
    ?>
</head>

<body>

<h1>
    Forum
</h1>

<div class="container-fluid">
<?php


    if($_SERVER["REQUEST_METHOD"]== "POST") {
        if(isset($_POST["createPost"])) {
            if(isset($_SESSION["hasPosted"])){
                if($_SESSION["hasPosted"]==false){
                    $postContent = cleanStr($_POST["postContent"], $conn); //Do we want to clean the post??
                    $threadID = $_SESSION["threadID"];
                    $user = $_SESSION["user"];
                    $date = date('Y-m-d H:m:s', time());
                    $sql = "INSERT INTO `Posts`(`threadid`, `creator`, `date`, `content`) VALUES ('$threadID','$user','$date','$postContent')";

                    if($conn->query($sql)){
                        echo "<p>Post created successfully</p>";
                        $sql = "UPDATE `Threads` SET `datelast` = '$date' WHERE `id` = '$threadID'";
                        $conn->query($sql);
                    }else{
                        echo"<p>Post not created. An error has occurred.</p>";
                    }
                    $_SESSION["hasPosted"] = true;
                }
            }
        }
    }
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["nextpostpage"])){
            $_SESSION["postPage"]++;
        } elseif(isset($_GET["prevpostpage"])){
            if($_SESSION["postPage"] > 1){
                $_SESSION["postPage"]--;
            }
        } else{
            $_SESSION["postPage"] = 1;
        }

    }

    if($_SERVER["REQUEST_METHOD"] == "GET"){
        if(isset($_GET["threadID"])){
            $threadID = $_GET["threadID"];
            $_SESSION["threadID"] = $threadID;
        }elseif (isset($_SESSION["threadID"])){
            $threadID = $_SESSION["threadID"];
        }
    }else{
        $threadID = $_SESSION["threadID"];
    }

    if(!isset($threadID)) {
        ?><script> redirectTopics();</script><?php
    }

    $sql = "SELECT * FROM `Posts` WHERE `threadid` = '$threadID'";
    $result = $conn->query($sql);
    echo "<table>";
    echo "<tr>";
    echo "<th>User</th>";
    echo "<th>Content</th>";
    echo "<th>Date</th>";
    echo "</tr>";
    if ($result->num_rows > 0) {
        $postNum = $_SESSION["postPage"]*10;
        while($row = $result->fetch_assoc()){
            $out[] = $row;
        }
        $out[] = null;
        for($i = $postNum-10; $i< $postNum; $i++) {

            if($out[$i] == null){
                $last = true;
                break;
            } else {
                $last = false;
            }
            $creator = $out[$i]["creator"];
            $content = $out[$i]["content"];
            $date = $out[$i]["date"];
            echo "<tr>";
            echo "<td>" . $creator . "  </td>";
            echo "<td>" . $content . "</td>";
            echo "<td>" . $date . "</td>";
            echo "</tr>";
        }
    }elseif($result->num_rows == 0){
        $last = true;
    }
    echo "</table>";

    $postPage = $_SESSION["postPage"];
    echo "<p>Page $postPage</p>"
    ?>
    <form name="changePostPage" method = "GET" action = "posts.php">
    <?php
        if($postPage > 1) {
            ?>
            <input type="submit" name="prevpostpage" value="Previous Page">
            <?php
        }
        if(!$last) {
            ?>
            <input type="submit" name="nextpostpage" value="Next Page">
            <?php
        }
    ?>
    </form>
</div>

<div>
    <form name="newPost" method="POST" action = "newPost.php">
        <input type ="submit" name="submit" value="Create new post"/>
    </form>
</div>
</body>
</html>