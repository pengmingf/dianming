<?php
namespace app\common\controller;

use think\Controller;
use think\facade\Session;
use think\facade\Request;
use app\common\model\Foods;
use app\common\model\FoodType;
/**
 * Base基类
 */
class Base extends Controller
{
	// 实现Controller父类的初始化方法
    protected function initialize()
    {

    }

    public function isLogin()
    {
    	if(Session::has('user_id'))
    	{
    		$this->error('对不起，您已登录');
    	}
    }

    public function noLogin()
    {
        if(!Session::has('user_id'))
        {
            $this->error('对不起，请先登录','login');
        }
    }

    /*public function showType()
    {
        $data = FoodType::all(function($query){
            $query -> where('status',1) ->order('sort','desc');
        });
        $this->assign('data',$data);
        return $this->fetch('index');
    }
    
    public function showFood()
    {
        $data = Food::all(function($query){
            $query ->where('status',1) ->ord('sort','desc');
        });
        $this->assign('data',$data);
        return $this->fetch('index');
    }*/
}