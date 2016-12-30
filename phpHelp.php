<?php 
	header('Content-type:text/html;charset=utf-8');
	class String{
		private $val;
		private $length;
		const CODETYPE = 'utf-8';
		function __construct($val){
			$this->val = $val;
			$this->length = $this->compStringLength($val);
		}
		function __set($property_name,$val){
			if($property_name == 'length'){
				if($val == 0){
					$this->val = '';
					$this->length = 0;
				}
			}
		}
		function __get($property_name){
			return $this->$property_name;
			
		}
		private function compStringLength($str){
			if(function_exists('mb_strlen')){
				return mb_strlen($str,self::CODETYPE);
			}
			else {
				preg_match_all("/./u", $str, $ar);
				return count($ar[0]);
			}
		}
		public function __toString(){
			return $this->val;
		}
		public function toLowerCase(){
			return strtolower($this->val);
		}
		public function toUpperCase(){
			return strtoupper($this->val);
		}
		public function toUpperCaseFirst(){
			return ucfirst($this->val);
		}
		public function split($rule){
			if($rule == ''){

			}else{
				// Autu Array
			}
			
		}
		public function charAt($index){
			$e = $index;
			if($index == 0){
				$e = $index+1;
			}
			return $this->slice($index,$e);
		}
		public function slice($start,$end){
			return mb_substr($this->val,$start,$end,self::CODETYPE);
		}
		public function set($str){
			if(is_string($str)){
				$this->val = $str;
				$this->length = $this->compStringLength($val);
			}
			return $str;
		}
	}


	


?>
