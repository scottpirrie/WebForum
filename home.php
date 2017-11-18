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

    ?>
</head>
<body>

<h1>
    Forum
</h1>
<?php

if($_SERVER["REQUEST_METHOD"]== "POST") {
    if(isset($_POST["create"])) {
        $threadName = cleanStr($_POST["threadName"], $conn);
        $user = $_SESSION["user"];
        $date = date('Y-m-d H:m:s', time());
        $sql = "INSERT INTO `Threads` (`threadname`, `creator`, `date`) VALUES ('$threadName', '$user', '$date')";
        if($conn->query($sql)){
            echo "<p>Thread created successfully</p>";
        }

    }
}

    $sql = "SELECT * FROM `Threads`";
    $result = $conn->query($sql);
    echo "<table>";
    echo "<th>Threads</th>";
    echo "<th>Creator</th>";
    echo "<th>Date</th>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $threadName = $row["threadname"];
            $date = $row["date"];
            $creator = $row["creator"];
            echo "<tr>";
            echo "<td>" . $threadName . "</td>";
            echo "<td>" . $creator . "</td>";
            echo "<td>" . $date . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    ?>
    <form method="POST" action = "newthread.php">
        <input type ="submit" name="submit" value="Create new post"/>
    </form>

</body>
</html>