<?php
namespace app\admin\controller;	
use think\Loader;
use think\Db;
use app\admin\model\Manager as User;
class Manager extends Commond{
	
	public function managerList(){
		$list=Db::name('manager')
		->alias('m')
		->field('m.*,r.name as rname')
		->join('tp_role r','m.rid=r.id','left')
		->order('m.id desc')
		->paginate(2);
		$this->assign('list',$list);
//		print_r($list);die;
		$this->assign('title','管理员列表');
		return $this->fetch();
	}
	
	public function managerAdd(){
		if(request()->isPost()){
			$data=input('post.');
//			print_r($data);die;
			$validate=Loader::validate('Manager');
			if(!$validate->check($data)){
				$this->error($validate->getError());die;
			}			
			$name=$data['name'];
			$hasName=Db::name('manager')->where("name=$name")->find();
			if($hasName) $this->error('用户名已存在');
			$data['pwd']=md5(crypt($data['pwd'],config('pwdstring')));
			$manager= new User();
			$re=$manager->allowField(true)->save($data);			
//			print_r($pwd);die;
			if($re){
				$this->success('添加成功','Manager/managerList');die;
			}else{
				$this->error('添加失败');die;
			}
		}
		$list=Db::name('role')->select();
//		print_r($list);die;
		$this->assign('list',$list);
		$this->assign('title','管理员添加');
		return $this->fetch();
	}
	
	public function managerUpdate(){
		$id=input('id');
		if(request()->isPost()){
			$data=input('post.');
			$validate=$this->validate($data,[
				'name' => 'require',
			]);	
//			print_r($data);die;
			if(true === $validate){
				$manager= new User();
				$re=$manager->allowField(true)->save($data,['id'=>$data['id']]);
				if($re){
					$this->success('编辑成功','Manager/managerList');die;
				}else{
					$this->error('编辑失败');die;
				}
			}else{
				$this->error($validate);
			}
		}
		$one=Db::name('manager')->where('id='.$id)->find();
		$this->assign('one',$one);
		$list=Db::name('role')->select();
//		print_r($list);die;
		$this->assign('list',$list);
		$this->assign('title','管理员编辑');
		return $this->fetch();
	}
	
	public function managerDelete(){
		$id=input('id');
		$re=Db::name('manager')->where("id=$id")->delete();
		if($re>0){
			$this->success('删除成功','Manager/managerList');die;
		}else{
			$this->error('删除失败');die;
		}
	}
}
?>