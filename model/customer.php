<?php
	class Customer{		

		private $id;
		private $name;
        private $age;
        private $email;
        private $join_date;
		private $address;
        private $reward_point;
		private $image;
		
		/*
		function __construct($id, $name, $age, $email, $join_date, $address, $reward_point){
			$this->setId($id);
			$this->setName($name);
            $this->setAge($age);
            $this->setEmail($email);
            $this->setJoinDate($join_date);
			$this->setAddress($address);
            $this->setRewardPoint($reward_point);
			}
		*/
	
		
		function __construct($id, $name, $age, $email, $join_date, $address, $reward_point, $image){
			$this->setId($id);
			$this->setName($name);
			$this->setAge($age);
			$this->setEmail($email);
			$this->setJoinDate($join_date);
			$this->setAddress($address);
			$this->setRewardPoint($reward_point);
			$this->setImage($image);
			}	

		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}

        public function getAge(){
			return $this->age;
		}
		
		public function setAge($age){
			$this->age = $age;
		}

        public function getEmail(){
			return $this->email;
		}
		
		public function setEmail($email){
			$this->email = $email;
		}

        public function getJoinDate(){
			return $this->join_date;
		}
		
		public function setJoinDate($join_date){
			$this->join_date = $join_date;
		}
        public function getRewardPoint(){
			return $this->reward_point;
		}

		public function setRewardPoint($reward_point){
			$this->reward_point = $reward_point;
		}

		public function getAddress(){
			return $this->address;
		}
		
		public function setAddress($address){
			$this->address = $address;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}
		public function getImage(){
			return $this->image;
		}
		
		public function setImage($image){
			$this->image = $image;
		}
	}
?>