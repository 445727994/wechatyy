<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Cache;
use think\Db;
// 应用公共文件
function img($id) {
    if(empty($id)){
        return '';
    }
    return "/upload/" . Db::name('img')->where('id=' . $id)->cache('img_'.$id,'600')->value('url');
}
function caseCate($id) {
    return Db::name('cate')->where(['id'=> $id])->cache('cate_'.$id,'600')->value('name');
}
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
	// 创建Tree
	$tree = array();
	if (is_array($list)) {
		// 创建基于主键的数组引用
		$refer = array();
		foreach ($list as $key => $data) {
			$refer[$data[$pk]] = &$list[$key];
		}
		foreach ($list as $key => $data) {
			// 判断是否存在parent
			$parentId = $data[$pid];
			if (is_string($parentId)) {
				$root = (string) $root;
			}

			if ($root == $parentId) {
				$tree[] = &$list[$key];
			} else {
				if (isset($refer[$parentId])) {
					$parent = &$refer[$parentId];
					$parent[$child][] = &$list[$key];
				}
			}
		}
	}

	return $tree;
}

function select_option($table, $status = 0, $name = '请选择') {
	$data = json_decode(base64_decode($table), true);
	$options = Db::name($data['table'])->where($data['where'])->order($data['order'])->field($data['field1'] . "," . $data['field2'])->select();
	$name = isset($data['name']) ? $data['name'] : $name;
	$option = '<option value="">' . $name . '</option>';
	foreach ($options as $key => $value) {
		if ($status == $value[$data['field1']]) {
			$option .= '<option value="' . $value[$data['field1']] . '" selected>' . $value[$data['field2']] . '</option>';
		} else {
			$option .= '<option value="' . $value[$data['field1']] . '"  >' . $value[$data['field2']] . '</option>';
		}
	}
	return $option;
}
function goods_cate($selected = '') {
	$options = Db::name('cate')->where('pid=0 and is_delete=0')->order('id desc')->field('id,name')->select();
	$name = '请选择一级分类';
	$option = '<option value="">' . $name . '</option>';
	foreach ($options as $key => $value) {
		if ($selected == $value['id']) {
			$option .= '<option value="' . $value['id'] . '" selected>' . $value['name'] . '</option>';
		} else {
			$option .= '<option value="' . $value['id'] . '"  >' . $value['name'] . '</option>';
		}
	}
	return $option;
}
function goods_cate2($cate1 = '', $cate2 = '') {
	$name = '请选择二级分类';
	if ($cate1 == '') {
		return $option = '<option value="">' . $name . '</option>';
	}
	$options = Db::name('cate')->where('pid=' . $cate1)->order('id desc')->field('id,name')->select();

	$option = '<option value="">' . $name . '</option>';
	foreach ($options as $key => $value) {
		if ($cate2 == $value['id']) {
			$option .= '<option value="' . $value['id'] . '" selected>' . $value['name'] . '</option>';
		} else {
			$option .= '<option value="' . $value['id'] . '"  >' . $value['name'] . '</option>';
		}
	}
	return $option;
}

function get_status($s) {
	switch ($s) {

	case '1':
		return "已下单";
		break;
	case '2':
		return "已发货";
		break;
	case '3':
		return "已确认";
		break;
	default:
		return '';
		break;
	}
}

function search_type($key, $value) {
	$array_eq = ['id'];
	$array_like = ['keywords', 'name', 'title'];
	if (in_array($key, $array_eq)) {
		return array("=", $value);
	}
	if (in_array($key, $array_like)) {
		return array("like", "%" . $value . "%");
	}
	;
	if (strpos($key, '|')) {
		return array("like", "%" . $value . "%");
	}
	;
	return array("like", "%" . $value . "%");
}
function get_select($sa, $k) {
	$html = '<div class="layui-input-inline">';
	switch ($sa['type']) {
	case 'select':
		$html .= '<select name="' . $k . '" style="width:' . $sa['width'] . 'px">';
		$option = "";
		foreach ($sa['value'] as $key => $value) {
			$option .= '<option value="' . $key . '">' . $value . '</option>';
		}
		$html .= $option . '<select>';
		break;
	case 'select_table':
		$array = Db::name($sa['value'])->field($sa['list_key'] . ',' . $sa['list_value'])->where($sa['where'])->group($sa['group'])->order('id desc')->select();
		$html .= '<select lay-filter="cate1" name="' . $k . '" style="width:' . $sa['width'] . 'px">';
		$option = "";
		$option = "<option value=''>请选择" . $sa['name'] . "</option>";
		foreach ($array as $key => $value) {
			$option .= '<option value="' . $value[$sa['list_key']] . '">' . $value[$sa['list_value']] . '</option>';
		}
		$html .= $option . '<select>';
        $htmls = '';
        if ($sa['value'] == 'cate' && isset($sa['deep'])) {
			$htmls = '<select lay-filter="cate_id2" id="cate_id2" name="cate_id2" style="width:' . $sa['width'] . 'px">';
			$option = "";
			$option = "<option value=''>请选择二级分类</option>";
			$htmls .= $option . '<select></div>';
		}
        $html.=$htmls;
		break;
	case 'input':
		$html .= '<input class="layui-input" name="' . $k . '" value="' . input($sa['name']) . '"  placeholder="' . $sa['name'] . '" style="width:' . $sa['width'] . 'px" autocomplete="off">';
		break;
	case 'date':
		$id = 'date' . mt_rand(10000, 99999);
		if (isset($sa['num'])) {
			$html .= '<input class="layui-input" name="' . $k . '_start" id="' . $id . '" value="' . input($sa['name'])
				. '"  placeholder="' . $sa['name'] . '"  autocomplete="off"><script>layui.use("laydate", function(){var laydate = layui.laydate;laydate.render({elem: "#' . $id . '"})});</script>';
			$html .= '<input class="layui-input" name="' . $k . '_end" id="' . $id . '1" value="' . input($sa['name']) . '"  placeholder="'
			. str_replace("开始时间", "结束时间", $sa['name']) . '"  autocomplete="off">
			<script>layui.use("laydate", function(){var laydate = layui.laydate;laydate.render({elem: "#' . $id . '1"})});</script>';
		} else {
			$html .= '<input class="layui-input" name="' . $k . '_between" id="' . $id . '" value="' . input($sa['name']) . '"  placeholder="' . $sa['name'] . '"  autocomplete="off">
			<script>layui.use("laydate", function(){var laydate = layui.laydate;laydate.render({elem: "#' . $id . '"})});</script>';
		}

		break;
	default:
		$option = "";
		break;
	}

	echo $html."</div>";
}
function genTree($items, $id = 'id', $pid = 'pid', $son = 'children') {
	$tree = array(); //格式化的树
	$tmpMap = array(); //临时扁平数据
	foreach ($items as $item) {
		$item['url'] = '';
		if (!empty($item['action'])) {
			$str = $item['module'] . '/' . $item["controller"] . '/' . $item["action"];
			$item['url'] = url($str) . "?" . $item['param'];
		}
		$tmpMap[$item[$id]] = $item;
	}
	foreach ($items as $item) {
		if (isset($tmpMap[$item[$pid]])) {
			$tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
		} else {
			$tree[] = &$tmpMap[$item[$id]];
		}
	}
	unset($tmpMap);
	return $tree;
}
function delete_dir_file($dir_name) {
	$result = false;
	if (is_dir($dir_name)) {
		//检查指定的文件是否是一个目录
		if ($handle = opendir($dir_name)) {
			//打开目录读取内容
			while (false !== ($item = readdir($handle))) {
				//读取内容
				if ($item != '.' && $item != '..') {
					if (is_dir($dir_name . DS . $item)) {
						delete_dir_file($dir_name . DS . $item);
					} else {
						unlink($dir_name . DS . $item); //删除文件
					}
				}
			}
			closedir($handle); //打开一个目录，读取它的内容，然后关闭
			if (rmdir($dir_name)) {
				//删除空白目录
				$result = true;
			}
		}
	}
	return $result;
}
function get_editor($name, $type = 'ue', $content = "") {
    $html = '';
    switch ($type) {
        case 'ue':
            $html .= '<script type="text/javascript" charset="utf-8" src="/editor/ue/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="/editor/ue/ueditor.all.min.js"> </script>
		<script type="text/javascript" charset="utf-8" src="/editor/ue/lang/zh-cn/zh-cn.js"></script>
		<script id="ue_editor" type="text/plain" style="width:1024px;height:500px;">' . $content . '</script>
		<script type="text/javascript">var ue_editor = UE.getEditor("ue_editor");</script>';
            break;
        default:

            break;
    }
    return $html;
}