<?php
namespace app\admin\controller;
use think\Controller;

/*
Auther :  萤火虫
email  : 445727994@qq.com
 */
class Admin extends Base {
	protected $user_id;
	protected $Lang;
	public function __construct() {
		parent::__construct();
	}
	public function _initialize() {

	}
	public function _befor_update(&$data) {
		$data['salt'] = md5(uniqid(microtime(true), true));
		$data['password'] = md5(md5($data['password']) . sha1($data['salt']));
	}
	public function _befor_insert(&$data) {
		$data['salt'] = md5(uniqid(microtime(true), true));
		$data['password'] = md5(md5($data['password']) . sha1($data['salt']));
	}
}
