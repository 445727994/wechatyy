<?php
namespace app\admin\controller;
use app\admin\model\Admin;
use think\Controller;
use think\Db;

/*
Auther :  萤火虫
email  : 445727994@qq.com
 */
class Login extends Controller {
	public function __construct() {
		parent::__construct();
		if (empty(cache("webconfig"))) {
			cache("webconfig", DB::name("webconfig")->find());
		}
		if (empty(cache("lang"))) {
			cache("lang", (include EXTEND_PATH . "/lang/" . request()->module() . "/base.php"));
		}
		$this->Lang = Cache("lang");
		$this->assign('web', cache('webconfig'));
	}
	public function index() {
		if (request()->isAjax()) {
			$data = input('post.');
			$this->check_csrf($data);
			$res = $this->validate($data, "Login");
			if (true !== $res) {
				return $this->return_msg($res, 1);
			}
			$Admin = new Admin();
			$user = $Admin->where(["username" => $data['username']])->find();
			if (!$user) {
				return $this->return_msg('not_exist', 1);
			}
			$check_pass = md5(md5($data['password']) . sha1($user['salt']));
			if ($check_pass != $user['password']) {
				return $this->return_msg('password_error', 1);
			}
			session("user_info", $user);
			return $this->return_msg("success");
		}
		$this->csrf_token();
		return $this->fetch();
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
	protected function check_csrf($data) {
		//验证表单
		$token_key = config("token_key");
		$token = md5(md5($token_key) . md5($data['microtime']) . sha1($data['rand_num']));
		if ($token != $data["token"]) {
			exit(json_encode($this->return_msg("csrf")));
		} else {
			return true;
		}
	}
	protected function return_msg($key, $code = 0, $type = "") {
		if (isset($this->Lang['return_msg'][$key])) {
			return $this->Lang['return_msg'][$key];
		} else {
			return array("msg" => $type, "code" => $code);
		}
	}
}
