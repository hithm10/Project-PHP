<?php
	class Cart{
		private $cartNum; // cart number
		private $username; // name of user that own the cart
		private $id; // id of the product in cart

		// constructor
		public function __construct($cartNum = null, $username = null, $id = null){
			$this->cartNum = $cartNum === null? $this->cartNum : $cartNum;
			$this->username = $username === null? $this->username : $username;
            $this->id = $id === null? $this->id : $id;
		}
        
        // Getters & Setters
        public function getCartNum(){
            return $this->cartNum;
        }
        
        public function setCartNum($cartNum){
            $this->cartNum = $cartNum;
        }
        
        public function getUsername(){
            return $this->username;
        }
        
        public function setUsername($username){
            $this->username = $username;
        }
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}		
	}
?>