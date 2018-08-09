<?php
namespace app\admin\controller;	
use think\Loader;
use think\Db;
class Type extends Commond{
	
	public function typeList(){
		$list=Db::name('type')->paginate(1);
		$this->assign('list',$list);
		$this->assign('title','商品类型');
		return $this->fetch();
	}
	
	public function typeAdd(){
		if(request()->isPost()){
			$data=input('post.');
			$re = Db::name('type')->insert($data);
//			print_r($re);die;
			if($re){
				$this->success('添加成功','Type/typeList');die;
			}else{
				$this->error('添加失败');die;
			}
		}
		$this->assign('title','类型添加');
		return $this->fetch();
	}
	
	public function typeUpdate(){
		$id=input('id');
		if(request()->isPost()){
			$data=input('post.');
			$re=Db::name('type')->where("id=$id")->update($data);
			if($re>0){
				$this->success('修改成功','Type/typeList');die;
			}else{
				$this->error('修改失败');die;
			}
		}
		$one=Db::name('type')->where('id='.$id)->find();
		$this->assign('one',$one);
		$this->assign('title','类型编辑');
		return $this->fetch();
	}
	
	public function typeDelete(){
		$id=input('id');
		$re=Db::name('type')->where("id=$id")->delete();
		if($re>0){
			$this->success('删除成功','Type/typeList');die;
		}else{
			$this->error('删除失败');die;
		}
	}
}
?>