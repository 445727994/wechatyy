<?php
/*
 * @auther 萤火虫 
 * @email  445727994@qq.com
 * @create_time 2019-10-22 22:50:03
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
class UserCase extends Base{
	public function __construct() {
		parent::__construct();
	}
	public function _initialize() {

	}
    public function _befor_index(){

    }
    public function _end_search(&$list) {
        if (count($list['data']) > 0) {
            foreach ($list['data'] as $key => $value) {
                $list['data'][$key]['img'] = img($value['img']);
                $list['data'][$key]['cate'] = caseCate($value['cate_id']);
            }
        }
    }

}
