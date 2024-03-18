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
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/reports.css">
    <title>GameStore - reports</title>
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
            <section>
                <ul>
                    <?php
                        echo "<li>Number of users: " . $db->countNewUsers() . ".</li>";
                        echo "<li>Amount of users that are online: " . $db->getOnline() . ".</li>";
                        echo "<li>Amount of profit the website made: " . number_format($db->calculateProfit(), 2) . "$.</li>";
                        echo "<li>Amount of games the website sold: " . $db->countSoldGames() . ".</li>";
                    ?>
                </ul>
            </section>
            <section>
                <div>
                    <h3>Monthly report</h3>
                    <form method="post">
                        <select name="year" required>
                            <?=selectItems("year")?>
                        </select>
                        <select name="month" required>
                            <?=selectItems("month")?>
                        </select>
                        <button>print report</button>
                    </form>
                </div>
                <div>
                <h3>Yearly report</h3>
                <form method="post">
                    <select name="year" required>
                        <?=selectItems("year")?>
                    </select>
                    <button>print report</button>
                </form>
                </div>
            </section>
        </main>
        <footer>
		    <p>&copy; oded_&_hithm 2019-<?php echo date("Y");?></p>
		</footer>
    </body>
</html>
<?php 
    if(isset($_POST['year'])){
        printReport();
    }

    // Function create a text file about the website in the "report" folder.
    function printReport(){
        $db = dbClass::GetInstance(); 
        $content = "Printed on: " . date("l d F Y") . "\n\n";
        if(isset($_POST['month'])){ // User pressed print monthly report
            if($_POST['year'] . " " . $_POST['month'] > date("Y m")){ // user chose an in valid date.
                alert("There is no report for this month!");
                return;
            }
            $fileName = "Monthly_report_" . $_POST['year'] . "_" . $_POST['month'];
            $content .= "Monthly report - " . $_POST['month'] . "/" . $_POST['year']; 
            if(date('m Y') === ($_POST['month'] . " " . $_POST['year'])){ // user chose to print report for this year and month.
                $fileName.="_incomplete";
                $content .= " - incomplete!\n----------------------------------------------\n\n";
            }else{ // user chose to print report for a previous year and month.
                $content .= "\n------------------------------\n\n";     
            }
            $content .= "Profit: " . number_format($db->calculateProfit($_POST['year'], $_POST['month']), 2) ."$.\n"; // Calculate this month profit.
            $content .= "Amount of this month sold games: " . $db->countSoldGames($_POST['year'], $_POST['month']) . ".\n"; // Count this month new users.
            $content .= "Number of this month new users: " . $db->countNewUsers($_POST['year'], $_POST['month']) . ".\n"; // Count this month sold games.      

        }else{ // User pressed print yearly report
            $fileName = "Yearly_report_" . $_POST['year'];
            $content .= "Yearly report - " . $_POST['year']; 
            if(date('Y') === $_POST['year']){ // user chose to print report for this year.
                $fileName.="_incomplete";
                $content .= " - incomplete!\n----------------------------------------\n\n";
            }else{ // user chose to print report for a previous year.
                $content .= "\n------------------------\n\n";
            }
            $content .= "Profit: " . number_format($db->calculateProfit($_POST['year']), 2) . "$.\n"; // Calculate this year profit.
            $content .= "Amount of this year sold games: " . $db->countSoldGames($_POST['year']) . ".\n"; // Count this year sold games.
            $content .= "Number of this year new users: " . $db->countNewUsers($_POST['year']) . ".\n"; // Count this year new users.
        }            
        file_put_contents("reports/$fileName.txt", $content);
        alert("Report printed!");
    }

    // sending a dialog message to the player.
    function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    // the selections of months and years the user can choose from.
    function selectItems($option){
        global $countries;
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $text = "<option selected disabled hidden value=''>$option...</option>\n";
        if($option === "month"){ // month selection.
            for ($i=1 ; $i <= 12; $i++) { 
                $text .= "<option value='" . date('m', strtotime("2000-$i-01")) . "'>" . date('F', strtotime("2000-$i-01")) . "</option>\n";
            }    
        }else{
            for ($i=2019 ; $i <= date('Y'); $i++) { // year selection.
                $text .= "<option value='$i'>$i</option>\n";
            }            
        }
        return $text;
    }
?>
