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
        <script src="include/include.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css" >
        <link rel="stylesheet" type="text/css" href="menu.css">
        <script src="include/menu.js"></script>
        <script>
            var orderId = "<?php echo $_GET['id'] ?>";
            var user = "<?php echo $_GET['user'] ?>";
            var totalTrit = 0;
            var totalPyerite = 0;
            var totalMex = 0;
            var totalIsogen = 0;
            var totalNocxium = 0;
            var totalZydrine = 0;
            var totalMegacyte = 0;
            $(document).ready(function(){
                $('.bodyHeader').html("Order for " + user);
            });
            $.post("backend/getOrder.php", {id: orderId}, function(data){
                var order = $.parseJSON(data);
                for(var i = 0; i<order.length; i++){
                    var materials = order[i].Materials;
                    var components = order[i].Components;
                    var compText = "";
                    $('#itemBody').append("<tr><td>Item</td><td>" + order[i].Name + "</td><td>" + numeral(order[i].Quantity).format('0,0') + "</td><td>" + numeral(materials.Tritanium * order[i].Quantity).format('0,0') + "</td><td>" + numeral(materials.Pyerite * order[i].Quantity).format('0,0') + "</td><td>" + numeral(materials.Mexallon * order[i].Quantity).format('0,0') + "</td><td>" + numeral(materials.Isogen * order[i].Quantity).format('0,0') + "</td><td>" + numeral(materials.Nocxium * order[i].Quantity).format('0,0') + "</td><td>" + numeral(materials.Zydrine * order[i].Quantity).format('0,0') + "</td><td>" + numeral(materials.Megacyte * order[i].Quantity).format('0,0') + "</td><td id='" + order.Name + "-comp'></td></tr>");

                    totalTrit += order[i].Quantity * materials.Tritanium;
                    totalPyerite += order[i].Quantity * materials.Pyerite;
                    totalMex += order[i].Quantity * materials.Mexallon;
                    totalIsogen += order[i].Quantity * materials.Isogen;
                    totalNocxium += order[i].Quantity * materials.Nocxium;
                    totalZydrine += order[i].Quantity * materials.Zydrine;
                    totalMegacyte += order[i].Quantity * materials.Megacyte;

                     if(components === undefined || components.length == 0){
                        compText = "No Components";
                    }else{
                        for(var j = 0; j<components.length; j++){
                            var subMaterials = components[j].Materials;
                            $('#itemBody').append("<tr><td>Sub Component for " + order[i].Name + "</td><td>" + components[j].Name + "</td><td>" + numeral(components[j].Quantity).format('0,0') * order[i].Quantity + "</td><td>" + numeral(subMaterials.Tritanium * components[j].Quantity * order[i].Quantity).format('0,0') + "</td><td>" + numeral(subMaterials.Pyerite * components[j].Quantity * order[i].Quantity).format('0,0') + "</td><td>" + numeral(subMaterials.Mexallon * components[j].Quantity * order[i].Quantity).format('0,0') + "</td><td>" + numeral(subMaterials.Isogen * components[j].Quantity * order[i].Quantity).format('0,0') + "</td><td>" + numeral(subMaterials.Nocxium * components[j].Quantity * order[i].Quantity).format('0,0') + "</td><td>" + numeral(subMaterials.Zydrine * components[j].Quantity * order[i].Quantity).format('0,0') + "</td><td>" + numeral(subMaterials.Megacyte * components[j].Quantity * order[i].Quantity).format('0,0') + "</td><td id='" + order.Name + "-comp'></td></tr>");

                            totalTrit += components[j].Quantity * order[i].Quantity * subMaterials.Tritanium;
                            totalPyerite += components[j].Quantity * order[i].Quantity * subMaterials.Pyerite;
                            totalMex += components[j].Quantity * order[i].Quantity * subMaterials.Mexallon;
                            totalIsogen += components[j].Quantity * order[i].Quantity * subMaterials.Isogen;
                            totalNocxium += components[j].Quantity * order[i].Quantity * subMaterials.Nocxium;
                            totalZydrine += components[j].Quantity * order[i].Quantity * subMaterials.Zydrine;
                            totalMegacyte += components[j].Quantity * order[i].Quantity * subMaterials.Megacyte;
                        }
                    }
                }
                $('#totalTrit').html(numeral(totalTrit).format('0,0'));
                $('#totalPyerite').html(numeral(totalPyerite).format('0,0'));
                $('#totalMex').html(numeral(totalMex).format('0,0'));
                $('#totalIsogen').html(numeral(totalIsogen).format('0,0'));
                $('#totalNocxium').html(numeral(totalNocxium).format('0,0'));
                $('#totalZydrine').html(numeral(totalZydrine).format('0,0'));
                $('#totalMegacyte').html(numeral(totalMegacyte).format('0,0'));
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
             <div id="tableWrapper">
                    <table id="orderItems">
                    <tr>
                        <th>Type</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Tritanium</th>
                        <th>Pyerite</th>
                        <th>Mexallon</th>
                        <th>Isogen</th>
                        <th>Nocxium</th>
                        <th>Zydrine</th>
                        <th>Megacyte</th>
                        <th>Other Items</th>
                    </tr> 
                    <tbody id="itemBody">

                    </tbody>

                    <tr>
                        <th colspan=3>Total</th>
                        <th id="totalTrit">Tritanium</th>
                        <th id="totalPyerite">Pyerite</th>
                        <th id="totalMex">Mexallon</th>
                        <th id="totalIsogen">Isogen</th>
                        <th id="totalNocxium">Nocxium</th>
                        <th id="totalZydrine">Zydrine</th>
                        <th id="totalMegacyte">Megacyte</th>
                        <th></th>
                    </tr>
                    </table>
                </div>
        </div>
    </body>

</html>