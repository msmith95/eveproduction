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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
        <script src="include/include.js"></script>
        <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
        <script src="include/crest.js"></script>

        <link rel="stylesheet" type="text/css" href="style.css" >
        <link rel="stylesheet" type="text/css" href="menu.css">
        <script src="include/menu.js"></script>
        <script>
        $(document).ready(function (){
            $.post("backend/getMyOrders.php", {user: "<?php echo $_SESSION['username'] ?>"}, function(result){
                console.log(result);
                var json = $.parseJSON(result);
                for(var i = 0; i<json.count; i++){
                    $('#openOrderBody').append("<tr id='order-" + json[i].orderId + "'><td>" + json[i].requestCorporation + "</td><td><a href='order.php?id=" + json[i].orderId + "&user=" + json[i].buyer + "'>View Order</a></td><td>" + json[i].status + "</td><td>" + numeral(json[i].price).format('0,0')+ " isk</td></tr>");
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
            <h1 class="bodyHeader">Welcome to the Alternate Allegiance Production Site!</h1>
            <div id="tables">
                <div id="tableWrapper">
                    <table id="order">
                    <tr class="openOrders">
                        <th>Corporation</th>
                        <th>Order Link</th>
                        <th>Status</th>
                        <th>Total Price</th>
                    </tr>
                    <tbody id="openOrderBody">

                    </tbody>
                    </table>

                </div>
            </div>
        </div>
    </body>

</html>