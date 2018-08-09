<?php
namespace app\admin\controller;	
use think\Loader;
use think\Db;
use app\admin\model\Goods;

class Product extends Commond{
	
	public function proList(){
		$list=Db::name('product')
		->alias('p')
		->field('p.*,c.name as cname,b.name as bname')
		->join('tp_category c','p.cid=c.id')
		->join('tp_brand b','p.bid=b.id')
		->order('id desc')
		->paginate(2);
		$this->assign('list',$list);
		$this->assign('title','商品列表');
		return $this->fetch();
	}
	
	public function proAdd(){
		if(request()->isAjax()){
			$info=['code'=>0,'info'=>false,'msg'=>''];
			$data=input('post.');
//			print_r($data);die;
			//上传图片
			$dataImg=$this->upload('ufile');
			if($dataImg){	
				//缩略图
				$thumb=$this->thumb($dataImg[0]);
				//水印
				$this->water($dataImg[0]);
				$data['thumb']=$thumb;
				$data['picture']=implode(',', $dataImg);
			}
			$validate=$this->validate($data,[
				'name' => 'require',
				'cid' => 'require',
				'bid' => 'require',
				'price' => 'require',
			]);	
			if(true === $validate){
//				print_r($data);die;
				$product= new Goods($data);
				$re=$product->allowField(true)->save();
				if($re){
					$info=['code'=>500,'info'=>true,'msg'=>'添加成功'];
					return $info;
				}else{
					$info=['code'=>401,'info'=>false,'msg'=>'添加失败'];
					return $info;
				}
			}else{
				$info['code']=400;
				$info['msg']=$validate;
				return $info;
			}		
		}
		
		//类型
		$typelist=db('type')->select();
		$this->assign('typelist',$typelist);
		//属性
		
		//分类
		$cateList=$this->cate();
		//品牌
		$brandList=Db::name('brand')->select();
		$this->assign('cateList',$cateList);
		$this->assign('brandList',$brandList);
		$this->assign('title','商品添加');
		return $this->fetch();
	}
	
	public function proUpdate(){
		$id=input('id');
		if(request()->isAjax()){
			$data=input('post.');
			//上传图片
			$dataImg=$this->upload('ufile');
			if($dataImg){	
				//缩略图
				$thumb=$this->thumb($dataImg[0]);
				//水印
				$this->water($dataImg[0]);
				$data['thumb']=$thumb;
				$data['picture']=implode(',', $dataImg);
			}
			$validate=$this->validate($data,[
				'name' => 'require',
				'cid' => 'require',
				'bid' => 'require',
				'price' => 'require',
			]);	
			if(true === $validate){
				$product= new Goods();
				$re=$product->allowField(true)->save($data,['id'=>$data['id']]);
				if($re){
					$info=['code'=>500,'info'=>true,'msg'=>'编辑成功'];
					return $info;
				}else{
					$info=['code'=>401,'info'=>false,'msg'=>'编辑失败'];
					return $info;
				}
			}else{
				$info['code']=400;
				$info['msg']=$validate;
				return $info;
			}
		}
		//分类
		$cateList=$this->cate();
		//品牌
		$brandList=Db::name('brand')->select();
		$this->assign('cateList',$cateList);
		$this->assign('brandList',$brandList);
		$one=Db::name('product')->where('id='.$id)->find();
		$this->assign('one',$one);
		$this->assign('title','商品编辑');
		return $this->fetch();
	}
	
	public function proDelete(){
		if(request()->isPost()){
			$data=input('post.');
//			print_r($data);die;
			if($data['dropdown']===0){
				$this->error('请先选择操作');
			}
			switch($data['dropdown']){
				case 'del':
					$idArr=$data['id'];
					$re=Db::name('product')->delete($idArr);
					if($re){
						$this->success('操作成功','Product/proList');
					}else{
						$this->error('操作失败');
					}					
					break;
			}
		}
		$id=input('id');
		$re=Db::name('product')->where("id=$id")->delete();
		if($re>0){
			$this->success('删除成功','Product/proList');die;
		}else{
			$this->error('删除失败');die;
		}
	}
	
	function findadd(){
		$tid=input('tid');
		$attr=db('attribute')
		->where(['tid'=>$tid])
		->select();
		print_r($attr);die;
		foreach($attr as $k=>$v){
			$aid=$v['id'];
			$attr[$k]['child']=db('options')->where(['aid'=>$aid])->select();
		}
	}
	
	
}
?>