<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>

    body {
        color: #414141;
        font-family: Tahoma, Geneva, sans-serif;
        background-color: #fffcfc;
    }

    .navbar,
    .navbar-header,
    .nav-item,
    .nav-link {
        background-color: #E6E4FF;
    }

    .navbar-toggle {
        background-color: #beb9f7; 
    }

    .navbar-inverse .navbar-brand,
    .navbar-inverse .navbar-nav > li > a {
        color: #46264C
    }

    .navbar-inverse .navbar-brand:hover,
    .navbar-inverse .navbar-brand:focus {
        color: black;
    }

    .navbar-inverse .navbar-nav > li > a:hover,
    .navbar-inverse .navbar-nav > li > a:focus {
        color: #C73B2E;
    }

    .navbar-inverse .navbar-nav > .active > a,
    .navbar-inverse .navbar-nav > .active > a:hover,
    .navbar-inverse .navbar-nav > .active > a:focus {
        color: #46264C;
        background-color: #F5EEC8;
    }

    .navbar-inverse .navbar-toggle {
        border-color: #C73B2E;
    }

    /* Essential */

    @media (max-width: 767px) {
        .navbar-nav {
            margin: 0;
            padding: 0;
        }
    }



    .nopadding {
         margin-top:0;
         margin-bottom: 0;
         margin-right: 0;
         margin-left: 0;

         padding-top:0;
         padding-bottom: 0;
         padding-right: 0;
         padding-left: 0;


     }

    .reducedPadding {
        padding: 3px;

    }
    textarea {
        resize: none;
    }

    .align-top {
        vertical-align: top;
    }

    .verticalSpacer {
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .verticalTopSpacer {
        margin-top: 15px;
    }

    .verticalBottomSpacer {
        margin-bottom: 15px;
    }

    .horizontalRightSpacer {
        margin-right: 8px;
    }

    .horizontalLeftSpacer {
        margin-left: 8px;
    }

    .alignRight {
        text-align: right;
    }

    /*Table only, will re-write if needed*/
    table {
        word-wrap: break-word;
        overflow-wrap: break-word;

        border-collapse: collapse;
        width: 100%;
        table-layout: fixed;

    }

    th, td {
        padding-top: 5px !important;
        padding-bottom: 5px !important;
        padding-left: 8px !important;
        padding-right: 8px !important;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

</style>
