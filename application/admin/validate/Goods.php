<?php
/*
 * @auther 萤火虫 445727994@qq.com
 * @create_time 2019-05-27 23:43:36
 */
namespace app\admin\validate;
use think\Validate;

class Goods extends Validate {
	protected $rule = [
		'goodsname' => 'unique:goods',

	];

	protected $message = [
		'goodsname.unique' => '商品名已存在',

	];
	protected $scene = [
		'add' => [],
		'edit' => [],
	];
}
