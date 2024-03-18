<?php
	class Purchase{
		private $purchaseId;
		private $username;
		private $gameId;
		private $purcaseDate;

		// constructor		
		public function __construct($purchaseId = null, $username = null, $gameId = null, $purcaseDate = null){
			$this->purchaseId = $purchaseId === null? $this->purchaseId : $purchaseId;
			$this->username = $username === null? $this->username : $username;
            $this->gameId = $gameId === null? $this->gameId : $gameId;
            $this->purcaseDate = $purcaseDate === null? $this->purcaseDate : $purcaseDate;
		}
		
		// Getters & Setters
        public function getPurchaseId(){
            return $this->purchaseId;
        }
        
        public function setPurchaseId($purchaseId){
            $this->purchaseId = $purchaseId;
        }
        
        public function getUsername(){
            return $this->username;
        }
        
        public function setUsername($username){
            $this->username = $username;
        }
		
		public function getGameId(){
			return $this->gameId;
		}

		public function setGameId($gameId){
			$this->gameId = $gameId;
		}

		public function getPurcaseDate(){
			return $this->purcaseDate;
		}
		
		public function setPurcaseDate($purcaseDate){
			$this->purcaseDate = $purcaseDate;
		}		

	}
?>