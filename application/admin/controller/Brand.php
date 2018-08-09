<?php
namespace app\admin\controller;	
use think\Loader;
use think\Db;
class Brand extends Commond{
	
	public function brandList(){
		$list=Db::name('brand')->paginate(1);
		$this->assign('list',$list);
		$this->assign('title','品牌列表');
		return $this->fetch();
	}
	
	public function brandAdd(){
		if(request()->isPost()){
			$data=input('post.');
			$validate=Loader::validate('Brand');
			if(!$validate->check($data)){
				$this->error($validate->getError());die;
			}
			$re = Db::name('brand')->insert($data);
//			print_r($re);die;
			if($re){
				$this->success('添加成功','Brand/brandList');die;
			}else{
				$this->error('添加失败');die;
			}
		}
		$this->assign('title','品牌添加');
		return $this->fetch();
	}
	
	public function brandUpdate(){
		$id=input('id');
		if(request()->isPost()){
			$data=input('post.');
			$validate=Loader::validate('Brand');
			if(!$validate->check($data)){
				$this->error($validate->getError());die;
			}
			$re=Db::name('brand')->where("id=$id")->update($data);
			if($re>0){
				$this->success('修改成功','Brand/brandList');die;
			}else{
				$this->error('修改失败');die;
			}
		}
		$one=Db::name('brand')->where('id='.$id)->find();
		$this->assign('one',$one);
		$this->assign('title','品牌编辑');
		return $this->fetch();
	}
	
	public function brandDelete(){
		$id=input('id');
		$re=Db::name('brand')->where("id=$id")->delete();
		if($re>0){
			$this->success('删除成功','Brand/brandList');die;
		}else{
			$this->error('删除失败');die;
		}
	}
}
?>