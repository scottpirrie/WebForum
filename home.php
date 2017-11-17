<?php
function safePOST($conn,$name){
    if(isset($_POST[$name])){
        return $conn->real_escape_string(strip_tags($_POST[$name]));
    } else {
        return "";
    }
}

//Connect
$host = "devweb2017.cis.strath.ac.uk";
$user = "cs312_k";
$password = "Aithu0ochoo9";
$dbname = "cs312_k";
$conn = new mysqli($host,$user,$password,$dbname);

if ($conn->connect_error){
    die("Connection failed : ".$conn->connect_error); //FIXME remove once working.
}
$action = safePost($conn,"action");
?>

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
</head>
<body>
<h1>
    Forum
</h1>
<?php

if($action=="newpost") {
    ?>
    <form method="post">
        Thread title<input type="text" name="threadName">
        <input type="hidden" name="action" value="createthread">
        <button type="submit">Post</button>
    </form>
    <?php
}else if($action=="createthread"){
    $threadName=$_POST["threadName"];

    $sql="INSERT INTO `Threads` (`id`, `threadname`, `creatorid`, `date`) VALUES (NULL, '$threadName', '1', '2017-11-16')";
    $conn->query($sql);

    echo "<p>Thread created successfully";

    ?>
    <form method="post">
        <button type="submit" name="action" value="">Return to Forum</button>
    </form>
    <?php

}else{

    $sql = "SELECT * FROM `Threads`";
    $result = $conn->query($sql);
    echo "<table>";
    echo "<th>Threads</th>";
    echo "<th>Date</th>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $threadName = $row["threadname"];
            $date = $row["date"];
            echo "<tr>";
            echo "<td>" . $threadName . "</td>";
            echo "<td>" . $date . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
    ?>
    <form method="post">
        <input type="hidden" name="action" value="newpost">
        <input type ="submit" name="submit" value="Create new post"/>
    </form>
    <?php
}
?>
</body>
</html>