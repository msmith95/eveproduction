<html>
    <head>
        <title>Login/Register</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="include/cookies.js"></script>
        <script src="include/include.js"></script>
         <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
         <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="style.css" >
        <link rel="stylesheet" type="text/css" href="menu.css">
        <script src="include/menu.js"></script>

        <script>
            $(document).ready(function (){
                $('#registerBox').hide();
                $( document ).tooltip();
            });
            function login(){
                var user = document.getElementById("loginUsername").value;
                var pass = document.getElementById("loginPassword").value;
                console.log(user + " " + pass);

                $.post("backend/processLogin.php", {username: user, password: pass}, function (result){
                    var json = $.parseJSON(result);
                    //console.log(json);
                    //console.log(result);
                    if(json.success == 1){
                        console.log("Success");
                        setCookie("username", user, 7);
                        setCookie("loggedIn", 1, 7);
                        setCookie("permissions", json.permissions, 7);
                        setCookie("corporation", json.corporation, 7);
                        setCookie("alliance", json.alliance, 7);
                        setCookie("hasStore", json.store, 7);
                        window.location = "http://www.newelementgaming.net/eve/index.php?action=loggedIn";
                    }else{
                        $('.added').html("Incorrect username/password");
                        $('.added').stop().fadeIn(400).delay(3000).fadeOut(400);
                        $('#loginPassword').val("");
                    }
                });
            }

            function register(){
                var url = "https://api.eveonline.com/account/characters.xml.aspx";
                var user = document.getElementById("registerUsername").value;
                var password = document.getElementById("registerPassword").value;
                var confirm = document.getElementById("verifyRegisterPassword").value;
                var id = document.getElementById("registerKeyID").value;
                var vCode = document.getElementById("registerKeyCode").value;
                var corp;
                var alliance;

                if(password != confirm){
                    $('.added').html("Passwords do not match");
                    $('.added').stop().fadeIn(400).delay(3000).fadeOut(400);
                    console.log(password + " " + confirm);
                    return;
                }

                var xhr = $.get(url, {keyID: id, vCode: vCode}, function(result, status, xhr){
                    var t = $(result).find("row");
                    for(var i = 0; i<t.length; i++){
                        var row = $(t[i]);
                        corp = row.attr("corporationName");
                        alliance = row.attr("allianceName");
                        console.log(corp + " " + alliance);
                        if(alliance == "Alternate Allegiance")
                            break;
                    }
                    if(alliance == "Alternate Allegiance"){
                        $.post("backend/processRegistration.php", {username: user, password: password, apiKey: id, apiVcode: vCode, corp: corp, alliance: alliance}, function(result){
                            console.log(result);
                            var json = $.parseJSON(result);
                            if(json.success == 1){
                                console.log("Success");
                                setCookie("username", user, 7);
                                setCookie("loggedIn", 1, 7);
                                setCookie("permissions", 1000, 7);
                                setCookie("corporation", corp, 7);
                                setCookie("alliance", alliance, 7);
                                setCookie("hasStore", 0, 7);
                                window.location = "http://www.newelementgaming.net/eve/index.php?action=loggedIn";
                            }
                        });
                    }else{
                        $('.added').html("You are not a member of Alternate Allegiance.");
                        $('.added').stop().fadeIn(400).delay(3000).fadeOut(400);
                    }

                }).fail(function(){
                    console.log(xhr);
                    console.log(xhr.status);
                    if(xhr.status == '400'){
                        $('.added').html("Invalid API Key");
                        $('.added').stop().fadeIn(400).delay(3000).fadeOut(400);
                    }
                });
            }
            function showLogin(){
                $('#registerBox').hide();
                $('#loginBox').show();
            }
            function showRegister(){
                $('#loginBox').hide();
                $('#registerBox').show();
            }
        </script>
    </head>

    <body>
        <div class="container">
        <h1>Alternate Allegiance Production</h1>
             <?php include 'include/menu.php';?>
        </div>
        <div class="largerText">
            <h1 class="bodyHeader">Login/Register</h1>
            <div class='added' style='display:none'></div>
            <div id="loginContent">
                <div id="loginBox">

                    <div>
                        <label for="loginUsername">Username:</label>
                        <input type="text" name="loginUsername" id="loginUsername" placeholder="Username">
                    </div>
                    <div>
                        <label for="loginPassword">Password:</label>
                        <input type="password" name="loginPassword" id="loginPassword" placeholder="Password">
                    </div>
                    <div class="center">
                        <button onclick="login()">Login!</button>
                        <br />
                        <a href="#" onclick="showRegister()">Create a new account</a>
                    </div>

                </div>

                <div id="registerBox">

                    <div>
                        <label for="registerUsername">Username:</label>
                        <input type="text" name="registerUsername" id="registerUsername" placeholder="Username" title="Your in-game character name">
                    </div>
                    <div>
                        <label for="registerPassword">Password:</label>
                        <input type="password" name="registerPassword" id="registerPassword" placeholder="Password">
                    </div>
                    <div>
                        <label for="verifyRegisterPassword">Password:</label>
                        <input type="password" name="verifyRegisterPassword" id="verifyRegisterPassword" placeholder="Confirm Password">
                    </div>
                    <div>
                        <label for="registerKeyID">Api Key ID:</label>
                        <input type="text" name="registerKeyID" id="registerKeyID" placeholder="API Key ID" title="A valid key ID for an API that has character sheet access">
                    </div>
                    <div>
                        <label for="registerKeyCode">API vCode</label>
                        <input type="text" name="registerKeyCode" id="registerKeyCode" placeholder="API Key vCode" title="A valid vCode for an API that has character sheet access">
                    </div>
                    <div class="center">
                        <button onclick="register()">Register!</button>
                        <br />
                        <a href="#" onclick="showLogin()">Login to an existing account</a>
                    </div>

                </div>
            </div>
        </div>
    </body>

</html>