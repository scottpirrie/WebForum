<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Admin</title>
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

<form action="searchResults.php" method="get">
    Search for a Post :0 <input type="text" name="searchText"> <input type="submit" name="searchButton"><br/><br/>
</form>

<?php
if($_SERVER["REQUEST_METHOD"]== "POST") {
    if(isset($_POST["create"])) {
        if(isset($_SESSION["hasPosted"])){
            if($_SESSION["hasPosted"]==false){
                $threadName = cleanStr($_POST["threadName"], $conn);
                $user = $_SESSION["user"];
                $date = date('Y-m-d H:m:s', time());
                $sql = "INSERT INTO `Threads` (`threadname`, `creator`, `date`) VALUES ('$threadName', '$user', '$date')";

                if($conn->query($sql)){
                    echo "<p>Thread created successfully</p>";
                }
                $_SESSION["hasPosted"] = true;
            }
        }
    }
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["nextpage"])){
        $_SESSION["page"]++;
    } elseif(isset($_GET["prevpage"])){
        if($_SESSION["page"] > 1){
            $_SESSION["page"]--;
        }
    } else{
        $_SESSION["page"] = 1;
    }

}
$sql = "SELECT * FROM `Threads`";
$result = $conn->query($sql);
echo "<table>";
echo "<tr>";
echo "<th>Threads</th>";
echo "<th>Creator</th>";
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
        $threadID = $out[$i]["id"];
        $threadName = $out[$i]["threadname"];
        $date = $out[$i]["date"];
        $creator = $out[$i]["creator"];

        echo "<tr id=$threadID ondblclick=\"redirectPost(id)\">";
        echo "<td>" . $threadName . "</td>";
        echo "<td>" . $creator . "</td>";
        echo "<td>" . $date . "</td>";
        echo "</tr>";
    }
}
echo "</table>";
$page = $_SESSION["page"];
echo "<p>Page $page</p>"
?>
<form method = "GET" action = "home.php"><?php
    if($page > 1) {
        ?>
        <input type="submit" name="prevpage" value="Previous Page">
        <?php
    }
    if(!$last) {
        ?>
        <input type="submit" name="nextpage" value="Next Page">
        <?php
    }
    ?>
</form>

<form method="GET" action = "newthread.php">
    <input type ="submit" name="submit" value="Create New Thread"/>
</form>

</body>
</html>
