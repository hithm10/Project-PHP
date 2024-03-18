<?php
    require_once "purchase.php";
    require_once "product.php";
    require_once "dbClass.php";
    $db = dbClass::GetInstance();   
    $arr = array();
    if (isset($_COOKIE['user'])) {
        $arr = $db->getPurchases("WHERE username = '" . $_COOKIE['user'] . "'");
        $carts = $db->getCartsByUsername($_COOKIE['user']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/097797771d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/cartPage.css">
    <title>GameStore - account</title>
</head>
    <body>
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a href="prodPage.php">Prodcts</a>
                <a class="current" href="aboutUs.php">About us</a>
				<div class="dropdown">					
						<?php
							// If cookies exists yet.
							if (isset($_COOKIE['user'])) {
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
            <h1>Account</h1>
            <section>
                <ul>             
                         
                <?php
                    for ($i=0; $i < count($arr); $i++) { 
                        $game = $db->getProductById($arr[$i]->getGameId());
                        echo '<li><img src="images/' . $game->getImg() . '" alt="" height="100px"> ' . "<span><b>Game: </b>" . $game->getName() . "</span>";
                        echo "<span><b>Price: </b>" . ($game->getPrice() - $game->getDiscount()) . '$</span><form method="post">';
                        echo '<button name="download" value="' . $arr[$i]->getPurchaseId() . '"><i class="fas fa-download"></i>Download game</button>';
                        echo '<button name="rate" value="' . $arr[$i]->getPurchaseId() . '"><i class="fas fa-star-half-alt"></i>Rate game</button></form>';
                        echo '</li>';
                    }
                ?>
                </ul>
                <?php
                    if($arr == false){ // User don't have items in his cart.
                        echo '<div class="empty"><p>Your game library is empty!</p>';
                        echo '<a href="prodPage.php">Go to products to buy a game.</a></div>';
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
    function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
?>
