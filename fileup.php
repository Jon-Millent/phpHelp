<?php 

	include "phpHelp.php";
	$j = new MJson();
	
	function getFileName(){
		$tt = new MString(date('Y-m-d H:i:s'));
		return $tt->replace('/[-|:|\s]/','');
	}
	
	$typeArray = Array('image/png'=>'png','image/gif'=>'gif','image/jpeg'=>'jpeg');
	$size = $_FILES['file']['size'];
	$type = $_FILES['file']['type'];

	if($type == 'image/png' || $type == 'image/gif' || $type == 'image/jpeg'){
		if($size > 1000000){
			$j->set('code','1');
			$j->set('content','文件大小超出');
			echo $j->stringify();
			return;
		}else if(  $_FILES["file"]["error"] > 0){
			$j->set('code','2');
			$j->set('content','网络错误');
			echo $j->stringify();

			return;
		}else{
			move_uploaded_file($_FILES["file"]["tmp_name"],
      "../data/" . getFileName().'.'.$typeArray[$type]);
      		$j->set('code','3');
			$j->set('content','ok');
			echo $j->stringify();

			return;
		}
	}else{
		$j->set('code','4');
		$j->set('content','格式错误');
		echo $j->stringify();
		return;
	}

?>
