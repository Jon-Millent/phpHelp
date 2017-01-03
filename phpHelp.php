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
		public function replace($rule,$g){
			return preg_replace($rule,$g,$this->val);
		}
		public function indexOf($rule){
			for($i=0;$i<$this->length;$i++){
				if($this->charAt($i) == $rule){
					return true;
				}
			}
			return false;
		}
	}
	class ArrFactory{
		protected $val;
		protected $length;
		protected $index = 0;
		function __construct($arr=Array()){
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
		protected function setLength(){
			 return $this->length=sizeof($this->val);
		}
		public function get($index){
			return $this->val[$index];
		}
		public function set($index,$val){
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
			return false;
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
		public function getIndex($val){
			while($this->each()){
				$hh = $this->next();
				if($hh[1] == $val){
					return $hh[0];
				}
			}
			return -1;
		}
	}
	class MArray extends ArrFactory{

	}
	class MJson extends ArrFactory{

		public function set($k,$v){
			$this->val[$k] = $v;
		}
		public function get($k){
			return $this->val[$k];
		}
		public function each(){
			return $this->val;
		}
		public function stringify(){
			return json_encode($this->val);
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
		public static function parse($json){
			return new MJson(var_dump(json_decode($json, true)));
		}
	}
	class MRegExp{
		private $rule;
		function __construct($rule){
			$this->rule = $rule;
		}
		public function test($str,$type=''){
			if($type == ''){
				return preg_match($this->rule,$str);
			}else if($type == 'g'){
				return preg_match_all($this->rule,$str);
			}
			
		}
	}
	class MFileSystem{
		protected $url;
		protected $type;
		protected $lasturl;
		function __construct($url,$lasturl,$type){
			$this->url = $url;
			$this->type = $type;
			$this->lasturl = $lasturl;
		}
		function __toString(){
			return $this->url;
		}
		public function readFile(){
			$file = fopen($this->url,"r");
			$hh = fread($file,filesize($this->url));
			fclose($file);
			return $hh;
		}
		public function writeFile($text){
			$file = fopen($this->url,"w");
			$len = fwrite($file,$text);
			fclose($file);
			return $len;
		}
		public function createFile($name){
			$ggurl = $this->lasturl.$this->type.$name;
			if(!file_exists($ggurl)){
				fopen($ggurl,'w+');
				return new MFileSystem($ggurl,$this->lasturl,$this->type);
			}
			return false;
		}
		public function append($text){

			$file = fopen($this->url,"a");
			$len = fwrite($file,$text);
			fclose($file);
			return $len;
			
		}
		public function rename($name){
			return rename($this->url, $this->lasturl.$this->type.$name);
		}
		public function remove(){
			return unlink($this->url);
		}
	}
	class MFile{
		protected $url;
		protected $concat;
		protected $nowOpen;
		protected $nowOpenType; //1 File ,2 Folder
		protected $childrenAllName = Array();
		protected $childrenName = Array();
		function __construct($url){
			if(is_dir($url)){
				$this->url = $url;
				$this->compConstruct();
			}
		}	
		protected function compConstruct(){
			if ($dh = opendir($this->url)){
				array_splice($this->childrenAllName,0,sizeof($this->childrenAllName)-1);
				array_splice($this->childrenName,0,sizeof($this->childrenName)-1);
				while (($file = readdir($dh))!= false){
					$filePath = $this->url.$file;
					array_push($this->childrenAllName,$filePath);
					array_push($this->childrenName,$file);
				}
				closedir($dh);
			}
			$contype = new MString($this->url);
			
			if($contype->indexOf('/')){
				$this->concat = '/';
			}else if($contype->indexOf('\\')){
				$this->concat = '\\';
			}
			$this->url = $contype->replace('/[\|\/]$/','');			
		}
		protected function compLastUrl(){
			$gg = new MString($this->url);
			$hh = $gg->split($this->concat);
			$hh->pop();
			return $hh->join($this->concat);
		}
		function __toString(){
			return $this->url;
		}
		protected function concatURL($filename){
			
			return $this->url.$this->concat.$filename;
		}
		public function getChildren(){
			return new MArray($this->childrenName);
		}
		public function getChildrenFull(){
			return new MArray($this->childrenAllName);
		}
		public function open($filename){
			$this->nowOpen = $this->concatURL($filename);
			if(file_exists($this->nowOpen)){
				if(is_file($this->nowOpen)){
					$this->nowOpenType = 1;
					return new MFileSystem($this->nowOpen,$this->url,$this->concat);
				}else{
					$this->nowOpenType = 2;
					$this->url = $this->nowOpen;
					$this->compConstruct();
				}	
				return $this;
			}else{
				return false;
			}
		}
		public function rename($name){
			$last = $this->compLastUrl();
			if(rename($this->url,$last.$this->concat.$name)){
				$this->url = $last.$this->concat.$name;
				return true;
			}
			return false;
		}
		// public function remove(){
		// 	if($this->getChildren()->length <= 1){
		// 		rmdir($this->url);
		// 	}else{
				
		// 	}
		// }
	}


?>
