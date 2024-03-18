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
    <title>GameStore - about us</title>
</head>
    <body>
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a href="prodPage.php">Prodcts</a>
                <a class="current" href="aboutUs.php">About us</a>
				<div class="dropdown">					
						<?php
                            $db = dbClass::GetInstance();
                            
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
            <h1>About us</h1>
            <section class="about">
                <P>Welcome to GameStore, your number one source for all things video games. We're dedicated to giving you the very best of games, with a focus on dependability, customer service and uniqueness.</p>
                <P>Founded in 2019 by oded & hithm, GameStore has come a long way from its beginnings in a toolshed. When oded & hithm first started out, their passion for providing the best video games for their fellow gamers drove them to do intense research, quit her day job, and gave them the impetus to turn hard work and inspiration into to a booming online store. We now serve customers all over the world, and are thrilled to be a part of the quirky wing of the video game industry.</p>
                <P>We hope you enjoy our products as much as we enjoy offering them to you. If you have any questions or comments, please don't hesitate to contact us.</p>
                <P>Sincerely,</p>
                <P>oded & hithm</p>
            </section>
            <form>
                <button type="reset">Contect us <i class="fas fa-envelope"></i></button>
                <button type="reset">Follow us <i class="fab fa-twitter"></i></button>
            </form>
        </main>
        <footer>
		    <p>&copy; oded_&_hithm 2019-<?php echo date("Y");?></p>
		</footer>
    </body>
</html>