var permissions = getCookie("permissions");
var member = permissions.charAt(0);
var industry = permissions.charAt(1);
var ceo = permissions.charAt(2);
var leadership = permissions.charAt(3);
var hasStore = getCookie("hasStore");
var corporation = getCookie("corporation");
$(document).ready(function (){
	if(getCookie("loggedIn") == 1){
                $('#loginItem a').attr("href", "#");
                $('#loginItem a').attr("onclick", "logout()");
                $('#loginItem p').text("Logout");
                console.log("It worked");
    }
    console.log(member + industry + ceo + leadership);
    /*if(industry == 1){
    	$('<li class="menu-item has-sub" id="industryItem"><a href="manageStore.php?corp=' + corporation + '"><p>Store Management</p></a><ul><li class="darkgrey"><a href="corpOrders.php"><span>Open Orders</span></a></li></ul></li>').insertAfter('#storeItem');
    }
    if(leadership == 1){
    	$('<li class="menu-item" id="industryItem"><a href="leadershipPanel.php"><p>Leadership Panel</p></a></li>').insertAfter('#storeItem');
    }
    if(member == 1){
        $('<li class="menu-item" id="cartItem"><a href="cart.php"><p>Cart</p></a></li>').insertBefore('#loginItem');
    }*/
});
function logout(){
    setCookie("username", "", 7);
    setCookie("loggedIn", 0, 7);
    setCookie("permissions", "", 7);
    setCookie("corporation", "", 7);
    setCookie("alliance", "", 7);
    //location.reload(true);
    window.location = window.location.href + "?action=logout";
}

