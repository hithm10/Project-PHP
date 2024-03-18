<?php
    date_default_timezone_set("israel");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/097797771d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/shared.css">
    <link rel="stylesheet" href="css/signup_login.css">
    <link rel="stylesheet" href="css/signup.css">
    <title>GameStore - signup</title>
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
            <h1>Sign up</h1>
            <section>
                <h2>Sign up</h2>
                <form method="post">
                    <label><b>*</b> Username: </label>
                    <input type='text' name='username' required placeholder="username..."/>
                    <label><b>*</b> Password: </label>
                    <input type='password' name='password' required placeholder="password..."/>
                    <label><b>*</b> Confirm : </label>
                    <input type='password' name='confirm' required placeholder="confirm password..."/>
                    <label><b>*</b> Birth date: </label>
                    <input type='date' name='birth-date' <?php echo'min="' . date("Y-m-d", strtotime("-120 year")) . '" max="' . date("Y-m-d", strtotime("-18 year")) . '"'; ?> title="age between 18 - 120" required/>
                    <div>
                        <label><b>*</b>Gender: </label>
                        <label title="Male"><i class="fas fa-male"></i>
                            <input type='radio' name='gender' value="male" required/>
                        </label>
                        <label title="Female"><i class="fas fa-female"></i>
                            <input type='radio' name='gender' value="female"/>
                        </label>
                        <label title="Other"><i class="fas fa-question"></i>
                            <input type='radio' name='gender' value="other"/>
                        </label>
                    </div>
                    <label><b>*</b> Email: </label>
                    <input type='email' name='email' required placeholder="email..."/>
                    <label><b>*</b> Country: </label>
                        <select name=country required>
                            <?=selectItems("country")?>
                        </select>
                    <label>City: </label>
                    <input type='text' name='city' placeholder="city..."/>
                    <label> Address: </label>
                    <input type='text' name='address' placeholder="address..."/>
                    <button>Submit</button>                   
                </form>
                <a href="login.php">already have an account? press here to log in.</a>
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
    if(isset($_POST['username'])){ // Player pressed submit and the form was valid.
        $names = $db->getUsernames();
        if(!in_array($_POST['username'], $names)){ // username doesn't exist in the database.
            $emails = $db->getEmails();
            if(!in_array($_POST['email'], $emails)){ // email doesn't exist in the database.
                if($_POST['password'] === $_POST['confirm']){ // Password and confirm are equals.
                    $user = new User($_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['gender'], $_POST['birth-date'], $_POST['email'], $countries[$_POST['country']], $_POST['city'], $_POST['address'], 0);
                    $db->insertUser($user);
                    alert("you have sign up successfully!");
                }
                else{ // Password and confirm aren't equals.
                    alert("Failed!!! please try again.");
                }
            }else{ // email already exist in the database.
                alert("Failed!!! email already in use by another user.");
            }
        }else{ // username already exist in the database.
            alert("Failed!!! username already exist.");
        }
    }

// sending a dialog message to the player.
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

// the selections of countries the user can choose from.
function selectItems($option){
    global $countries;
    $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
    $text = "<option selected disabled hidden value=''>$option...</option>\n";
    foreach ($countries as $k=>$v){
        $text .= "<option value='$k'>$v</option>\n";
    }
    return $text;
}
?>
