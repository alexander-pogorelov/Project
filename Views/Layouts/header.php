<!DOCTYPE HTML>
<html>
    <head>
        <title>E-Shop</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="/Template/css/style.css">
        <!--<link rel="shortcut icon" href="/Template/images/favicon.ico" type="image/png">-->
        <script src="/Template/js/Cart.js"></script>
	</head>

    <body>
        <div id="header">
            <a href="/" class="float"><img src="/Template/images/logo.jpg" alt="" width="171" height="73"/></a>

            <div class="topblock1">
                Currency:<br/><select>
                    <option>US Dollar</option>
                </select>
            </div>
            <div class="topblock1">
                <!--<p class="line center"><a href="#" class="reg">Login</a> | <a href="/user/registration" class="reg">Registration</a></p>-->
                <?php if (UserModel::checkGuest()): ?>
                    <p class=""><span><a href="/user/login" class="">Login</a> | <a href="/user/registration" class="">Registration</a></span>
                    </p>
                <?php else: ?>
                    <p class=""><?php echo $_SESSION['user']['name']; ?></p>
                    <p class=""><span><a href="/user/logout" class="">Logout</a> | <a href="/cabinet"
                                                                                      class="">Cabinet</a></span></p>
                <?php endif; ?>

            </div>
            <div class="topblock2">
                <a href="/cart"><img src="/Template/images/shopping.gif" alt="" width="24" height="24"
                                     class="shopping"/></a>

                <p>Shopping cart</p>

                <p><strong id="totalproducts"><?php echo CartModel::getCountItemsInCart();?></strong> <span>items</span></p>
            </div>
            <ul id="menu">
                <li><img src="/Template/images/li.gif" alt="" width="19" height="29"/></li>
                <li><a href="/"><img src="/Template/images/but1_a.gif" alt="" width="90" height="29"/></a></li>
                <li><a href="/"><img src="/Template/images/but2.gif" alt="" width="129" height="29"/></a></li>
                <li><a href="/"><img src="/Template/images/but3.gif" alt="" width="127" height="29"/></a></li>
                <li><a href="/"><img src="/Template/images/but4.gif" alt="" width="113" height="29"/></a></li>
                <li><a href="/"><img src="/Template/images/but5.gif" alt="" width="132" height="29"/></a></li>
                <li><a href="/"><img src="/Template/images/but6.gif" alt="" width="105" height="29"/></a></li>
                <li><a href="/"><img src="/Template/images/but7.gif" alt="" width="82" height="29"/></a></li>
                <li><a href="/contacts"><img src="/Template/images/but8.gif" alt="" width="112" height="29"/></a></li>
                <li><a href="/"><img src="/Template/images/but9.gif" alt="" width="71" height="29"/></a></li>
            </ul>
        </div>