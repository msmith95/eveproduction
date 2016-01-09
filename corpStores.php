<?php
    include 'include/permissions.php';
    if((int)$loggedIn != 1 || (int)$member != 1){
        header('Location: http://newelementgaming.net/eve/notLoggedIn.html');
    }
?>
<html>
    <head>
        <title>Corporate Stores</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="include/cookies.js"></script>
        <script src="include/include.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css" >
        <link rel="stylesheet" type="text/css" href="menu.css">
        <script src="include/menu.js"></script>

        <script>
        $(document).ready(function (){
            $.post("backend/retrieveStores.php", function(result){
                    var json = $.parseJSON(result);
                    console.log(json);
                    console.log(result);
                    for(var i = 0; i<json.count; i++){
                        var produces = json[i].produces.replace(/;/g,', ');
                        $('#stores').append("<li class='store-item'><a href='store.php?corp="+ json[i].corp + "'><h3>" + json[i].corp + "</h3></a><p>Produces: " + produces + "</p><p> Contact: " + json[i].contacts + " with any questions or concerns.</p></li>");
                    }
                    
                });
        });
        </script>
    </head>

    <body>
        <div class="container">
        <h1>Alternate Allegiance Production</h1>
             <?php include 'include/menu.php';?>
        </div>
        <div id="bodyContainer">
            <h1 class="bodyHeader">Corporate Stores</h1>
            <div>
                <ul id="stores">

                </ul>
            </div>
        </div>
    </body>

</html>