<?php
function loadDB(){
    $servername = "devweb2017.cis.strath.ac.uk";
    $username = "cs312_k";
    $password = "Aithu0ochoo9";
    $dbname = $username;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: Unable to connect to tournament database");
    }
    return $conn;
}

function cleanStr($in, $conn){
    if(!($in == null)) {
        $in = trim($in);
        $in = htmlspecialchars($in);
        $in = $conn->real_escape_string($in);
    }
    return $in;
}

function createAdminAccount($conn){
    $pass = password_hash("abcd", PASSWORD_BCRYPT);
    $sql = "INSERT INTO `Login` (`id`, `username`, `password`, `type`) VALUES (1, 'admin', '$pass', '1')";
    $conn->query($sql);
}

?>