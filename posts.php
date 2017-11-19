<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <?php
    $currentPath = basename(__FILE__);
    include_once("menu.php");
    include_once("includeHeader.php");

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
echo "<th width='100' >User</th>";
echo "<th width='500'>Content</th>";
echo "<th>Date</th>";
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
        echo "<td width='100'>" . $creator . "  </td>";
        echo "<td width='500'>" . $content . "</td>";
        echo "<td width='100'>" . $date . "</td>";
        echo "</tr>";
        echo"<br>";
    }
}
echo "</table>";
?>

<form method="GET" action = "newPost.php">
    <br>
    <br>
    <input type ="submit" name="submit" value="Create new post"/>
</form>

</body>
</html>