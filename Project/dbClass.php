<?php
    require_once "Product.php";
    require_once "purchase.php";
    require_once "Cart.php";
    require_once "User.php";
    class dbClass{
        private static $host;
        private static $db;
        private static $charset;
        private static $user;
        private static $pass;
        private static $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
        private static $connection;
        private static $obj;

        // Private constructor
        private function __construct(string $host= "localhost", string $db = "project_php", string $charset = "utf8", string $user = "root",string $pass = ""){
            self::$host = $host;
            self::$db = $db;
            self::$charset = $charset;
            self::$user = $user;
            self::$pass = $pass;
        }
        
        // Create only one object from class "dbClass".
       public static function GetInstance(): dbClass {
        if (self::$obj == null) {
            self::$obj = new dbClass();
        }
            return self::$obj;
        }
        // Connect to the database.
        private function connect(){
            $dns = "mysql:host=".self::$host.";dbname=".self::$db.";charset=".self::$charset;
            self::$connection = new PDO($dns, self::$user, self::$pass, self::$opt);
        }

        // Disconnect from the database.
        public function disconnect(){
            self::$connection = null;
        }

/******************** SQL SELECT ********************/
        
        // GET ALL WHERE...

        // returns an array of all the users.
        public function getUsers(string $where="" ,string $order = ""){
            self::connect();
            $usersArray = array();
            $result = self::$connection->query("SELECT * FROM users $where $order");
            while($row = $result->fetchObject('User')) {
                $usersArray[] = $row;
            }
            self::disconnect();
            return $usersArray;
        }

        //returns an array of all the products.
        public function getProducts(string $where="" ,string $order = ""){
            self::connect();
            $productsArray = array();
            $result = self::$connection->query("SELECT * FROM products $where $order");
            while($row = $result->fetchObject('Product')) {
                $productsArray[] = $row;
            }
            self::disconnect();
            return $productsArray;
        }

        // returns an array of all the products.
        public function getPurchases(string $where="" ,string $order = ""){
            self::connect();
            $purchasesArray = array();
            $result = self::$connection->query("SELECT * FROM purchases $where $order");
            while($row = $result->fetchObject('Purchase')) {
                $purchasesArray[] = $row;
            }
            self::disconnect();
            return $purchasesArray;
        }

        // returns an array of all the carts based on "username".
        public function getCartsByUsername(string $username){
            self::connect();
            $cartsArray = array();
            $statement = self::$connection->prepare("SELECT * FROM carts WHERE username = :username");
            $statement->execute([':username'=>$username]);
            while($row = $statement->fetchObject('Cart')) {
                $cartsArray[] = $row;
            }
            self::disconnect();
            return $cartsArray;
        }

        // returns an array of all the users's "username".
        public function getUsernames(){
            self::connect();
            $usernamesArray = array();
            $result = self::$connection->query("SELECT * FROM users");
            while($row = $result->fetchObject('User')) {
                $usernamesArray[] = $row->getUsername();
            }
            self::disconnect();
            return $usernamesArray;
        }

        // returns an array of all the users's "emails".
        public function getEmails(){
            self::connect();
            $emailsArray = array();
            $result = self::$connection->query("SELECT * FROM users");
            while($row = $result->fetchObject('User')) {
                $emailsArray[] = $row->getEmail();
            }
            self::disconnect();
            return $emailsArray;
        }

        // GET ONE WHERE...

        // returns an array of all the carts based on "username".
        public function getCartByNum($num){
            self::connect();
            $cartsArray = array();
            $statement = self::$connection->prepare("SELECT * FROM carts WHERE cartNum = :num");
            $statement->execute([':num'=>$num]);
            while($row = $statement->fetchObject('Cart')) {
                $cartsArray[] = $row;
            }
            self::disconnect();
            return $cartsArray[0];
        }

        // Return user by "username"
        public function getUserByUsername(string $username){
            self::connect();
            $statement = self::$connection->prepare("SELECT * FROM users WHERE username = :username");
            $statement->execute([':username'=>$username]);
            $result = $statement->fetchObject('User');
            self::disconnect();
            return $result;
        }

        // Return product by "id"
        public function getProductById($id){
            self::connect();
            $statement = self::$connection->prepare("SELECT * FROM products WHERE id = :id");
            $statement->execute([':id'=>$id]);
            $result = $statement->fetchObject('Product');
            self::disconnect();
            return $result;
        }
        
        // Return number of games id in database purchases by "username" and "gameId".
        public function getGameCount(string $username, $gameId){
            self::connect();
            $statement = self::$connection->prepare("SELECT COUNT('gameId') FROM purchases WHERE username = :username AND gameId = :id");
            $statement->execute([':username'=>$username, ':id'=>$gameId]);
            $result = $statement->fetchColumn();
            self::disconnect();
            return $result;
        }
        
        // Return number of games id in database cart by "username" and "gameId".
        public function getCartGameCount(string $username, $gameId){
            self::connect();
            $statement = self::$connection->prepare("SELECT COUNT('id') FROM carts WHERE username = :username AND id = :id");
            $statement->execute([':username'=>$username, ':id'=>$gameId]);
            $result = $statement->fetchColumn();
            self::disconnect();
            return $result;
        }

        // Return number of users that are onlline.
        public function getOnline(){
            self::connect();
            $statement = self::$connection->query("SELECT COUNT(online) FROM users where online = 1");
            $result = $statement->fetchColumn();
            self::disconnect();
            return $result;
        }

        // GET FIELD OF ONE WHERE...

        // Return password of user by "username"
        public function getPasswordByUsername(string $username): string{
            self::connect();
            $statement = self::$connection->prepare("SELECT * FROM users WHERE username = :username");
            $statement->execute([':username'=>$username]);
            $result = $statement->fetchObject('User');
            self::disconnect();
            return $result->getPassword();
        }

/******************** SQL INSERT ********************/        

        // Insert object to users database.
        public function insertUser($obj){
            date_default_timezone_set("israel");
            self::connect();
            $name = $obj->getUsername();
            $password = $obj->getPassword();
            $gender = $obj->getGender();
            $birth = $obj->getBirthDate();
            $join = date("Y-m-d H:i:s");
            $email = $obj->getEmail();
            $country = $obj->getCountry();
            $city = $obj->getCity();
            $address = $obj->getAddress();
            $statement = self::$connection->prepare("INSERT INTO users(username, password, gender, birthDate, joinDate, email, country, city, address, isAdmin) VALUES(:name, :password, :gender, :birth, :join, :email, :country, :city, :address, 0);");
            $statement->execute([':name'=>$name, ':password'=>$password, ':gender'=>$gender, ':birth'=>$birth, ':join'=>$join, ':email'=>$email, ':country'=>$country, ':city'=>$city, ':address'=>$address]);
            self::disconnect();
        }

        // Insert cart to purchases database.
        public function insertPurchase($cart){
            date_default_timezone_set("israel");
            self::connect();
            $statement = self::$connection->prepare("INSERT INTO purchases(username, gameId, purchaseDate) VALUES(:name, :id, :date);");
            $statement->execute([':name'=>$cart->getUsername(), ':id'=>$cart->getId(), ':date'=>date("Y-m-d H:i:s")]);
            self::disconnect();
        }

        // Insert data to carts database.
        public function insertCart($username, $gameId){
            self::connect();
            $statement = self::$connection->prepare("INSERT INTO carts(username, id) VALUES(:username, :id);");
            $statement->execute([':username'=>$username, ':id'=>$gameId]);
            self::disconnect();
        }

/******************** SQL UPDATE ********************/
        
        // Decrease product's amount by 1 using "id".
        public function decreaseProductAmountById($id){
            self::connect();
            $statement = self::$connection->prepare("UPDATE products SET amount = amount - 1 WHERE id = :id and amount > 0");
            $statement->execute([':id'=>$id]);
            self::disconnect();
        }

        // Decrease product's amount by 1 using "id".
        public function setUserOnline($username, $online){
            self::connect();
            $statement = self::$connection->prepare("UPDATE users    SET online = :online WHERE username = :username");
            $statement->execute([':username'=>$username, ':online'=>$online]);
            self::disconnect();
        }

/******************** SQL DELETE ********************/

        // Remove an item from user's cart based on "username" and "id".
        public function removeCartByUserAndId(string $username, $id){
            self::connect();
            $statement = self::$connection->prepare("DELETE FROM carts WHERE username = :username AND id = :id");
            $statement->execute([':username'=>$username, ':id'=>$id]);
            self::disconnect();
        }

/******************** SQL CALCULATE ********************/

        // Calculate the profit the website made.
        public function calculateProfit($year = "", $month = ""){
            self::connect();
            if($year !== "" && $month !==""){ // Calculate based on year and month.
                $statement = self::$connection->prepare("SELECT SUM(price-discount) FROM products, purchases where purchases.gameId = products.id and YEAR(purchases.purchaseDate) = :year and MONTH(purchases.purchaseDate) = :month");
                $statement->execute([':year'=>$year, ':month'=>$month]);
            }elseif($year !==""){ // Calculate based on year.
                $statement = self::$connection->prepare("SELECT SUM(price-discount) FROM products, purchases where purchases.gameId = products.id and YEAR(purchases.purchaseDate) = :year");
                $statement->execute([':year'=>$year]);
            }else{ // Calculate overall.
                $statement = self::$connection->query("SELECT SUM(price-discount) FROM products, purchases where purchases.gameId = products.id");
            }
            $result = $statement->fetchColumn();
            self::disconnect();
            return $result;
        }

        // Count the new user that joined the website.
        public function countNewUsers($year = "", $month = ""){
            self::connect();
            if($year !== "" && $month !==""){ // Count based on year and month.
                $statement = self::$connection->prepare("SELECT COUNT(username) FROM users WHERE YEAR(joinDate) = :year AND MONTH(joinDate) = :month");
                $statement->execute([':year'=>$year, ':month'=>$month]);
            }elseif($year !==""){ // Count based on year.
                $statement = self::$connection->prepare("SELECT COUNT(username) FROM users WHERE YEAR(joinDate) = :year");
                $statement->execute([':year'=>$year]);
            }else{ // Count overall.
                $statement = self::$connection->query("SELECT COUNT(username) FROM users");
            }
            $result = $statement->fetchColumn();
            self::disconnect();
            return $result;
        }

        // Count the amount of games the website sold.
        public function countSoldGames($year = "", $month = ""){
            self::connect();
            if($year !== "" && $month !==""){ // Count based on year and month.
                $statement = self::$connection->prepare("SELECT COUNT(purchaseId) FROM purchases where YEAR(purchases.purchaseDate) = :year and MONTH(purchases.purchaseDate) = :month");
                $statement->execute([':year'=>$year, ':month'=>$month]);
            }elseif($year !==""){ // Count based on year.
                $statement = self::$connection->prepare("SELECT COUNT(purchaseId) FROM purchases where YEAR(purchases.purchaseDate) = :year");
                $statement->execute([':year'=>$year]);
            }else{ // Count overall.
                $statement = self::$connection->query("SELECT COUNT(purchaseId) FROM purchases");
            }
            $result = $statement->fetchColumn();
            self::disconnect();
            return $result;
        }
        }
