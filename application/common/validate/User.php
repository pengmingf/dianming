<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
	protected $rule = [
		'name|用户名' 	=> 'require|chsAlphaNum|length:2,10',
		'studentid|学号' 	 => 'require|unique:Student|length:8',
		'phone|手机号' 		=> 'require|mobile',
		'password|密码'		=> 'require|length:6,16|confirm|alphaNum',
	];
}