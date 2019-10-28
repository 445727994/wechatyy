<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Base extends Controller {
	protected $user;
	public function __construct() {
		header("Content-type:text/html;charset=utf-8");
		parent::__construct();
		//$user = Db::name("user")->find();
		//session('user', $user);

		$this->user = session('user');

		if (empty($this->user)) {
			$this->redirect("Wechat/index");
		}
		if (empty(cache("webconfig"))) {
			cache("webconfig", DB::name("webconfig")->find());
		}
		switch (request()->action()) {
		case 'index':
			$check = 0;

			break;
		case 'order':
			$check = 1;
			break;
		case 'cart':
			$check = 2;
			break;
		default:
			$check = 3;
			break;
		}
		if (request()->controller() == 'User') {
			$check = 3;
		}
		$this->assign('check', $check);
		$this->assign('webconfig', cache("webconfig"));
	}
	protected function return_msg($key, $code = 0, $url = '', $btn = '') {
		if (request()->isAjax()) {
			return array("msg" => $key, "code" => $code);
		} else {
			$this->assign('msg', $key);
			$this->assign('btn', $btn);
			$this->assign('url', $url);
			return $this->fetch($code);
		}

	}
	protected function webtitle($name = "") {
		$title = empty($name) ? cache('webconfig')['title'] : $name;
		$this->assign("title", $title);
	}
	public function upload() {
		$img = $_POST['imgbase64'];
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)) {
			$type = "." . $result[2];
			if (!in_array($result[2], ['jpg', 'JPG', 'jpeg', 'JPEG'])) {
				exit(json_encode(['code' => 1, 'msg' => '图片只能为jpg格式图片'], true));
			}
			$path = "./upload/" . date("Y-m-d") . "/" . uniqid() . $type;
		}
		if (!is_dir("./upload/" . date("Y-m-d") . "/")) {
			$res = mkdir("./upload/" . date("Y-m-d") . "/", 0766);
		}
		$img = base64_decode(str_replace($result[1], '', $img));
		$res = @file_put_contents(strtolower($path), $img);
		if ($res) {
			exit(json_encode(['code' => 0, 'msg' => '上传成功', 'src' => trim($path, '.')], true));
		}

	}
	protected function get_where() {
		$where = array(); //查询
		$like_array = ['title', 'username', 'a.username', 'title', 'name'];
		$date_array = ['create_time_start', 'update_time_start', 'create_time_end', 'update_time_end', 'a.create_time_start', 'a.create_time_end', 'a.update_time_start', 'a.update_time_end'];
		if (!empty(input('search_data'))) {
			$search_data = input('search_data');
			foreach ($search_data as $key => $value) {
				if (!empty($value['value'])) {
					if (in_array($value['name'], $like_array)) {
						$where[] = [$value['name'], 'like', '%' . $value['value'] . '%'];
					} else if (strpos($value['name'], 'time_start')) {
						$where[] = [rtrim($value['name'], '_start'), '>', strtotime($value['value'])];
					} else if (strpos($value['name'], 'time_end')) {
						$where[] = [rtrim($value['name'], '_end'), '<', strtotime($value['value'])];
					} else if (strpos($value['name'], 'time_between')) {
						$where[] = [substr($value['name'], 0, -8), 'between', strtotime($value['value']) . ',' . (strtotime($value['value']) + 24 * 3600)];
					} else {
						$where[] = [$value['name'], '=', $value['value']];
					}
				}
			}
		}

		return $where;
	}

}
