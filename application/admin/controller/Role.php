<?php
namespace app\admin\controller;	
use think\Loader;
use think\Db;
class Role extends Commond{
	
	public function roleList(){
		$list=Db::name('role')->select();
		$leverList=Db::name('lever')->field('id,name')->select();	
//		print_r($leverList);die;
		foreach($list as $k=>$v){
			$leverName=array();
			$arrId=explode('|', $v['lever']);
//			print_r($v['lever']);die;
			foreach($leverList as $kk=>$vv){
				if(in_array($vv['id'],$arrId)){
					$leverName[]=$vv['name'];
//					print_r($leverName);die;
				}
			}
			$list[$k]['lever']=implode('|', $leverName);
		}
		
		$this->assign('list',$list);
		$this->assign('title','角色列表');
		return $this->fetch();
	}
	
	public function roleAdd(){
//		echo 465;die;
		if(request()->isPost()){
			$data=input('post.');	
//			print_r($data);die;		
			$validate=$this->validate($data,[
				'name' => 'require',
				'lever' => 'require',
			]);
			if(true===$validate){
				$data['lever']=implode('|', $data['lever']);
				$re = Db::name('role')->insert($data);
//				print_r($re);die;
				if($re){
					$this->success('添加成功','Role/roleList');die;
				}else{
					$this->error('添加失败');die;
				}
			}else{			
				$this->error($validate);
			}
		}
		$list=$this->lever();
		$this->assign('list',$list);
		$this->assign('title','角色添加');
		return $this->fetch();
	}
	
	public function roleUpdate(){
		$id=input('id');
		if(request()->isPost()){
			$data=input('post.');	
//			print_r($data);die;		
			$validate=$this->validate($data,[
				'name' => 'require',
				'lever' => 'require',
			]);
			if(true===$validate){
				$data['lever']=implode('|', $data['lever']);
				$re = Db::name('role')->where('id='.$id)->update($data);
//				print_r($re);die;
				if($re){
					$this->success('编辑成功','Role/roleList');die;
				}else{
					$this->error('编辑失败');die;
				}
			}else{			
				$this->error($validate);
			}
		}
		$one=Db::name('role')->where('id='.$id)->find();
		$one['lever']=explode('|', $one['lever']);
//		print_r($one['lever']);die;
		$this->assign('one',$one);
		$list=$this->lever();
		$this->assign('list',$list);
		$this->assign('title','角色编辑');
		return $this->fetch();
	}
	
	public function roleDelete(){
		$id=input('id');
		$re=Db::name('role')->where("id=$id")->delete();
		if($re>0){
			$this->success('删除成功','Role/roleList');die;
		}else{
			$this->error('删除失败');die;
		}
	}
}
?>