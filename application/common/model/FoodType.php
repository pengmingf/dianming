<?php
namespace app\common\model;

use think\Model;

class FoodType extends Model
{
	protected $pk = 'id';

	protected $autoWriteTimestamp = true;

	protected $create_time = 'create_time';
	protected $update_time = 'update_time';

	public function getStatusAttr($value)
	{
		$status = ['1' => '正常','0' => '禁用'];
		return $status[$value];
	}
}