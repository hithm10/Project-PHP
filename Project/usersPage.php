<?php
    require_once "user.php";
    require_once "product.php";
    require_once "dbClass.php";
    $db = dbClass::GetInstance();   
    date_default_timezone_set("israel");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/097797771d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/usersPage.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>GameStore - users</title>
</head>
    <body>
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a href="prodPage.php">Prodcts</a>
                <a class="current" href="aboutUs.php">About us</a>
				<div class="dropdown">					
						<?php
							// If cookies exists yet and is admin.
                            if(isset($_COOKIE['user']) && $db->getUserByUsername($_COOKIE['user'])->isAdmin()){
                                echo '<p>Admin</p><i class="fas fa-caret-down"></i>';
                                echo '<ul class="dropdown-content">';
                                echo '<li><a href="usersPage.php"><i class="fas fa-users"></i>Users</a></li>';
                                echo '<li><a href="reports.php"><i class="fas fa-chart-bar"></i>Reports</a></li>';																		
                                echo '<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Log out</a></li>';
                                echo '</ul>';
							}
							else{ // cookies don't exists.
								header("Location: index.php");
							}
						?>
					</ul>
				</div>
            </nav>
        </header>
        <main>
            <h1>Users</h1>
            <div class="filter">
                <form method="post" class="search">
                    <input type="text" name="search" required placeholder="search">
                    <button title="Search"><i class="fas fa-search"></i></button>
                </form>
                <form method="post">
                    <span>order by: </span>
                    <select name="order">
                        <option value="username">Username</option>
                        <option value="FLOOR(DATEDIFF(CURRENT_DATE, birthDate) / 365.25)">age</option>
                        <option value="joinDate">Join date</option>
                    </select>
                    <div>
                        <input type="radio" name="asc" value="asc" id="asc" checked>
                        <label for="asc" title="Ascending order"><i class="fas fa-chevron-up"></i></label>
                        <input type="radio" name="asc" value="desc" id="desc" >
                        <label for="desc" title="Descending order"><i class="fas fa-chevron-down"></i></label>
                    </div>
                    <button title="Sort"><i class="fas fa-sort"></i></button>
                </form>
                <form method="post">
                    <button title="Refresh"><i class="fas fa-sync-alt"></i></button>
                </form>
            </div>
            <section>
                <li><span><b>Username: </b></span><span><b>Email: </b></span><span><b>Age: </b></span><span><b>Join at: </b></span>
                <span><b>Gender: </b></span><span><b>Country: </b></span><span><b>Online</b></span>
                </li>
                <ul>             
                <?php 
                    $order = "";
                    $search = "";
                    if(isset($_POST['order'])){ // User pressed sort
                     $order = "order by " . $_POST['order'] . " " . $_POST['asc'];
                    }
                    if(isset($_POST['search'])){ // User pressed search
                        $search = "WHERE username LIKE '%" . $_POST['search'] . "%' ";
                    }

                    $arr = $db->getUsers($search, $order);

                    for ($i=0; $i < count($arr); $i++) { 
                        // Calculate age.
                        $from = new DateTime($arr[$i]->getBirthDate());
                        $to   = new DateTime('today');
                        $age =  $from->diff($to)->y;
                        echo "<li><span>" . $arr[$i]->getUsername() . "</span><span>" . $arr[$i]->getEmail() . "</span><span>" . $age . "</span><span>" . $arr[$i]->getJoinDate() . "</span>";
                        echo "<span>" . $arr[$i]->getGender() . "</span><span>" . $arr[$i]->getCountry() . '</span><span class="' . ($arr[$i]->isOnline()?"on":"off") . '"><i class="fas fa-circle"></i></span>';
                        echo '</li>';
                    }
                ?>
                </ul>
                <?php
                    if($arr == false){ // User don't have items in his cart.
                        echo '<div class="empty"><p>No users on the site!</p>';
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
