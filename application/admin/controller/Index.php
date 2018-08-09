<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\controller\Commond;

class Index extends Commond{
	function index(){
		$this->assign('title','后台首页');
		return $this->fetch();
	}
}
?>