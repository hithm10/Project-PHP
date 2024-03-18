<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/097797771d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/signup_login.css">
    <title>GameStore - login</title>
</head>
    <body>
    	<header>
			<nav>
                <a href="index.php">Home</a>
                <a href="prodPage.php">Prodcts</a>
                <a href="aboutUs.php">About us</a>
			</nav>
		</header>
        <main>
            <h1>Log in</h1>
            <section>
                <h2>Log in</h2>
                <form method="post">
                    <label>Enter Username: </label>
                    <input type='text' name='username' required/>
                    <label>Enter Password: </label>
                    <input type='password' name='password' required/>
                    <button>Submit</button>
                </form>
                <a href="signup.php">dont have an account? press here to sign up.</a>
            </section>
        </main>
		<footer>
			<p>&copy; oded_&_hithm 2019-<?php echo date("Y");?></p>
		</footer>
    </body>
</html>


<?php
    require_once "user.php";
    require_once "dbClass.php";
    $db = dbClass::GetInstance();

    // If user pressed login
    if(isset($_POST['username'])){
        // username and password are correct
        if(password_verify($_POST['password'], $db->getPasswordByUsername($_POST['username']))){
            setcookie("user", $_POST['username']);
            $db->setUserOnline($_POST['username'], true);

            header("Location: index.php");
            alert("Logged in");
        }
        else{ // username or password are not correct 
            alert("Wrong username or password");
        }
    }

    // sending a dialog message to the player.
    function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
?>
