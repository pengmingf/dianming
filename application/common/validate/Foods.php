<?php
namespace app\common\validate;

use think\Validate;

class Foods extends Validate
{
	protected $rule = [
		'food_name|菜名' 	=> 'require|chsAlpha|length:1,40|unique:foods',
		'price|价格'			=> 'require|number|between:1,99999',
		'user_id|管理员' 	=> 'require',
		'type_id|类别'		=> 'require',
	];
}