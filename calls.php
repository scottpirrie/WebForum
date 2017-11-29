<?php
session_start();
$_SESSION["user"] = isset($_SESSION["user"]) ? $_SESSION["user"] : "";
$_SESSION['type'] = 0;

$conn = loadDB();

function loadDB()
{
    $servername = "devweb2017.cis.strath.ac.uk";
    $username = "cs312_k";
        $password = "Aithu0ochoo9";
    $dbname = $username;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        echo "Please refresh";
    }

    return $conn;
}

function cleanStr($in, $conn)
{
    if (!($in == null)) {
        $in = trim($in);
        $in = htmlspecialchars($in);
        $in = $conn->real_escape_string($in);
    }
    return $in;
}

function createAdminAccount($conn)
{
    $pass = password_hash("abcd", PASSWORD_BCRYPT);
    $sql = "INSERT INTO `Login` (`id`, `username`, `password`, `type`) VALUES (1, 'admin', '$pass', '1')";
    $conn->query($sql);
}

function compareFile($desiredPath, $actualPath)
{
    if ($desiredPath == $actualPath) {
        echo " active";
    }
}

function logOff()
{
    $_SESSION['type'] = 0;
    $_SESSION['user'] = "";
    unset($_SESSION['topicID']);
    unset($_SESSION['threadID']);
}
?>

<script>
    function incorrectLogin() {
        alert("Could not login." + "\n" +
            "Details did not correspond to any known account.")
    }

    function redirect() {
        window.location = "threads.php";
    }

    function redirectPost(id) {
        window.location = "posts.php?threadID="+id;
    }

    function redirectThread(id){
        window.location = "threads.php?topicID=" + id;
    }
    function redirectTopics(){
        window.location = "topics.php";
    }

    function checkUsernameSpaces() {
        var attemptedName = document.forms["register"]["newUsername"].value;

        if (attemptedName.includes(" ")) {
            document.forms["register"]["newUsername"].value = "";
            document.forms["register"]["newPassword"].value = "";
            alert("Username cannot contain spaces.");
            return false;
        }

        if (attemptedName.includes(">")) {
            document.forms["register"]["newUsername"].value = "";
            document.forms["register"]["newPassword"].value = "";
            alert("Username cannot contain '>'.");
            return false;
        }

        if (attemptedName.includes("<")) {
            document.forms["register"]["newUsername"].value = "";
            document.forms["register"]["newPassword"].value = "";
            alert("Username cannot contain '<'.");
            return false;
        }

        return true;

    }

</script>

