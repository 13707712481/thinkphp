<?php
namespace app\admin\validate;
use think\Validate;
class Manager extends Validate{
	protected $rule=[
		'name' => 'require|max:18',
		'pwd' => 'require|confirm',
		'rid' => 'gt:0',
	];
}
?>