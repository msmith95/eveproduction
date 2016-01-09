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

        <script src="include/include.js"></script>
        <script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
        <script src="include/crest.js"></script>

        <script src="include/cart.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css" >
        <link rel="stylesheet" type="text/css" href="menu.css">
        <script src="include/menu.js"></script>

        <script>
        var corpList = sessionStorage.getItem('corpList');
        var corpListArray;

        $(document).ready(function (){
            if(corpList != null){
                corpListArray = corpList.split(";");
            
            for(var i = 0; i<corpListArray.length; i++){
                var items = sessionStorage.getItem(corpListArray[i] + "-production-items");
                console.log(corpListArray[i]);
                if(items == null){
                    $('#tableBody').append("<tr><td colspan=4>Your cart is empty</td></tr>");
                }else{
                    $('#tableBody').append("<tr><td colspan=4 class='boldTd'>" + corpListArray[i] + " Items</td></tr>");
                    var itemsArray = items.split(";");
                    for(var i = 0; i<itemsArray.length; i++){
                        var attrs = itemsArray[i].split(":");
                        $('#tableBody').append("<tr><td>" + attrs[1] + "</td><td>" + attrs[3] + "</td><td>" + attrs[2] + "</td><td class='itemTotal'>" + (parseInt(attrs[3]) * parseInt(attrs[2]))) + "</td></tr>";
                    }
                }
            }
            var amounts = document.getElementsByClassName('itemTotal');
            var orderTotal = 0;
            for(var i = 0; i<amounts.length; i++){
                orderTotal += parseInt(amounts[i].innerHTML);
            }
            document.getElementById('totalOrderPrice').innerHTML = orderTotal + " isk";
        }else{
            $('#tableBody').append("<tr><td colspan=4>Your cart is empty</td></tr>");
        }
        });

        function checkout(){
            corpListArray = corpList.split(";");
            for(var i = 0; i<corpListArray.length; i++){
                var itemList = sessionStorage.getItem(corpListArray[i] + "-production-items");
                var username = "<?php echo $_SESSION['username'] ?>";
                var corporation = "<?php echo $_SESSION['corporation'] ?>";
                $.post("backend/getMaterials.php", {id: itemList, corp: corpListArray[i], buyer: username, bCorp: corporation});
                sessionStorage.clear
            }
        }
        </script>
    </head>

    <body>
        <div class="container">
        <h1 id="headerText">Alternate Allegiance Production</h1>
           <?php include 'include/menu.php';?>
        </div>
        <div id="bodyContainer">
            <h1 class="bodyHeader">Welcome to the Alternate Allegiance Production Site!</h1>
            <div id="cart">
                <div id="tableWrapper">
                    <table id="order">
                    <tr class="tableHeader">
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price per unit</th>
                        <th>Total Price</th>
                    </tr> 
                    <tbody id="tableBody">

                    </tbody>
                    <tr class="tableFooter">
                        <td colspan=3>Total</td>
                        <td id="totalOrderPrice"></td>
                    </tr>
                    </table>
                </div>
                <div id="buttonContainer">
                <button onclick="checkout()" class="right">Checkout</button>
                <button onclick="clearCart()" class="right" >Empty Cart</button>
                </div>
            </div>
        </div>
    </body>

</html>