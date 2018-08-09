<?php
namespace app\admin\controller;	
use think\Loader;
use think\Db;
class Lever extends Commond{
	
	public function leverList(){
		$list=$this->lever();
//		print_r($list);die;
		$this->assign('list',$list);
		$this->assign('title','权限列表');
		return $this->fetch();
	}
	
	public function leverAdd(){
		if(request()->isPost()){
			$data=input('post.');
			$re = Db::name('lever')->insert($data);
//			print_r($re);die;
			if($re){
				$this->success('添加成功','Lever/leverList');die;
			}else{
				$this->error('添加失败');die;
			}
		}
		$list=$this->lever();
		$this->assign('list',$list);
		$this->assign('title','权限添加');
		return $this->fetch();
	}
	
	public function leverUpdate(){
		$id=input('id');
		if(request()->isPost()){
			$data=input('post.');
			$re=Db::name('lever')->where("id=$id")->update($data);
			if($re>0){
				$this->success('修改成功','Lever/leverList');die;
			}else{
				$this->error('修改失败');die;
			}
		}
		$one=Db::name('lever')->where('id='.$id)->find();
//		print_r($one);die;
		$this->assign('one',$one);
		$list=$this->lever();
//		print_r($list);die;
		$this->assign('list',$list);
		$this->assign('title','权限编辑');
		return $this->fetch();
	}
	
	public function leverDelete(){
		$id=input('id');
		$re=Db::name('lever')->where("id=$id")->delete();
		if($re>0){
			$this->success('删除成功','Lever/leverList');die;
		}else{
			$this->error('删除失败');die;
		}
	}
}
?>