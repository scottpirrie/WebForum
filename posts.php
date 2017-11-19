<!DOCTYPE html>
<html lang="en">
<style>
    table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
    }

    td, th {
        border: 1px solid #ddd;
        padding-left: 8px;
        padding-right: 32px;
    }

    tr:nth-child(even){background-color: #f2f2f2;}

    tr:hover {background-color: #ddd;}

    th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>
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
                $sql = "INSERT INTO `Posts`(`threadid`, `postnumber`, `creator`, `date`, `content`) VALUES ('$threadID',0,'$user','$date','$postContent')";

                if($conn->query($sql)){
                    echo "<p>Post created successfully</p>";
                }else{
                    echo"<p>Post not created RURURRU</p>";
                    echo"<p>----->>>>> $threadID</p>";
                    echo"<p>$postContent</p>";
                    echo"<p>$user</p>";
                    echo"<p>$date</p>";
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
echo "<th width='100' >Creator</th>";
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
        echo "<td>" . $date . "</td>";
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