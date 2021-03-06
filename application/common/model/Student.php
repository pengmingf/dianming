<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2018/12/5
 * Time: 22:08
 */



namespace app\common\model;

use think\Model;

class Student extends Model
{
    protected $pk = 'Id';

    protected $autoWriteTimestamp = true;

    protected $create_time = 'create_time';
    protected $update_time = 'update_time';

    public function getStatusAttr($value)
    {
        $status = ['1' => '正常','2' => '禁用'];
        return $status[$value];
    }

    /*public function getIsAdminAttr($value)
    {
        $is_admin = ['1' => '用户','0' => '管理员'];

        return $is_admin[$value];
    }*/

    public function setPasswordAttr($value)
    {
        return md5($value);
    }
}