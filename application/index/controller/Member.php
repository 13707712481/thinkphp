<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
class Member extends Controller
{
	//登录
    public function login()
    {
    	if(request()->isAjax()){
    		$data=input('post.');
//			print_r($data);die;
			$info=['code'=>0,'info'=>false,'msg'=>''];
			$validate=$this->validate($data,[
				'username'=>'require',
				'password'=>'require',
			],[
				'username.require'=>'用户名不能为空',
				'password.require'=>'密码不能为空',
			]);
			if(true===$validate){				
				$data['password'] = md_crypt($data['password']);
//				print_r($data['password']);die;
				$model= new User($data);
				$re=$model->where($data)->find();			
				if($re){
					session('username',$re->username);
					session('userId',$re->id);
					$info=['code'=>1,'info'=>true,'msg'=>'登录成功'];
					return $info;
				}else{
					$info=['code'=>0,'info'=>false,'msg'=>'登录失败'];
					return $info;
				}
			}else{
				$info['msg']=$validate;
				return $info;
			}
			
    	}
		
		$this->assign([
			'title'=>'登录',
		]);
        return $this->fetch();
    }
	
	//注册
	 public function register()
    {
    	if(request()->isAjax()){
    		$data=input('post.');
//			print_r($data);die;
			$info=['code'=>0,'info'=>false,'msg'=>''];
			$validate=$this->validate($data,[
				'username'=>'require',
				'password'=>'require|confirm',
				'email'=>'email',
			],[
				'username.require'=>'用户名不能为空',
				'password.require'=>'密码不能为空',
				'password.confirm'=>'两次密码不一致',
				'email.email'=>'邮箱格式不正确',
			]);
			if(true===$validate){				
				$data['password'] = md_crypt($data['password']);
//				print_r($data);die;
				$model= new User($data);
				$re=$model->allowField(true)->save();			
				if($re){
					$info=['code'=>1,'info'=>true,'msg'=>'注册成功'];
					return $info;
				}else{
					$info=['code'=>0,'info'=>false,'msg'=>'注册失败'];
					return $info;
				}
			}else{
				$info['msg']=$validate;
				return $info;
			}
			
    	}
		$this->assign([
			'title'=>'注册',
		]);
        return $this->fetch();
    }
	
	//退出
	public function logout(){
		session(null);
		$this->error('退出成功','Index/index');
	}
	
	//用户中心
	public function user(){
		//导航
    	$clist=db('category')->where("fid=2")->select();
		$this->assign([
			'title'=>'用户中心',
			'clist'=>'$clist'
		]);
		return $this->fetch();
	}
	
	public function address(){
		//导航
    	$clist=db('category')->where("fid=2")->select();
		if(request()->isAjax()){
			$info=['code'=>0,'info'=>false,'msg'=>''];
			$data=input('post.');
			$validate=$this->validate($data,[
				'province'=>'require',
				'city'=>'require',
				'country'=>'require',
				'linkman'=>'require',
				'phone'=>'require',
				'address'=>'require',
			]);
			if(true===$validate){
							
				$re=db('address')->insert($data);
				print_r($re);die;
				if($re){
					$info=['code'=>500,'info'=>true,'msg'=>'添加成功'];
					return $info;
				}else{
					$info=['code'=>400,'info'=>false,'msg'=>'添加失败'];
					return $info;
				}
			}else{
				$info['msg']=$validate;
				return $info;
			}
		}
		$mop['mid']=session('userId');
		$list=db('address')->where($mop)->select();
		$this->assign([
			'list'=>$list,
			'clist'=>$clist,
			'title'=>'地址管理',
		]);
		return $this->fetch();
	}
	
}
