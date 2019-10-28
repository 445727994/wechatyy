<?php
namespace app\index\controller;
use think\Db;

class User extends Base {
	//微信用户登录绑定

	public function index() {
		$this->webtitle('个人中心');
		$this->assign('user', $this->user);
		return $this->fetch();
	}
	public function out() {
		session('user', null);
		$this->redirect('index/index');
	}
	public function export() {
		$this->webtitle('订单导出');
		if (request()->isAjax()) {
			$time_start = strtotime(input('date_start'));
			$time_end = strtotime(input('date_end'));
			if ($time_end == "" || $time_start == "") {
				return $this->return_msg('请选择时间', 1);
			}
			if (($time_end - $time_start) > 200 * 3600 * 24) {
				return $this->return_msg('最多导出200天间隔订单', 1);
			}
			ini_set("emory_limit", "1024M");
			$model_name = "\\app\\admin\\model\\Order";
			$model = new $model_name();
			$where[] = ['user_id', '=', $this->user['id']];
			$where[] = ['create_time', 'between', $time_start . "," . $time_end];
			$order = 'create_time asc, id asc';
			$join = array();
			$field = '';
			$list = $model->export_list($where, $field, $order, $join);

			return $list;
		}
		return $this->fetch();
	}
	public function exportgoods() {
		if (request()->isAjax()) {
			$time_start = strtotime(input('date_start'));
			$time_end = strtotime(input('date_end'));
			if ($time_end == "" || $time_start == "") {
				return $this->return_msg('请选择时间', 1);
			}
			if (($time_end - $time_start) > 100 * 3600 * 24) {
				return $this->return_msg('最多导出100天间隔订单', 1);
			}
			ini_set("emory_limit", "1024M");
			$model_name = "\\app\\admin\\model\\Ordergoods";
			$model = new $model_name();
			$where[] = ['user_id', '=', $this->user['id']];
			$where[] = ['create_time', 'between', $time_start . "," . $time_end];
			$order = 'create_time asc, id asc';
			$join = array();
			$field = '';
			$list = $model->export_list($where, $field, $order, $join);

			return $list;
		}
	}
	public function about_us() {
		$this->webtitle('关于我们');
		if (empty(cache("about_us"))) {
			cache("about_us", Db::name("about")->find());
		}
		$msg = cache('about_us');
		$this->assign('msg', $msg['about']);
		return $this->fetch();
	}
	public function correct_errors() {
		return $this->fetch();
	}
	public function other() {
		$this->webtitle('其他说明');
		if (empty(cache("other"))) {
			cache("other", Db::name("other")->find());
		}
		$msg = cache('other');
		$this->assign('msg', $msg);
		return $this->fetch();
	}
	public function classsort() {
		$this->webtitle('班级排序');
		$user_msg = Db::name('information')->where('id=' . $this->user['user_id'])->find();
		if ($user_msg) {
			$where['schoolcode'] = $user_msg['schoolcode'];
			$where['departmentname'] = $user_msg['departmentname'];
			$where['class'] = $user_msg['class'];
			$class = Db::name('information')->where($where)->order('id asc')->select();
			$this->assign('class', $class);
			$this->assign('classname', $user_msg['class']);
			return $this->fetch();
		}

	}
}
