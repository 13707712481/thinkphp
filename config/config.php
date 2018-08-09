<?php
	return [
		// 应用调试模式
	    'app_debug'              => true,
	    //开启并强制使用路由
	//  'url_route_on'           => true,
	//  'url_route_mast'         => false,
		'captcha' => [
		//验证码字符集合
			'codeSet' => '2345678abcdefghijklmnopqrstuvwxyzQWERTYUIOPASDFGHJKLZXCVBNM',
		//验证码字体大小
			'fontSize' => 14,
		//是否画混淆曲线
			'useCurve' => false,
		//验证码图片高度
			'imageH' =>28,
		//验证码图片宽度
			'imageW' =>120,
		//验证码位数
			'length' => 4,
		//验证码成功后是否重置
			'reset' => true
		],
	];
	
	
?>