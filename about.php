<!DOCTYPE html>
<html lang="en">
<head>
    <title>About</title>
    <?php include_once("includeHeader.php"); ?>
</head>
<body>

<?php
$currentPath = basename(__FILE__);
include_once("menu.php");
?>

<div class="page-header col-md-offset-1">
    <h1>About</h1>
</div>

<br>


<div class="container col-md-8 col-md-offset-2 about">
    <div class="wordbreaker">
        <p>This website was designed by:
        <ul>
            <li>Kuen Wai Chan</li>
            <li>Gordon Clark</li>
            <li>Elliot Rourke</li>
            <li>Karol Groszewski</li>
            <li>Scott Pirrie</li>
        </ul>
        </p>

        <p>
            The intention of this website is to allow users to make accounts, and discuss in a forum environment. As
            such, users are identified as one of several ranks:
        <ul>
            <li>Not logged in:
                <ul>
                    <li>Users can view topics/threads labelled "Anyone".</li>
                    <li>Cannot post to a thread.</li>
                </ul>
            </li>

            <br>

            <li>Normal User:
                <ul>
                    <li>A typical user, can view topics/threads labelled "Logged in & Good Standing" & below.</li>
                    <li>Can post to threads they can view.</li>
                    <li>Can create threads in topics they can view.</li>
                </ul>
            </li>

            <br>

            <li>Moderators:
                <ul>
                    <li>Can view topics/threads labelled "Moderators" and below.</li>
                    <li>Can post to threads they can view.</li>
                    <li>Can create threads in topics they can view.</li>
                    <li>Can create topics which have required permissions.</li>
                    <li>Can manipulate permissions of accounts that are not Admins. (i.e. Ban)</li>
                </ul>
            </li>

            <br>

            <li> Admins:
                <ul>
                    <li>Can view topics/threads labelled "Admins" and below.</li>
                    <li>Can post to threads they can view.</li>
                    <li>Can create threads in topics they can view.</li>
                    <li>Can create topics which have required permissions.</li>
                    <li>Can manipulate permissions of accounts that are not Admins. (i.e. Ban)</li>
                    <li>Has access to an increased operations set: Clearing forum.</li>
                </ul>
            </li>

            <br>

            <li> Banned users:
                <ul>
                    <li>Can view topics/threads labelled "Anyone"</li>
                    <li>Cannot post to a thread.</li>
                </ul>
            </li>
        </ul>
        </p>

        <p>Users also have the ability to change password, when logged in.</p>

        <br>
        <br>

        <p>This page was made using Bootstrap 3.3.7. With resources from:
        <ul>
            <li><a href="https://www.w3schools.com/bootstrap/default.asp">W3Schools</a></li>
            <li><a href="http://bootstrapdocs.com/v3.0.3/docs/css/">Bootstrap Official</a></li>
        </ul>
        </p>

        <br>

        <p>
            For the purpose of demonstration, the following accounts have been made with the passwords "1234":
        <ul>
            <li>"Banned"</li>
            <li>"Normal"</li>
            <li>"Moderator"</li>
            <li>"Admin"</li>
        </ul>

        </p>
    </div>

</div>


</body>
</html>