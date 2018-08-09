<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Cart extends Controller
{
    public function addCart()
    {
    	$info = ['code'=>0,'info'=>false,'msg'=>''];
		//判断是否登录
		if(!session('?username')){
			$info=['code'=>400,'info'=>false,'msg'=>'请先登录'];
			return $info;
		}
		//判断购物车是否有该商品
		$data['mid']=session('userId');
		$data['pid']=input('pid');
		$num=input('num');
		$isHas=db('cart')->where($data)->find();
		if($isHas){
			//存在，改变购买数量
			$re=db('cart')->where('id='.$isHas['id'])->setInc('num',$num);
		}else{
			//不存在，添加一条购物信息
			$data['num']=$num;
			$data['ctime']=time();
			$re=db('cart')->insert($data);
		}
		if($re>0){
			$info=['code'=>500,'info'=>true,'msg'=>'已加入购物车'];
			return $info;
		}else{
			$info=['code'=>401,'info'=>false,'msg'=>'加入购物车失败'];
			return $info;
		}
    }
	
	public function cartList(){
		//导航
    	$clist=db('category')->where("fid=2")->select();
		$mid=session('userId');
		$list=db('cart')
		->alias('c')
		->field('c.*,p.name,p.thumb,p.price')
		->join('__PRODUCT__ p','c.pid=p.id','LEFT')
		->where("mid=$mid")
		->select();
		foreach($list as $k=>&$v){
			$v['thumb']=substr($v['thumb'],1);
			$v['total']=$v['price']*$v['num'];
		}
//		print_r($list);die;		
		$this->assign([
			'list'=>$list,
			'clist'=>$clist,
			'title'=>'购物车',
		]);
		return $this->fetch();
	}
	
	function onedel(){
		$id=input('id');
		$re=db('cart')->delete($id);
		if($re>0){
			return ['info'=>true];
		}
	}
	
	function alldel(){
		$allid=input();
//		print_r($allid);die;
		$re=db('cart')->delete($allid['id']);
		if($re>0){
			return ['info'=>true];
		}
	}
	//验证
	function check(){
		$data=input('post.');
//		print_r($data);die;
		$mop['mid']=session('userId');
		//初始化购物车状态
		db('cart')->where($mop)->update(['state'=>0]);
		foreach($data['data'] as $k=>$v){
			db('cart')->where(['id'=>$v[0]])->update(['num'=>$v[1],'state'=>1]);
		}
		return ['info'=>true];
	}
	
	//核对订单
	public function confirm(){
		if(request()->isAjax()){
			$data=input('post.');
			$map['mid']=session('userId');
			$re=db('address')->where($map)->update(['status'=>0]);
//			print_r($re);die;	
			$now['id']=$data['addressid'];
			db('address')->where($now)->update(['status'=>1]);
			return ['info'=>true];	
		}
		//导航
    	$clist=db('category')->where("fid=2")->select();
		$mid=session('userId');
		$whe="status=1 and $mid";
		$addlist=db('address')->where($whe)->find();
		$addlist['address']=$addlist['province'].$addlist['city'].$addlist['country'].$addlist['address'];
//		print_r($addlist);
		$list=db('cart')
		->alias('c')
		->field('c.*,p.name,p.thumb,p.price')
		->join('__PRODUCT__ p','c.pid=p.id','LEFT')
		->where("mid=$mid and state=1")
		->select();
		$num=0;
		$total=0;
		foreach($list as $k=>&$v){
			$v['thumb']=substr($v['thumb'],1);
			$v['total']=$v['price']*$v['num'];
			$num += $v['num'];
			$total += $v['total'];
		}
		$mop['mid']=$mid;
		$address=db('address')->where($mid)->select();
		$this->assign([
			'addlist'=>$addlist,
			'address'=>$address,
			'list'=>$list,
			'num'=>$num,
			'total'=>$total,
			'clist'=>$clist,
			'title'=>'订单确认',
		]);
		return $this->fetch();
	}
	
	//订单处理
	function orders(){
		$data=[];
		$data['orderid']=date('Ymd').session('userId').mt_rand(10000, 99999);
		$data['mid']=session('userId');
		$add=db('address')->where(['id'=>input('post.addressid')])->find();
		$data['linkman']=$add['linkman'];
		$data['phone']=$add['phone'];
		$data['address']=$add['province'].$add['city'].$add['country'].$add['address'];
		$data['status']=0;
		$data['state']=input('post.state');
		$data['ctime']=time();
//		print_r($data);die;
		//查询购买信息
		$product=db('cart')
		->alias('c')
		->field('c.*,p.price')
		->join('__PRODUCT__ p','c .pid=p.id','LEFT')
		->where(['mid'=>session('userId'),'state'=>1])
		->select();
//		print_r($product);die;
		$num1=count($product);
		//开启事务
		Db::startTrans();
		//添加数据到订单表
		$num2=0;
		foreach($product as $k=>$v){
			$data['pid']=$v['pid'];
			$data['num']=$v['num'];
			$data['price']=$v['num']*$v['price'];
			$num2 += db('orders')->insert($data);
		}
//		print_r($data);die;
		//删除生产订单的购物车商品
		$num3=db('cart')->where(['mid'=>session('userId'),'state'=>1])->delete();
		if($num1==$num2 && $num2==$num3){
			//提交事务
			Db::commit();
			$info=['info'=>true,'msg'=>'','orderid'=>$data['orderid']];
			return $info;
		}else{
			//回滚事务
			Db::rollback();
			$info=['info'=>false,'msg'=>'提交失败','orderid'=>''];
			return $info;
		}
	}

	function pay($orderid){
		$data['state']=input('post.state');
		$orders=db('orders')->where(['orderid'=>$orderid])->select();
		$state=$orders[0]['state'];//支付方法
//		print_r($orders);die;
		$total=0;
		foreach($orders as $k=>$v){
			$total += $v['price'];
		}
//		$total=0.01;  //上线后删除
		switch($state){
			case 1:
				//支付宝支付
					alipay($orderid,'0.01','测试','描述');
				break;
			case 2:
				//余额支付
				//导航
    			$clist=db('category')->where("fid=2")->select();
				$this->assign([
					'clist'=>$clist,
					'title'=>'支付密码',
					'orderid'=>$orderid,
					'total'=>$total,
					'orders'=>$orders
				]);
				return $this->fetch();
				break;
		}
	} 
	
	//余额支付
	function payment(){
		$orderid=input('post.orderid');
//		print_r($orderid);die;
		$orders=db('orders')->where(['orderid'=>$orderid])->select();
		$state=$orders[0]['state'];//支付方法
//		print_r($orders);die;
		$total=0;
		foreach($orders as $k=>$v){
			$total += $v['price'];
		}
		$pwd=input('post.pwd');
		$info=['info'=>false,'msg'=>''];
		//验证支付密码是否正确
		$mid=session('userId');
		$menber=db('money')->where(['mid'=>$mid])->find();
//		print_r($mid);die;/
		if($menber['pwd']==$pwd){
			//判断余额
			if($menber['cash']<$total){
				$info['code']=400;
				$info['msg']='余额不足';
				return $info;
			}
			//余额充足，开启事物
			Db::startTrans();
			//用户减去金额
			$re1=db('money')->where(['mid'=>$mid])->setDec('cash',$total);
			//商家加上金额
			$re2=db('money')->where(['mid'=>0])->setInc('cash',$total);
			//修改支付状态
			$re3=db('orders')->where(['orderid'=>$orderid])->update(['status'=>1]);

			if($re1 && $re2 && $re3 ){
				//提交事物
				Db::commit();
				$info=['info'=>true,'msg'=>'支付成功'];
				return $info;
			}else{
				//回滚事物
				Db::rollback();
				$info=['info'=>false,'msg'=>'支付失败'];
				return $info;
			}
			
		}else{
			$info['msg']='支付密码错误';
			return $info;
		}
	}
	
	function return_url(){
		return_url();
	}
	
	function notify_url(){
		notify_url();
	}
	
}
