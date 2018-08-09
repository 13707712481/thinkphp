<?php
namespace app\admin\controller;
use think\Config;
use think\Controller;
//use think\Request;
use think\Db;
class Admin extends Controller{
	public function login(){
//		echo md5(crypt('123',config('pwdstring')));die;
//		$str = config('pwdstring');
		if(request()->isAjax()){
			$info=['error'=>false,'msg'=>''];
			//先判断验证码
//			print_r(input('post.code')) ;exit;
			if(!captcha_check(input('post.code'))){
				trace('验证码错误','info');
				$info['msg']='验证码错误';
				return $info;
			}
			$name=input('post.name');
			$one=Db::name('manager')->where("name='$name'")->find();
			if(!($one)){
				trace('用户名不存在','info');
				$info['msg']='用户名不存在';
				return $info;
			}
			$password=input('post.pwd');
			if($one['pwd'] != md5(crypt($password,config('pwdstring')))){
				trace('账号或密码有误','info');
				$info['msg']='账号或密码有误';
				return $info;
			}
			
			//处理数据
			session('user',$name);
			session('userId',$one['id']);
			
			if($one['id']!=config('superadmin')){							
				//权限
				$rid=$one['rid'];//角色id
				$role=Db::name('role')->where("id=$rid")->find();
				session('lever',explode('|', $role['lever']));
			}else{
				$arr=db('lever')->field('id')->select();
				$leverarr=array();
				foreach($arr as $k=>$v){
					$leverarr[]=$v['id'];					
				}
				session('lever',$leverarr);
			}
			trace('登录成功','info');
			$info=['error'=>true,'msg'=>'登录成功'];
			return $info;
		}
		return $this->fetch();
	}
	
	function logout(){
		session(null);
		$this->success('退出成功','login');
	}
}


?>