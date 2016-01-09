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
        <link rel="stylesheet" type="text/css" href="style.css" >
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="menu.css">
        <script src="include/menu.js"></script>
        <script>
            $(document).ready(function(){
                if(hasStore){
                    loadEndpointsManage();
                }else{
                    var username = "<?php echo $_SESSION['username'] ?>";
                    $.post("backend/checkStore.php", {user: username}, function(data){
                        var json = $.parseJSON(data);
                        console.log(json);
                        if(json.success == 1 && parseInt(json.store) == 1){
                            console.log("Found Store");
                            loadEndpointsManage();
                            setCookie('hasStore', 1 , 7);
                        }else if(json.success == 1 && parseInt(json.store) == 0){
                            console.log("Did not find store");
                            $('.marketgroupmain').remove();
                            $('#bodyContainer').append("<div class='storeCreation'><input name='a' placeholder='What types of items does your corp produce?' id='produces' type='text' width='200px'></input><input name='b' placeholder='Store Contacts' id='contacts' type='text' width='200px'></input><button name='c' onclick='submitStore()'>Submit</button>"); 
                        }else{
                            console.log("Something went wrong " + json.success + " " + json.store);
                        }
                    })
                    
                }
            });

            function bpCheckedChanged (index){
                if(arr.indexOf(index) >= 0){
                    arr.splice(arr.indexOf(index), 1);
                }else{
                    arr.push(index);
                }
                console.log(arr);
                //console.log(index);
            }
            function setPrice(id){
                var selector = "#" + id + "-price";
                var price = $(selector).val();
                console.log(price);
                if(arr.indexOf(id) < 0){
                    alert("Please check the own box before setting a price!");
                }else{
                    prices[id] = price;
                }
                console.log(prices);
            }
            function save(){
                var typeIdString = "";
                typeIdString += arr[0] + ":" + prices[arr[0]];
                for(var i = 1; i<arr.length; i++){
                    typeIdString += ";" + arr[i] + ":" + prices[arr[i]];
                }
                 $.post("backend/updateCorpItems.php", {typeId: typeIdString, corp: "<?php echo $_SESSION['corporation'] ?>"}, function(result){
                    //var json = $.parseJSON(result);
                    //console.log(json);
                    console.log(result);
                    window.reload();
                });
                console.log(typeIdString);
            }

            function submitStore(){
                var produces = $('#produces').val();
                var contacts = $('#contacts').val();
                var username = "<?php echo $_SESSION['username'] ?>";
                //console.log(produces + " " + contacts);
                $.post("backend/createStore.php", {corp: corporation, produce: produces, contact: contacts, user: username}, function(data){
                    var json = $.parseJSON(data);
                    if(json.success == 1){
                        setCookie('hasStore', 1, 7);
                    }
                });
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
            <div class="marketgroupmain">
                <h3>Manage Items</h3>
                    <!--<h4> Please use the menu below to indicate the blueprints your corporation is capable of making as well as your price per run/item. Any questions or errors, please contact Marksman81 Orti in-game</h4>-->
                        <div>
                         <div id="buttonContainer">
                            <button onclick="save()" id="saveButton">Save changes</button>
                         </div>
                        <div class="marketGroups">
                            <div class="marketgroupdiv">
                                <ul id="marketGroups"></ul>
                            </div>
                        </div>
                        </div>
                </div>
        </div>
    </body>

</html>