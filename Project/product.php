<?php
	class Product{
		private $id;
		private $name;
		private $img;
		private $amount;
		private $price;
		private $discount;
		private $rating;
		
		// constructor
		public function __construct($id = null, $name = null, $img = null, $amount = null, $price = null, $discount = null, $rating = null){
			$this->id = $id === null? $this->id : $id;
			$this->name = $name === null? $this->name : $name;
		 	$this->img = $img === null? $this->img : $img;
			$this->amount = $amount === null? $this->amount : $amount;
			$this->price = $price === null? $this->price : $price;
			$this->discount = $discount === null? $this->discount : $discount;
			$this->rating = $rating === null? $this->rating : $rating;
		}
		
		// Getters & Setters
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}

		public function getImg(){
			return $this->img;
		}
		
		public function setImg($img){
			$this->img = $img;
		}		
		
		public function getAmount(){
			return $this->amount;
		}
		
		public function setAmount($amount){
			$this->amount = $amount;
		}
		
		public function getPrice(){
			return $this->price;
		}
		
		public function setPrice($price){
			$this->price = $price;
		}
		
		public function getDiscount(){
			return $this->discount;
		}
		
		public function setDiscount($discount){
			$this->discount = $discount;
		}
		
		public function getRating(){
			return $this->rating;
		}
		
		public function setRating($rating){
			$this->rating = $rating;
		}
	}
?>