<?php
namespace app\admin\model;
use think\Model;
class Goods extends Model{
	protected $table = 'tp_product';
	//设置添加时间和更新时间
	protected $createTime='ctime';
	protected $updateTime='utime';
	//自动写入时间
	protected $autoWriteTimestamp = true;
}	
?>