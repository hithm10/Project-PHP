<?php
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
	<?php
		if(isset($_COOKIE['user']) && $db->getUserByUsername($_COOKIE['user'])->isAdmin()){
			echo '<link rel="stylesheet" href="css/admin.css">';
		}
		?>
	<link rel="stylesheet" href="css/index.css">
    <title>GameStore</title>
</head>
	<body>
		<header>
			<nav>
                <a class="current" href="index.php">Home</a>
                <a href="prodPage.php">Prodcts</a>
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
			
			<h1>GameStore</h1>
			<p>The best video games store on the web.</p>
			<section>
				<h2>products</h2>
				<p>Go browse our amazing game collection and choose your favorite games at a lowest price on the web.</p>
				<div>
				<?php
					$arr = $db->getProducts();
					for ($i=0; $i < 3; $i++) { 
						$rnd = $arr[rand(0, count($arr) - 1)];
						echo '<a href="prodPage.php"><img src="images/' . $rnd->getImg() . '" alt="' . $rnd->getName() . '" title="' . $rnd->getName() . '"></a>';
					}
				?>
				</div>
				<a href="prodPage.php">To products</a>
			</section>
			<section>
				<h2>about us</h2>
				<a href="prodPage.php">To learn about us</a>
			</section>
		</main>
		<footer>
			<p>&copy; oded_&_hithm 2019-<?php echo date("Y");?></p>
		</footer>
	</body>
</html>

