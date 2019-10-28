<?php
/*
 * @auther 萤火虫 
 * @email  445727994@qq.com
 * @create_time 2019-10-22 22:42:25
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Form extends Base{
	public function __construct() {
		parent::__construct();
	}
	public function _initialize() {

	}
    public function _befor_insert(&$data){
	    if(!empty($data['content'])){
	        foreach ($data['content']['field'] as $k=>$v){
	            if(empty($v)){
	                unset($data['content']['field'][$k],$data['content']['length'][$k],$data['content']['require'][$k]);
                }else{
                    $data['content']['require'][$k]=$data['content']['require'][$k]??0;
                }
            }
            $data['content']=json_encode($data['content'],true);
        }
    }
    public  function  _befor_edit(&$data){
        $data['content']=json_decode($data['content'],true);
    }
    public  function  _befor_update(&$data){
        if(!empty($data['content'])){
            foreach ($data['content']['field'] as $k=>$v){
                if(empty($v)){
                    unset($data['content']['field'][$k],$data['content']['length'][$k],$data['content']['require'][$k]);
                }else{
                    $data['content']['require'][$k]=$data['content']['require'][$k]??0;
                }
            }
        }
        $data['content']=json_encode($data['content'],true);
    }
}
