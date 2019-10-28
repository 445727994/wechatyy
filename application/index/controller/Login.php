<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Login extends Controller {
	public function __construct() {
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		if (empty(cache("webconfig"))) {
			cache("webconfig", DB::name("webconfig")->find());
		}
		switch (request()->action()) {
		case 'index':
			$check = 0;
			break;
		case 'search':
			$check = 1;
			break;
		case 'correct_errors':
			$check = 2;
			break;
		default:
			$check = 3;
			break;
		}
		$this->assign('check', $check);
		$this->assign('webconfig', cache("webconfig"));
	}
	//微信用户登录绑定
	public function index() {
		if (request()->isAjax()) {
			$this->check_csrf();
			$user = Db::name("user")->where("username", input('user'))->find();
			if (!$user) {
				return $this->return_msg('未找到用户名', 1);
			}
			if ($user['password'] != md5(input("pass") . $user['salt'])) {
				return $this->return_msg('密码错误', 1);
			}
			$user['storename'] = get_store($user['store_id']);
			session('user', $user);
			return $this->return_msg('登录成功');
		}

		if ((int) session('user')['id'] > 0) {
			$this->redirect('index/index/index');
		}
		$this->csrf_token();
		$this->webtitle('用户登录');
		return $this->fetch();
	}
	//微信用户登录绑定
	public function binding() {

	}
	protected function webtitle($name = "") {
		$title = empty($name) ? cache('webconfig')['title'] : $name;
		$this->assign("title", $title);
	}
	protected function csrf_token() {
		//表单token 验证  防止csrf
		$token_key = config("token_key");
		$microtime = microtime();
		$rand_num = rand(10, 9999999);
		$token = md5(md5($token_key) . md5($microtime) . sha1($rand_num));
		$this->assign("microtime", $microtime);
		$this->assign("rand_num", $rand_num);
		$this->assign('token', $token);
	}
	protected function check_csrf($data = "") {
		$data = empty($data) ? input() : $data;
		//验证表单
		$token_key = config("token_key");
		$token = md5(md5($token_key) . md5($data['microtime']) . sha1($data['rand_num']));
		if ($token != $data["token"]) {
			exit(json_encode($this->return_msg("csrf")));
		} else {
			return true;
		}
	}
	protected function return_msg($key, $code = 0) {
		return array("msg" => $key, "code" => $code);
	}
}
