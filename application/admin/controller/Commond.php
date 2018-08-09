<?php
namespace app\admin\controller;
use think\Controller;

class Commond extends Controller{
	public function __construct(){
		parent::__construct();
		$this->isLogin();
		$menu=$this->menu();
//		print_r($menu);die;
		$this->assign('menu',$menu);
		$controller=strtolower(request()->controller()); //获取当前控制器
		$action=strtolower(request()->action());//获取当前方法
		$this->assign('controller',$controller);
		$this->assign('action',$action);
		$adminlever=session('lever');
//		print_r($adminlever);die;
		$this->assign('adminlever',$adminlever);
		if(session('userId')!=config('superadmin')) $this->isLever();
	}
	private function isLogin(){
		if(!session('?user')){
			$this->error('请先登录','Admin/login');
		}
	}
	
	function cate($id=0,$list=[],$spac=0){
		if($id>0) $spac ++;
		$fid=$id;
		$plist=db('category')->where("fid=$fid")->select();
		foreach($plist as $k=>$v){
			$v['name']=str_repeat('|-', $spac).$v['name'];
			$list[]=$v;
			$list=$this->cate($v['id'],$list,$spac);
		}
		return $list;
	}
	
	function lever($id=0,$list=[],$spac=0){
		if($id>0) $spac ++;
		$fid=$id;
		$plist=db('lever')->where("fid=$fid")->select();
		foreach($plist as $k=>$v){
			$v['name']=str_repeat('|-', $spac).$v['name'];
			$list[]=$v;
			$list=$this->lever($v['id'],$list,$spac);
		}
		return $list;
	}
	
	function upload($ufile){
		$file=request()->file($ufile);
		$dataImg=[];
		if($file){
			foreach($file as $k=>$v){
				$filePath='./public/static/admin/upload/'.date('Y-m-d');
				if(!file_exists($filePath)){
					mkdir($filePath,0777,true);
				}
				//验证格式，上传
				$info=$v->validate(['size'=>2*1024*1024,'ext'=>'jpg,png,jpeg,gif'])->rule('uniqid')->move($filePath);
				if($info){
					$dataImg[]=rtrim($filePath,'/').'/'.$info->getSaveName();
				}
			}
		}
		return $dataImg;
	}
	
	function thumb($path,$w=150,$h=150){
		$image=\think\Image::open($path);
		$tbPath=dirname($path).'/thumb';
		if(!file_exists($tbPath)){
				mkdir($tbPath,0777,true);
		}
		$thumb=$tbPath.'/'.basename($path);
		$image->thumb($w,$h)->save($thumb);
		return 	$thumb;
	}
	
	function water($path,$type=2,$state=9){
		$image=\think\Image::open($path);
		if($type==1){
			switch($state){
				case 1:
					$image->water('./logo.png',\think\Image::WATER_NORTHWEST)->save($path);
					break;
				case 2:
					$image->water('./logo.png',\think\Image::WATER_NORTH)->save($path);
					break;
				case 3:
					$image->water('./logo.png',\think\Image::WATER_NORTHEAST)->save($path);
					break;
				case 4:
					$image->water('./logo.png',\think\Image::WATER_WEST)->save($path);
					break;
				case 5:
					$image->water('./logo.png',\think\Image::WATER_CENTER)->save($path);
					break;
				case 6:
					$image->water('./logo.png',\think\Image::WATER_EAST)->save($path);
					break;
				case 7:
					$image->water('./logo.png',\think\Image::WATER_SOUTHWEST)->save($path);
					break;
				case 8:
					$image->water('./logo.png',\think\Image::WATER_SOUTH)->save($path);
					break;
				case 9:
					$image->water('./logo.png',\think\Image::WATER_SOUTHEAST)->save($path);
					break;
			}
		}else{
			$image->text('宏利','./public/static/admin/fonts/msyh.ttf',20,'#000000')->save($path);
		}
	}

	//权限菜单
	function menu($id=0,$list=[],$spac=0){
		if($id>0) $spac ++;
		$fid=$id;
		$plist=db('lever')->where("fid=$fid")->select();
		foreach($plist as $k=>$v){
			$list[]=$v;
			$list=$this->menu($v['id'],$list,$spac);
		}
		return $list;
	}
	//权限判断
	function isLever(){
		$controller=strtolower(request()->controller()); //获取当前控制器
		$action=strtolower(request()->action());//获取当前方法
		$one=db('lever')->where("controller='$controller' and action='$action'")->find();
		if(!in_array($one['id'],session('lever'))){
			$this->error('无权访问','admin/login');
		}
	}
	
}
?>