<?php
namespace app\index\model;
use think\Model;

class User extends Model{
	protected $table='tp_member';
	protected $insert=['ctime','ip'];
	protected $createTime='ctime';
	protected $autoWriteTimestamp = true;
	protected function setIpAttr(){
		return request()->ip();
	}
}

?>