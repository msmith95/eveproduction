 <div id="cssmenu">
            <ul class="menu">
                <li class="menu-item" id="homeItem"><a href="index.php"><p>Home</p></a></li>
                <li class="menu-item" id="storeItem"><a href="corpStores.php"><p>Corporate Stores</p></a></li>
                <?php if((int)$leadership == 1){echo '<li class="menu-item" id="industryItem"><a href="leadershipPanel.php"><p>Leadership Panel</p></a></li>';} ?>
                <?php if((int)$industry == 1){echo "<li class='menu-item has-sub' id='industryItem'><a href='manageStore.php?corp=". $_SESSION['corporation'] . "'><p>Store Management</p></a><ul><li class='darkgrey'><a href='corpOrders.php'><span>Open Orders</span></a></li></ul></li>";}  ?>
                <?php if((int)$member == 1){echo "<li class='menu-item has-sub' id='cartItem'><a href='cart.php'><p>Cart</p></a><ul><li class='darkgrey'><a href='myOrders.php'><span>My Orders</span></a></li></ul></li>";} ?>
                <li class="menu-item" id="loginItem"><a <?php if((int)$_SESSION['loggedIn'] == 1){echo "href=# onclick='logout()'";}else{echo "href='login.php'";} ?>><p><?php if(isset($_SESSION['loggedIn']) && (int)$_SESSION['loggedIn'] == 1){echo "Logout";}else{echo "Login/Register";} ?></p></a></li>
            </ul>
</div>