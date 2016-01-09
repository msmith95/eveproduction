<?php
    session_start();
    include 'include/permissions.php';
    if((int)$loggedIn != 1 || (int)$member != 1 || (int)$leadership != 1){
        header('Location: http://newelementgaming.net/eve/notLoggedIn.html');
    }
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
        var members;
        $(document).ready(function (){
            $.post("backend/getUsers.php", function(result){
                console.log(result);
                var json = $.parseJSON(result);
                members = json;
                for(var i = 0; i<json.count; i++){
                    $("#members").append("<option value='" + json[i] + "'>" + json[i] + "</option>");
                    $("#membersPerms").append("<option value='" + json[i] + "'>" + json[i] + "</option>");
                }
            });


        });

        function kick(){
            //console.log($("#members option:selected").val());
            $("#confirmKick").css("display", "inline");
        }
        function confirmKick(){
            //console.log($("#members option:selected").val());
            $('.added').html($("#members option:selected").val() + " has been kicked!");
            $('.added').stop().fadeIn(400).delay(3000).fadeOut(400);
        }

        function getPerms(){
            var user = $("#membersPerms").val();
            if(user != ""){
                 $.post("backend/getPerms.php", {user: user}, function(data){
                    var json = $.parseJSON(data);
                    console.log(json);
                    var member = json.permissions.charAt(0);
                    var industry = json.permissions.charAt(1);
                    var ceo = json.permissions.charAt(2);
                    var leadership = json.permissions.charAt(3);

                    console.log(member + " " + industry + " " + ceo + " " + leadership);

                    if(member == 1 ){
                        //$("#member").prop("checked")
                        document.getElementById("member").checked = true;
                    }else{
                        document.getElementById("member").checked = false;
                    }

                    if(industry == 1){
                        document.getElementById("industry").checked = true;
                    }else{
                        document.getElementById("industry").checked = false;
                    }

                    if(ceo == 1){
                        document.getElementById("ceoDir").checked = true;
                    }else{
                        document.getElementById("ceoDir").checked = false;
                    }

                    if(leadership == 1){
                        document.getElementById("leadership").checked = true;
                    }else{
                        document.getElementById("leadership").checked = false;
                    }
                });
            }else{
                document.getElementById("member").checked = false;
                document.getElementById("industry").checked = false;
                document.getElementById("ceoDir").checked = false;
                document.getElementById("leadership").checked = false;
            }

        }

        function savePerms(){
            var member = 0;
            var industry = 0;
            var ceo = 0;
            var leadership = 0;
            if(document.getElementById("member").checked){
                member = 1;
            }

            if(document.getElementById("industry").checked){
                industry = 1;
            }

            if(document.getElementById("ceoDir").checked){
                ceo = 1;
            }

            if($document.getElementById("leadership").checked){
                leadership = 1;
            }

            var permissions = "" + member + industry + ceo + leadership;
            var user = $("#membersPerms").val();
            if(user != ""){
                $.post("backend/savePerms.php", {user: user, perms: permissions});
                $('.added').html("Your changes have been saved!");
                $('.added').stop().fadeIn(400).delay(3000).fadeOut(400);
            }
            
        }
        </script>
    </head>

    <body>
        <div class="container">
        <h1>Alternate Allegiance Production</h1>
             <?php include 'include/menu.php';?>
        </div>
        <div id="bodyContainer">
            <h1 class="bodyHeader">Alliance Leadership Panel</h1>
            <div id="kickMembers">
                <select id="members"><option value = "">Select a user...</option></select>
                <button onclick="kick()" id="kickMemberButton">Kick member from corporation/alliance</button>
                <br />
                <button onclick="confirmKick()" id="confirmKick">Confirm Member Kick</button>
            </div>
            <br />
            <br />
            <div id="managePerms">
                <select id="membersPerms" onchange="getPerms()"><option value = "">Select a user...</option></select>
                <div><input type="checkbox" name="member" value=0 id="member">Member</input></div>
                <div><input type="checkbox" name="industry" value=0 id="industry">Industry</input></div>
                <div><input type="checkbox" name="ceoDir" value=0 id="ceoDir">CEO/DIR</input></div>
                <div><input type="checkbox" name="leadership" value=0 id="leadership">Leadership</input></div>
                <button onclick="savePerms()">Save changes</button>
            </div>
            <div id="productionStatistics">

            </div>
            <div class='added' style='display:none'></div>
        </div>
    </body>

</html>