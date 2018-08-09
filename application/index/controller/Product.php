<?php
namespace app\index\controller;
use think\Controller;

class Product extends Controller
{
    public function proList()
    {
    	//导航
    	$clist=db('category')->where("fid=2")->select();
//		print_r($clist);die;
		
		//子分类
		$id=input('id');
		$cone=db('category')->where('id='.$id)->find();
		$childlist=db('category')->where('fid='.$id)->select();
//		print_r($cone);die;
		//品牌
		$blist=db('brand')->select();
//		print_r($blist);die;

		//商品
		//查询条件
		if(input('bid')) $map['bid']=['eq',input('bid')];
		if(!input('cid')){
		$childid=$this->childId($id);
//		print_r($childid);die;
		$map['cid']=['in',$childid];
		}else{
			$map['cid']=['eq',input('cid')];
		}
		
		//排序
		if(input('order')=='price'){
			$order='price desc';
		}else if(input('order')=='xiaoliang'){
			$order='xiaoliang desc';
		}else if(input('order')=='msg'){
			$order='msg desc';
		}else{
			$order='id desc';
		}
		
		$plist=db('product')->where($map)->order($order)->paginate(16);
//		print_r($plist);die;
		
		$this->assign([
			'cone'=>$cone,
			'blist'=>$blist,
			'childlist'=>$childlist,
			'clist'=>$clist,
			'plist'=>$plist,
			'cid'=>input('cid'),
			'title'=>'商品列表',
		]);
		
        return $this->fetch();
    }
	
	function childId($id=0,$list=[],$spec=0){
		if($spec==0) $list[]=$id;
		$fid=$id;
		$plist=db('category')->where("fid=$fid")->select();
		foreach($plist as $k=>$v){
			$list[]=$v['id'];
			$list=$this->childId($v['id'],$list,$spec+1);
		}
		return $list;
	}
	
	public function pro_details(){
		$id=input('id');
		$product=db('product')->where('id='.$id)->find();
		$product['picture']=explode(',', $product['picture']);
//		print_r($product);die;
		
		//导航
    	$clist=db('category')->where("fid=2")->select();
//		print_r($clist);die;
		
		$this->assign([
			'product'=>$product,
			'clist'=>$clist,
			'title'=>'商品详情',
		]);
		return $this->fetch();
	}
	
	public function search(){
		$keyword=input('keyword');
		$map['name']=['like','%'.$keyword.'%'];
		$plist=db('product')->where($map)->paginate(2);
		$clist=db('category')->where("fid=2")->select();
		$this->assign([
			'clist'=>$clist,
			'title'=>'搜索商品',
			'plist'=>$plist,
		]);
		return $this->fetch();
	}


}
