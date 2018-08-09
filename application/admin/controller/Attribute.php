<?php
namespace app\admin\controller;	
use think\Loader;
use think\Db;
class Attribute extends Commond{
	
	public function attrList(){
		$tid=input('tid');
		$list=Db::name('attribute')->where(['tid'=>$tid])->paginate(1);
		$this->assign('list',$list);
		$this->assign('title','属性列表');
		return $this->fetch();
	}
	
	public function attrAdd(){
		if(request()->isPost()){
			$data=input('post.');
			$options=$data['options'];
			unset($data['options']);			
			$re = Db::name('attribute')->insertGetId($data);//只要主键
//			print_r($re);die;
			if($re){
				$oparr=explode(',', $options);
				foreach($oparr as $k=>$v){
					$arr['aid']=$re;
					$arr['name']=$v;
					db('options')->insert($arr);
				}
				$this->success('添加成功',url('Attribute/attrList',['tid'=>$data['tid']]));die;
			}else{
				$this->error('添加失败');die;
			}
		}
		$tid=db('type')->select();
//		print_r($tid);die;
		$this->assign('tid',$tid);
		$this->assign('title','属性添加');
		return $this->fetch();
	}
	
	public function attrUpdate(){
		$id=input('id');
		if(request()->isPost()){
			$data=input('post.');
			$re=Db::name('attribute')->where("id=$id")->update($data);
			if($re>0){
				$this->success('修改成功','Attribute/attrList');die;
			}else{
				$this->error('修改失败');die;
			}
		}
		$one=Db::name('attribute')->where('id='.$id)->find();
		$this->assign('one',$one);
		$this->assign('title','属性编辑');
		return $this->fetch();
	}
	
	public function attrDelete(){
		$id=input('id');
		$re=Db::name('attribute')->where("id=$id")->delete();
		if($re>0){
			$this->success('删除成功','Attribute/attrList');die;
		}else{
			$this->error('删除失败');die;
		}
	}
}
?>