<?php

	function md_crypt($str){
		return md5(crypt($str,config('pwdstring')));
	}
	
	function alipay($orderid,$total,$subject,$body){
		include 'alipay/wappay/pay.php';
	}
	
	function notify_url(){
		include 'alipay/notify_url.php';
	}
	
	function return_url(){
		include 'alipay/return_url.php';
	}
?>