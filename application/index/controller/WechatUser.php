<?php

namespace app\index\controller;

use mikkle\tp_wechat\Wechat;
use think\Controller;
use think\Db;

class WechatUser extends Controller
{
    public function __construct()
    {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
        if (empty(cache("webconfig"))) {
            cache("webconfig", DB::name("webconfig")->find());
        }
        switch (request()->action()) {
            case 'index':
                $check = 0;
                break;
            case 'case':
                $check = 1;
                break;
            case 'order':
                $check = 2;
                break;
            case 'user':
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
    public function index()
    {
        if (input('code')) {
            $data = Wechat::Oauth()->getOauthAccessToken();
            $openid = $data['openid'];
            $access_token = $data['access_token'];
            $userinfo = Wechat::Oauth()->getOauthUserInfo($access_token, $openid);
            $data = ['openid' => $userinfo['openid'], 'wx_user' => $userinfo['nickname'], 'head_img' => $userinfo['headimgurl']];
            $is_user = Db::name("user")->where(['openid' => $userinfo['openid']])->find();
            if (!$is_user) {
                Db::name("user")->insert($data);
                session('user', Db::name("user")->where(['openid' => $userinfo['openid']])->find());
            } else {
                Db::name("user")->where(['openid' => $userinfo['openid']])->update(['wx_user' => $userinfo['nickname'], 'head_img' => $userinfo['headimgurl']]);
                session('user', $is_user);
            }
            $this->redirect('binding');
        } else {
            $return = $domain = request()->domain() . url('index');
            $url = Wechat::Oauth()->getOauthRedirect($return, '1');
            header('location:' . $url);
        }
    }

    //微信用户登录绑定
    public function binding()
    {
        if (request()->isAjax()) {
            $this->check_csrf();
            $user = Db::name("information")->where("usercard", input('usercard'))->find();
            Db::name("user")->where(['openid' => session('user')['openid']])->update(['mobile' => $user['mobile']]);
            //更新session
            $user = Db::name("user")->where(['openid' => session('user')['openid']])->find();
            session('user', $user);
            return $this->return_msg('手机绑定成功');
        }
        $this->csrf_token();
        $this->webtitle('绑定手机');
        return $this->fetch();
    }
    //缴费回调
    public function notify()
    {
        $return = file_get_contents('php://input');
        if (!$return) {
            file_put_contents('./log/NO' . date('Ymd') . '.txt', json_encode($return) . PHP_EOL, FILE_APPEND);
            exit;
        }
        $xml = $return;
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);//转换xml数据为数组
        file_put_contents('./log/text' . date('Ymd') . '.txt', json_encode($return) . PHP_EOL, FILE_APPEND);
        $update['transaction_id'] = $array_data['transaction_id'];//微信支付单号，用户对账
        $order = $array_data['out_trade_no'];//网站订单号
        $update['status'] = 1;
        $info = Db::name('orders')->where('oid', $order)->update($update);
        $msg = Db::name('orders')->where('oid', $order)->value('openid');
        $picerror = Db::name('picerror')->where('openid', $msg)->find();
        if ($picerror['status'] == 4) {
            $updates_arr['status'] = 1;
            Db::name('picerror')->where('openid', $msg)->update($updates_arr);
        }

    }

    protected function webtitle($name = "")
    {
        $title = empty($name) ? cache('webconfig')['title'] : $name;
        $this->assign("title", $title);
    }

    protected function csrf_token()
    {
        //表单token 验证  防止csrf
        $token_key = config("token_key");
        $microtime = microtime();
        $rand_num = rand(10, 9999999);
        $token = md5(md5($token_key) . md5($microtime) . sha1($rand_num));
        $this->assign("microtime", $microtime);
        $this->assign("rand_num", $rand_num);
        $this->assign('token', $token);
    }

    protected function check_csrf($data = "")
    {
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

    protected function return_msg($key, $code = 0)
    {
        return array("msg" => $key, "code" => $code);
    }
}
