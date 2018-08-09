<?php
namespace app\admin\model;
use think\Model;
class Manager extends Model{
	//设置添加时间
	protected $createTime='ctime';
	//自动写入时间
	protected $autoWriteTimestamp = true;
}
?>