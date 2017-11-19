<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home Page</title>
    <?php include_once("includeHeader.php"); ?>

    <style>
        .fluidMedia {
            position: relative;
            padding-bottom: 56.25%; /* proportion value to aspect ratio 16:9 (9 / 16 = 0.5625 or 56.25%) */

        }
        #memeFrame {
            position: absolute;
            width: 100%;
            height: 100%;
        }

    </style>


</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>

<div class="container-fluid">
    <div class="fluidMedia">
    <iframe id="memeFrame" src="https://www.youtube.com/embed/ZFC9mjdfcUo" allowfullscreen></iframe>
</div>
</div>

</body>
</html>