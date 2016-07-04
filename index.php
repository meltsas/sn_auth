<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="SocialLogin_unlocked.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!--    <link rel="stylesheet" href="assets/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Social Login Demo</title>
</head>

<body>
<div class="header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggle" data-target=".navbar-responsive-collapse" data-toggle="collapse"
                    type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-header">
            <span class="navbar-brand">
                SOCIAL LOGIN DEMO
            </span>

            </div>

            <div class="collapse navbar-collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li><a class="btn" data-toggle="modal" data-target="#aboutModal">About</a></li>
                    <!--                <li><a class="btn" onclick="window.open('https://youtube.com', 'newwindow', 'width=500, height=700'); return false;">YouTube</a></li>-->

                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a style="color:#3b5998;" href="auth/?provider=facebook" class="hi-icon btn btn-sm"
                           data-toggle="tooltip" title="Facebook login">
                            <span class="fa fa-facebook fa-2x"></span> login</a>
                    </li>
                    <li><a style="color:#d34836;" href="auth/?provider=google" class="hi-icon btn btn-sm"
                           data-toggle="tooltip" title="Google+ login">
                            <span class="fa fa-google-plus fa-2x"></span> login</a>
                    </li>
                    <li><a style="color:#0077B5;" href="auth/?provider=linkedin" class="hi-icon btn btn-sm"
                           data-toggle="tooltip" title="LinkedIn login">
                            <span class="fa fa-linkedin fa-2x"></span> login</a>
                    </li>
                    <li><a style="color:#1dcaff;" href="auth/?provider=twitter" class="hi-icon btn btn-sm"
                           data-toggle="tooltip" title="Twitter login">
                            <span class="fa fa-twitter fa-2x"></span> login</a>
                    </li>
                    <li><a style="color:black;" href="auth/?provider=github" class="hi-icon btn btn-sm"
                           data-toggle="tooltip" title="Github login">
                            <span class="fa fa-github fa-2x"></span> login</a>
                    </li>

                </ul>
            </div>
        </div>

    </nav>
</div>

<!-- Modal for About-->
<div id="aboutModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal Sing In content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">About SocialLogin</h4>
            </div>
            <div class="modal-body">

                <p><i>SocialLogin</i> is simple PHP adapter for implementing OAuth sing in by different popular providers.
                    SocialLogin currently supports 5 popular providers (Facebook, Goolge, LinkedIn, Twitter and Github).
                    SocialLogin is using only PHP open source libraries.
                </p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="container">
    <?php

    if (isset($_SESSION['payload']) && isset($_SESSION['provider'])) { ?>

        <h2>You logged in with your <strong><?= ucfirst($_SESSION['provider']) ?></strong> account</h2>
        <h5>PAYLOAD DETAILS: </h5>
        <pre><?php print_r($_SESSION['payload']);?></pre>
        <br />
        <br />

        <?php
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(), '', 0, '/');
        session_regenerate_id(true);

    } else {
        echo "<h2>You are not logged in!</h2>";
    }
    ?>

</div>


</body>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</html>