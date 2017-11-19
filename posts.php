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
                }else{
                    echo"<p>Post not created. An error has occurred.</p>";
                }
                $_SESSION["hasPosted"] = true;
            }
        }
    }
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["nextpage"])){
        $_SESSION["page"]++;
    } elseif(isset($_GET["nextpage"])){
        if($_SESSION["page"] > 1){
            $_SESSION["page"]--;
        }
    } else{
        $_SESSION["page"] = 1;
    }

}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    $threadID = $_GET["threadID"];
    $_SESSION["threadID"] = $threadID;
}else{
    $threadID = $_SESSION["threadID"];
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
    $threadNum = $_SESSION["page"]*10;
    while($row = $result->fetch_assoc()){
        $out[] = $row;
    }
    $out[] = null;
    for($i = $threadNum-10; $i< $threadNum; $i++) {

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
}
echo "</table>";
?>

<form method="GET" action = "newPost.php">

    <input type ="submit" name="submit" value="Create new post"/>
</form>

</body>
</html>