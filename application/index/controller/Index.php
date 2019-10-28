<?php
namespace app\index\controller;
use app\admin\model\Order;
use app\admin\model\Ordergoods;
use think\Db;

class Index extends Base {

	public function index() {
		if (request()->isAjax()) {
			$page = (int) input('page') ? (int) input('page') : 1;
			$page_size = (int) input('limit') ? (int) input('limit') : 10;
			$m_name = 'Goods';
			$model_name = "\\app\\admin\\model\\" . $m_name;
			$model = new $model_name();
			$name = input("name");
			$where = [];
			if (!empty($name)) {
				$where[] = ['a.goodsname', 'like', '%' . $name . '%'];
			} else {
				$cate2 = input('cate2');
				$cate1 = input('cate1');
				if (!empty($cate1)) {
					$where[] = ['a.cate_id1', '=', input('cate1')];
				}
				if (!empty($cate2)) {
					$where[] = ['a.cate_id2', '=', input('cate2')];
				}

			}

			$order = '';
			if (!empty(input('field')) && !empty(input("order"))) {
				$order = input("field") . " " . input('order');
			}
			$join = array();
			$join[] = ['img i', 'a.goods_img=i.id'];
			$join[] = ['unit u', 'a.unit_id=u.id'];
			$field = 'a.*,i.url as goods_img,u.name as unit_id';
			$list = $model->get_list($where, $field, $order, $page, $page_size, $join);
			return $list;
		}
		$cate = DB::name("cate")->where('pid=0')->order("id asc")->select();
		$id = Db::name("cate")->where('pid=0')->order("id asc")->value('id');
		$this->assign("cate", $cate);
		$this->assign("cate1", DB::name("cate")->where('pid=' . $id)->order("id asc")->select());
		$this->webtitle('商品列表');
		return $this->fetch();
	}
	public function get_cate() {
		$id = input('id');
		if (empty($id)) {
			$id = Db::name("cate")->where('pid=0 and is_delete=0')->order("id desc")->value('id');
		}
		$list = Db::name("cate")->where(['pid' => $id])->select();
		return array("code" => 0, "msg" => "suc", "data" => $list);
	}
	public function add_cart() {
		if (request()->isAjax()) {
			$data = input();
			if (isset($data['id'])) {
				$isset = Db::name('cart')->where("goods_id", $data['id'])->where('user_id', $this->user['id'])->where("status=0")->find();
				if ($isset) {
					$res = Db::name('cart')->where("goods_id", $data['id'])->where('user_id', $this->user['id'])->where("status=0")->setInc('num', $data['num']);
				} else {
					$insert_data['user_id'] = $this->user['id'];
					$insert_data['goods_id'] = $data['id'];
					$insert_data['num'] = $data['num'];
					$insert_data['status'] = '0';
					$res = Db::name('cart')->insert($insert_data);
				}
				$res = $res == true ? "添加成功" : "添加失败";
				return $this->return_msg($res);

			}
		}
	}
	public function cart() {
		$where[] = ['c.status', '=', '0'];
		$where[] = ['c.user_id', '=', $this->user['id']];
		$field = 'c.*,g.goodsname,g.goods_img,g.price,u.name';
		$goods = Db::name('cart c')->leftjoin('goods g', 'c.goods_id=g.id')->leftjoin('unit u', 'u.id=g.unit_id')->where($where)->field($field)->select();
		$this->assign('goods', $goods);
		$this->webtitle('购物车');
		return $this->fetch();
	}
	public function del_cart() {
		if (request()->isAjax()) {
			$data = input();
			if (isset($data['id'])) {
				$where[] = ['status', '=', '0'];
				$where[] = ['id', '=', $data['id']];
				$res = Db::name('cart')->where($where)->delete();
				$res = $res == true ? "删除成功" : "删除失败";
				return $this->return_msg($res);
			}
		}
	}
	public function change_cart() {
		if (request()->isAjax()) {
			$data = input();
			if (isset($data['id'])) {
				$where[] = ['status', '=', '0'];
				$where[] = ['id', '=', $data['id']];
				$res = Db::name('cart')->where($where)->update(['num' => $data['num']]);
				$res = $res == true ? "删除成功" : "删除失败";
				return $this->return_msg($res);
			}
		}
	}
	public function get_cart() {
		if (request()->isAjax()) {
			$order_no = date("YmdHis") . $this->user['id'] . mt_rand('1000', '9999');
			$where[] = ['c.status', '=', '0'];
			$where[] = ['c.user_id', '=', $this->user['id']];
			$field = 'c.*,g.goodsname as goodsname,g.price as price,u.name as unit,ca.name as cate1,ca1.name as cate2';
			$goods = Db::name('cart c')->leftjoin('goods g', 'c.goods_id=g.id')->leftjoin('cate ca', 'ca.id=g.cate_id1')->leftjoin('cate ca1', 'ca1.id=g.cate_id2')->leftjoin('unit u', 'u.id=g.unit_id')
				->where($where)->field($field)->select();
			if (!$goods) {
				return $this->return_msg('购物车为空，不存在商品', 1);
			}
			$c_money = 0;
			$time = time();
			foreach ($goods as $key => $value) {
				unset($goods[$key]['id']);
				$goods[$key]['money'] = $value['price'] * $value['num'];
				$goods[$key]['order_no'] = $order_no;
				$goods[$key]['username'] = $this->user['username'];
				$goods[$key]['store_id'] = $this->user['store_id'];
				$goods[$key]['user_id'] = $this->user['id'];
				$goods[$key]['storename'] = $this->user['storename'];
				$goods[$key]['cate1'] = $value['cate1'];
				$goods[$key]['cate2'] = $value['cate2'];
				$goods[$key]['create_time'] = $time;
				$goods[$key]['update_time'] = $time;
				$goods[$key]['status'] = 1;
				$c_money += $goods[$key]['money'];
			}
			$order = ['order_no' => $order_no, 'user_id' => $this->user['id'], 'store_id' => $this->user['store_id'], 'username' => $this->user['username'],
				'storename' => $this->user['storename'], 'money' => $c_money, 'status' => 1];
			$O = new Order();
			$Og = new Ordergoods();
			if ($O->allowfield(true)->isUpdate(false)->_save($order)) {
				$Og->allowfield(true)->isUpdate(false)->saveAll($goods);
				$wheres[] = ['status', '=', '0'];
				$wheres[] = ['user_id', '=', $this->user['id']];
				Db::name('cart')->where($wheres)->delete();
				return $this->return_msg('购入成功');
			}
		}
	}
	public function order() {
		$this->webtitle('我的订单');
		$status = input('status');
		if (request()->isAjax()) {
			if (input('status') != "0") {
				$where[] = ['status', '=', input('status')];
			}
			$where[] = ['user_id', '=', $this->user['id']];
			$page = (int) input('page') ? (int) input('page') : 1;
			$page_size = (int) input('limit') ? (int) input('limit') : 10;
			$m_name = 'Order';
			$model_name = "\\app\\admin\\model\\" . $m_name;
			$model = new $model_name();
			$order = 'id desc';
			$list = $model->get_list($where, '*', $order, $page, $page_size);
			return $list;
		}
		$this->assign("status", $status);
		return $this->fetch();
	}
	public function ordercancel() {
		if (request()->isAjax()) {
			$data = input();
			if (isset($data['id'])) {
				$where[] = ['status', '=', '1'];
				$where[] = ['id', '=', $data['id']];
				$res = Db::name('order')->where($where)->delete();
				$res = $res == true ? "取消成功" : "取消失败";
				if ($res) {
					Db::name('ordergoods')->where('order_no', $data['order_no'])->delete();
				}
				return $this->return_msg($res);
			}
		}
	}
	public function orderdetail() {
		$order_no = input("order_no");
		$goods = Db::name('ordergoods')->where('user_id', $this->user['id'])->where('order_no', $order_no)->select();
		$this->assign('goods', $goods);
		$this->assign('c_money', Db::name('order')->where('user_id', $this->user['id'])->where('order_no', $order_no)->value("money"));
		$this->webtitle('订单详情');
		return $this->fetch();
	}
	public function confirmorder() {
		if (request()->isAjax()) {
			$data = input();
			if (isset($data['id'])) {
				$where[] = ['user_id', '=', $this->user['id']];
				$where[] = ['id', '=', $data['id']];
				$res = Db::name('order')->where($where)->update(['status' => 3]);
				$res = $res == true ? "确认成功" : "确认失败";
				return $this->return_msg($res);
			}
		}
	}
	public function text() {
		return $this->fetch();
	}
}
