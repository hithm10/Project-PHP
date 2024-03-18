<?php
	require_once "user.php";
	require_once "dbClass.php";
    
	$db = dbClass::GetInstance();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/097797771d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/prodPage.css">
    <?php
		if(isset($_COOKIE['user']) && $db->getUserByUsername($_COOKIE['user'])->isAdmin()){
			echo '<link rel="stylesheet" href="css/admin.css">';
		}
	?>
    <title>GameStore - products</title>
</head>
    <body>
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a class="current" href="prodPage.php">Prodcts</a>
                <a href="aboutUs.php">About us</a>
				<div class="dropdown">					
						<?php
							// If cookies exists yet.
							if (isset($_COOKIE['user'])) {
                                $carts = $db->getCartsByUsername($_COOKIE['user']);

								// User is admin.
								if($db->getUserByUsername($_COOKIE['user'])->isAdmin()){
									echo '<p>Admin</p><i class="fas fa-caret-down"></i>';
									echo '<ul class="dropdown-content">';
									echo '<li><a href="usersPage.php"><i class="fas fa-users"></i>Users</a></li>';
									echo '<li><a href="reports.php"><i class="fas fa-chart-bar"></i>Reports</a></li>';																		
									echo '<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Log out</a></li>';
									echo '</ul>';
								}
								else{ // User isn't admin.
									echo '<p>' . $_COOKIE['user'] . '</p><i class="fas fa-caret-down"></i>';
									echo '<ul class="dropdown-content">';
									echo '<li><a href="accountPage.php"><i class="fas fa-user"></i>Account</a></li>';
									echo '<li><a href="cartPage.php"><i class="fas fa-shopping-cart"></i>Cart (' . count($carts) . ')</a></li>';
									echo '<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Log out</a></li>';
									echo '</ul>';
								}
							}
							else{ // cookies don't exists.
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
            <h1>Products</h1>
            <div class="filter">
                <form method="post" class="search">
                    <input type="text" name="search" required placeholder="search">
                    <button title="Search"><i class="fas fa-search"></i></button>
                </form>
                <form method="post">
                    <span>order by: </span>
                    <select name="order">
                        <option value="name">name</option>
                        <option value="price - discount">price</option>
                        <option value="rating">rating</option>
                    </select>
                    <div>
                        <input type="radio" name="asc" value="asc" id="asc" >
                        <label for="asc" title="Ascending order"><i class="fas fa-chevron-up"></i></label>
                        <input type="radio" name="asc" value="desc" id="desc" checked>
                        <label for="desc" title="Descending order"><i class="fas fa-chevron-down"></i></label>
                    </div>
                    <button title="Sort"><i class="fas fa-sort"></i></button>
                </form>
                <form method="post">
                    <button title="Refresh"><i class="fas fa-sync-alt"></i></button>
                </form>
            </div>
            <article>
                <?php
                    require_once "product.php";

                    $order = "";
                    $search = "";
                    if(isset($_POST['order'])){ // User pressed sort
                     $order = "order by " . $_POST['order'] . " " . $_POST['asc'];
                    }
                    if(isset($_POST['search'])){ // User pressed search
                        $search = "WHERE name LIKE '%" . $_POST['search'] . "%' ";
                    }

                    $prods = $db->getProducts($search, $order);
                    
                    // Prints all the products that are in the database.
                    foreach($prods as $p){
                        echo "<section" . ($p->getAmount() == 0? ' class="out-of-stock1"':'') . "><h3>" . $p->getName() . "</h3>";
                        echo '<img src="images/' . $p->getImg() . '" alt="' . $p->getName() . '" width="200px">';
                        if($p->getAmount() == 0){ // Product is out of stock
                            echo '<span class="out">out of stock</span>';
                            echo '<div class="cant-buy" ></div>';
                        }
                        if($p->getDiscount() > 0){ // if product have a discount.
                            if($p->getAmount() != 0){
                                echo '<span class="discount">on sale</span>';
                            }
                            echo '<span><strong>Price: </strong><b>' . $p->getPrice() . '$</b> ' . ($p->getPrice() - $p->getDiscount()) . '$</span>';
                        }
                        else{ // product doesn't have a discount.
                            echo '<span><strong>Price: </strong>' . $p->getPrice() . '$</span>';
                        }

                        // if user owns games
                        if(isset($_COOKIE['user']) && $db->getGameCount($_COOKIE['user'], $p->getId())){
                            echo '<span class="owned">OWNED</span>';
                            echo '<div class="cant-buy" ></div>';
                        }
                        echo '<span><strong>Amount in stock: </strong>' . $p->getAmount() . '</span>';
                        echo '<div>';
                        $num = $p->getRating();

                        // Print the stars based on the ratings
                        for($i = 0; $i < (int)($num / 2) ;$i++){
                            echo '<i class="fas fa-star"></i>';
                        }
                        if($num%2 !== 0){
                            echo '<i class="fas fa-star-half-alt"></i>';
                        }

                        for($i = 0; $i < 5 - (int)($num / 2) - $num%2 ;$i++){
                            echo '<i class="far fa-star"></i>';
                        }
                        echo '</div>';

                        if(isset($_COOKIE['user']) && $db->getUserByUsername($_COOKIE['user'])->isAdmin()){
                            // echo '<form method="post"><span>already in cart: </span><button name="gameId" value="' . $p->getId() . '" title="already in cart" disabled><i class="fas fa-cart-plus"></i></button></form>';
                        }else{
                            // If user already have the item in cart.
                            if(isset($_COOKIE['user']) && $db->getCartGameCount($_COOKIE['user'], $p->getId()) > 0){
                                echo '<form method="post"><span>already in cart: </span><button name="gameId" value="' . $p->getId() . '" title="already in cart" disabled><i class="fas fa-cart-plus"></i></button></form>';
                            }
                            else{// User don't have the item in cart.
                                echo '<form method="post"><span>Add to cart: </span><button name="gameId" value="' . $p->getId() . '" title="Add to cart"><i class="fas fa-cart-plus"></i></button></form>';
                            }
                        }

                        echo '</section>';  

                    }
                    
                    if(isset($_POST["gameId"])){
                        if(isset($_COOKIE['user'])){
                            $db->insertCart($_COOKIE['user'], $_POST["gameId"]);
                            echo "<meta http-equiv='refresh' content='0'>";
                        }
                        else{
                            alert("you are not logged in, please log in to purchase!");
                        }
                    }

                    function alert($msg) {
                        echo "<script type='text/javascript'>alert('$msg');</script>";
                    }
                ?>
            </article>
        </main>
        <footer>
		    <p>&copy; oded_&_hithm 2019-<?php echo date("Y");?></p>
		</footer>
    </body>
</html>