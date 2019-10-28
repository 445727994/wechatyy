<?php
/*
 * @auther 萤火虫 445727994@qq.com
 * @create_time 2019-05-22 23:33:43
 */
namespace app\admin\validate;
use think\Validate;

class User extends Validate {
	protected $rule = [
		'username' => 'unique:user',
		'mobile' => 'mobile',
	];

	protected $message = [
		'username.unique' => '用户名已存在',
		'mobile.mobile' => '手机号码格式错误',
	];
	protected $scene = [
		'add' => [],
		'edit' => [],
	];
}
