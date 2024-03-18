<?php
	class User{
		private $username;
		private $password;
        private $gender;
        private $birthDate;
        private $joinDate;
        private $email;
		private $country;
        private $city;
        private $address;
        private $isAdmin;
        private $online;
                
        // constructor
		public function __construct($username = null, $password = null, $gender = null, $birthDate = null, $joinDate = null, $email  = null, $country = null, $city = null, $address = null, $isAdmin = null, $online = null){
			$this->username = $username === null? $this->username : $username;
            $this->password = $password=== null? $this->password : $password;
            $this->gender = $gender=== null? $this->gender : $gender;
            $this->birthDate = $birthDate=== null? $this->birthDate : $birthDate;
            $this->joinDate = $joinDate=== null? $this->joinDate : $joinDate;
			$this->email = $email=== null? $this->email : $email;
			$this->country = $country=== null? $this->country : $country;
			$this->city = $city=== null? $this->city : $city;
            $this->address = $address=== null? $this->address : $address;
            $this->isAdmin = $isAdmin=== null? $this->isAdmin : $isAdmin;
            $this->online = $online=== null? $this->online : $online;
		}
        
        // Getters & Setters
		public function getUsername(){
			return $this->username;
		}

		public function setUsername($username){
			$this->username = $username;
		}
		
		public function getPassword(){
			return $this->password;
		}
		
		public function setPassword($password){
			$this->password = $password;
        }
        
        public function getGender(){
			return $this->gender;
		}
		
		public function setGender($gender){
			$this->gender = $gender;
        }
        
        public function getBirthDate(){
			return $this->birthDate;
		}
		
		public function setBirthDate($birthDate){
			$this->birthDate = $birthDate;
        }

        public function getJoinDate(){
			return $this->joinDate;
		}
		
		public function setJoinDate($joinDate){
			$this->joinDate = $joinDate;
		}        
		
		public function getEmail(){
			return $this->email;
		}
		
		public function setEmail($email){
			$this->email = $email;
		}
		
		public function getCountry(){
			return $this->country;
		}
		
		public function setCountry($country){
			$this->country = $country;
		}
		
		public function getCity(){
			return $this->city;
		}
		
		public function setCity($city){
			$this->city = $city;
		}
		
		public function getAddress(){
			return $this->address;
		}
		
		public function setAddress($address){
			$this->address = $address;
        }
        
        public function isAdmin(){
			return $this->isAdmin;
		}
		
		public function setAdmins($admin){
			$this->isAdmin = $admin;
        }

        public function isOnline(){
			return $this->online;
		}
		
		public function setOnline($online){
			$this->online = $online;
        }
	}
?>