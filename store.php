<?php
    include 'include/permissions.php';
    if((int)$loggedIn != 1 || (int)$member != 1){
        header('Location: http://newelementgaming.net/eve/notLoggedIn.html');
    }
?>
<html>
    <head>
        <title>Alternate Allegiance Production</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="include/cookies.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
        <script src="include/include.js"></script>
        <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
        <script src="include/crest.js"></script>
        <link rel="stylesheet" type="text/css" href="menu.css">
        <script src="include/menu.js"></script>
        <script>
            function add(typeId, name){
                var price = prices[typeId];
                addToCart(typeId, name, price, corpName);
                $('.added').html(name + " added to cart.");
                $('.added').stop().fadeIn(400).delay(3000).fadeOut(400);
                console.log(typeId + ":" + name + ":" + price);
            }
        </script>
        <script src="include/cart.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css" >
        <script>
        var corpName;
            $(document).ready(function(){
                $( "#progressbar" ).progressbar({
                    value: false
                });
                var corp = "<?php echo $_GET['corp'] ?>";
                loadEndpoints(corp);
                $("#progressbar").hide();
                corpName = corp;
                sessionStorage.setItem('buyer-corp', corp);
                $('.added').html("Please wait... Loading market group browser.");
                $('.added').stop().fadeIn(400).delay(3000).fadeOut(400);
            });
        </script>
    </head>

    <body>
        <div class="container">
        <h1>Alternate Allegiance Production</h1>
             <?php include 'include/menu.php';?>
        </div>
        <div id="bodyContainer">
            <div id="progressbar"></div>
            <h1 class="bodyHeader">Welcome to the Alternate Allegiance Production Site!</h1>
            <div class='added' style='display:none'></div>
            <div class="marketgroupmain">
                <div class="marketGroups">
                    <div class="marketgroupdiv">
                        <ul id="marketGroups">
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </body>

</html>