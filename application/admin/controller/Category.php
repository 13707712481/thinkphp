<?php
namespace app\admin\controller;	
use think\Loader;
use think\Db;
class Category extends Commond{
	
	public function cateList(){
		$list=$this->cate();
		$this->assign('list',$list);
		$this->assign('title','分类列表');
		return $this->fetch();
	}
	
	public function cateAdd(){
		if(request()->isPost()){
			$data=input('post.');
			$re = Db::name('category')->insert($data);
//			print_r($re);die;
			if($re){
				$this->success('添加成功','Category/cateList');die;
			}else{
				$this->error('添加失败');die;
			}
		}
		$list=$this->cate();
		$this->assign('list',$list);
		$this->assign('title','分类添加');
		return $this->fetch();
	}
	
	public function cateUpdate(){
		$id=input('id');
		if(request()->isPost()){
			$data=input('post.');
			$re=Db::name('category')->where("id=$id")->update($data);
			if($re){
				$this->success('修改成功','Category/cateList');die;
			}else{
				$this->error('修改失败');die;
			}
		}
		$one=Db::name('category')->where('id='.$id)->find();
		$this->assign('one',$one);
		$list=$this->cate();
		$this->assign('list',$list);
		$this->assign('title','分类编辑');
		return $this->fetch();
	}
	
	public function cateDelete(){
		$id=input('id');
		$re=Db::name('category')->where("id=$id")->delete();
		if($re>0){
			$this->success('删除成功','Category/cateList');die;
		}else{
			$this->error('删除失败');die;
		}
	}
}
?>