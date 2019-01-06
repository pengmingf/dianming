<?php
namespace app\index\controller;

use app\common\controller\Base;
use app\common\model\Student;
use think\facade\Request;

class Register extends Base
{
	public function register()
	{
		return $this->fetch();
	}

	public function insert()
	{
		if(Request::isAjax())
		{
			$data = Request::post();
			$rule = 'app\common\validate\User';
			$res = $this->validate($data,$rule);
			if($res !== true){
				return ['status' => -1,'message' => $res];
			}
			else{
				if(!Student::create($data)){
					return ['status' => 0,'message' => '注册失败，请稍后重试'];
				}else{
					return ['status' => 1,'message' => '恭喜,注册成功'];
				}
			}
		}else{
			$this->error('请求类型错误','register');
		}
	}
}
