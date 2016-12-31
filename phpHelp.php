<?php 
	// header('Content-type:text/html;charset=utf-8');
	class MString{
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
				$gg = new MArray(Array());
				for($i=0;$i<$this->length;$i++){
					$gg->push($this->charAt($i));
				}
				return $gg;
			}else{
				return new MArray(explode($rule,$this->val));
			}
		}
		public function charAt($index){
			return $this->val[$index];
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
	class MArray{
		private $val;
		private $length;
		private $index = 0;
		function __construct($arr){
			$this->val = $arr;
			$this->length = sizeof($arr);
		}
		function __toString(){
			return implode($this->val);
		}
		function __get($property_name){
			return $this->$property_name;
		}
		function __set($property_name,$value){
			if($property_name == 'length' && $value == 0){
				$this->val = Array();
				$this->length = 0;
			}
		}
		private function setLength(){
			 return $this->length=sizeof($this->val);
		}
		function get($index){
			return $this->val[$index];
		}
		function set($index,$val){
			return $this->val[$index] = $val;
		}
		public function push($some){
			$gg = array_push($this->val,$some);
			$this->setLength();
			return $gg;
		}
		public function pop(){
			$gg = array_pop($this->val);
			$this->setLength();
			return $gg;
		}
		public function shift(){
			$gg = array_shift($this->val);
			$this->setLength();
			return $gg;
		}
		public function unshift($val){
			array_unshift($this->val,$val);
			$this->setLength();
			return $val;
		}
		public function indexOf($val){
			while($this->each()){
				$hh = $this->next();
				if($hh[1] == $val){
					return true;
				}
			}
			return -1;
		}
		public function each(){
			if($this->index < $this->length){
				$this->index++;
				return true;
			}else{
				$this->index=0;
				return false;
			}
		}
		public function next(){
			return Array($this->index-1,$this->val[$this->index-1]);
		}
		public function slice($start,$end){
			return array_slice($this->val,$start,$end);
		}
		public function splice($start,$end,$val){
			$gg = array_splice($this->val,$start,$end,$val);
			$this->setLength();
			return $gg;
		}
		public function join($rule){
			return join($rule,$this->val);
		}
		public function reverse(){
			$this->val = array_reverse($this->val);
			return new MArray($this->val);
		}
		public function sort($type = true){
			if($type){
				sort($this->val);
				return new MArray($this->val);
			}else{
				rsort($this->val);
				return new MArray($this->val);
			}
		}
	}
	class Tool{
		public static function String($number){
			return strval($number);
		}
		public static function Number($number){
			return intval($number);
		}
		public static function parseFloat($number){
			return floatval($number);
		}
		public static function parseInt($number){
			return intval($number);
		}
		public static function ceil($number){
			return ceil($number);
		}
		public static function round($number){
			return round($number);
		}
		public static function floor($number){
			return floor($number);
		}
		public static function random($min,$max){
			return rand($min+1,$max-1);
		}
	}
	
?>
