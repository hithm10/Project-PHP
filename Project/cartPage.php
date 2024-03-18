<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/097797771d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/cartPage.css">
    <title>GameStore - cart</title>
</head>
    <body>
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a href="prodPage.php">Prodcts</a>
                <a class="current" href="aboutUs.php">About us</a>
				<div class="dropdown">					
                        <?php
                         require_once "dbClass.php";
                        $db = dbClass::GetInstance();   
							// If cookies exists yet.
							if (isset($_COOKIE['user'])) {
                                $carts = $db->getCartsByUsername($_COOKIE['user']);

								echo '<p>' . $_COOKIE['user'] . '</p><i class="fas fa-caret-down"></i>';
								echo '<ul class="dropdown-content">';
								echo '<li><a href="accountPage.php"><i class="fas fa-user"></i>Account</a></li>';
								echo '<li><a href="cartPage.php"><i class="fas fa-shopping-cart"></i>Cart (' . count($carts) . ')</a></li>';
								echo '<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Log out</a></li>';
								echo '</ul>';
							}
							else{ // cookies don't  exists.
								echo '<p>Guest</p><i class="fas fa-caret-down"></i>';
								echo '<ul class="dropdown-content">';
								echo '<li><a href="signup.php"><i class="fas fa-user-plus"></i>Sign up</a></li>';
								echo '<li><a href="login.php"><i class="fas fa-sign-in-alt"></i>Log in</a></li>';
								echo '</ul>';
							}
						?>
					</ul>
				</div>
            </nav>
        </header>
        <main>
            <h1>cart</h1>
            <section>
                <ul>             
                         
                <?php
                    require_once "cart.php";
                    require_once "product.php";
                    require_once "dbClass.php";
                    $db = dbClass::GetInstance();   
                    // Prints all the items a user have in his cart
                    $arr = $db->getCartsByUsername($_COOKIE['user']);
                    for ($i=0; $i < count($arr); $i++) { 
                        $game = $db->getProductById($arr[$i]->getId());
                        echo '<li><img src="images/' . $game->getImg() . '" alt="" height="100px"> ' . "<span><b>Game: </b>" . $game->getName() . "</span>";
                        echo "<span><b>Price: </b>" . ($game->getPrice() - $game->getDiscount()) . '$</span><form method="post">';
                        echo '<button name="purchase" value="' . $arr[$i]->getCartNum() . '"><i class="fas fa-credit-card"></i>Purchase</button>';
                        echo '<button name="remove" value="' . $arr[$i]->getCartNum() . '"><i class="fas fa-cart-arrow-down"></i>Remove</button></form>';
                        echo '</li>';
                    }
                ?>
                </ul>
                <?php
                    if($arr == false){ // User don't have items in his cart.
                        echo '<div class="empty"><p>Your cart is empty!</p>';
                        echo '<a href="prodPage.php">Go to products to buy a game.</a></div>';
                    }
                    else{// User have items in his cart.
                        echo '<form method="post">';
                        echo '<button name="purchase" value="-1"><i class="fas fa-credit-card"></i>Purchase all</button>';
                        echo '<button name="remove" value="-1"><i class="fas fa-cart-arrow-down"></i>Remove all</button>';
                        echo '</form>';
                    }
                ?>
            </section>
        </main>
        <footer>
		    <p>&copy; oded_&_hithm 2019-<?php echo date("Y");?></p>
		</footer>
    </body>
</html>
<?php
    // If user press purchase.
    if(isset($_POST["purchase"])){
        if(isset($_COOKIE['user'])){
            if($_POST["purchase"] != -1){ // if user purchased 1 item.
                echo $_POST["purchase"];
                $cart = $db->getCartByNum($_POST["purchase"]);
                $db->insertPurchase($cart);
                $db->decreaseProductAmountById($cart->getId());
                $db->removeCartByUserAndId($cart->getUsername(),$cart->getId());
                alert("Thank you for purchasing " . $db->getProductById($cart->getId())->getName());
            }
            else{ // if user purchased all items.
                foreach($arr as $value){
                    $db->insertPurchase($value);
                    $db->decreaseProductAmountById($value->getId());
                    $db->removeCartByUserAndId($value->getUsername(),$value->getId());
                }
                alert("Thank you for purchasing!");
            }
            header("Refresh:0");
        }
    }    
    // If user press remove.
    if(isset($_POST["remove"])){
        if(isset($_COOKIE['user'])){
            if($_POST["remove"] != -1){ // if user removed 1 item.
                echo $_POST["remove"];
                $cart = $db->getCartByNum($_POST["remove"]);
                $db->removeCartByUserAndId($cart->getUsername(),$cart->getId());
            }
            else{ // if user removed all items.
                foreach($arr as $value){
                    $db->removeCartByUserAndId($value->getUsername(),$value->getId());
                }
            }
            header("Refresh:0");
        }
    }    

    function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
?>
