<!DOCTYPE html>
<html lang="en">
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
    <h1>Search Results</h1>
</div>

<form action="searchResults.php" method="get">
    Search for a Post :0 <input type="text" name="searchText"> <input type="submit" name="searchButton"><br/><br/>
</form>

<?php
strip_tags($search = isset($_GET["searchText"]) ? $_GET["searchText"] : "");

if ($search != "") {
$sql = "SELECT * FROM `Threads` WHERE `threadname` LIKE '%".mysqli_real_escape_string($conn, $search)."%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
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
    } else {
    ?> <p>No Results found</p> <?php
}
} else {
    ?> <p>No Results found</p> <?php
}
?>