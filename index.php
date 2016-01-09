<?php
    include 'include/permissions.php';

    if($_GET['action'] == "loggedIn"){
        $timeout = 7*24*60*60*10;
        ini_set("session.gc_maxlifetime", $timeout);
        ini_set("session.cookie_lifetime", $timeout);
        session_start();
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['loggedIn'] = 1;
        $_SESSION['permissions'] = $_COOKIE['permissions'];
        $_SESSION['corporation'] = $_COOKIE['corporation'];
        $_SESSION['alliance'] = $_COOKIE['alliance'];
        $_SESSION['hasStore'] = $_COOKIE['hasStore'];
    }
   include 'include/sessions.php';
?>


<html>
    <head>
        <title>Alternate Allegiance Production</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="include/cookies.js"></script>
        <script src="include/include.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css" >
        <link rel="stylesheet" type="text/css" href="menu.css">
        <script src="include/menu.js"></script>
        <script>
            var action = "<?php echo $_GET['action']?>";
            if(action === "loggedIn"){
                setCookie("username", '', 7);
                setCookie("loggedIn", 0, 7);
                setCookie("permissions", '', 7);
                setCookie("corporation", '', 7);
                setCookie("alliance", '', 7);
                setCookie("hasStore", '', 7);
                window.location = "http://www.newelementgaming.net/eve/index.php";
            }

        </script>
    </head>

    <body>
        <div class="container">
        <h1>Alternate Allegiance Production</h1>
            <?php include 'include/menu.php';?>
        </div>
        <div id="bodyContainer">
            <h1 class="bodyHeader">Welcome to the Alternate Allegiance Production Site!</h1>
            <div id="indexContent">
                <p id="welcomeText">Welcome to the production website for Alternate Allegiance!  Please register for an account above.  Once your API is verified,
                you will be granted access to the stores managed by the corporations of Alternate Allegiance.  Using those corporate stores you may
                order a variety of ships and modules which will be produced and delivered based upon the rules and procedures that the corporation
                has established.  If you experience any issues using this website, please contact Marksman81 Orti in game and he will
                look into the issue as soon as possible.
                </p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/5qxZFmIaynE" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </body>

</html>