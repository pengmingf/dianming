<?php
namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\User;
use app\common\model\Student;
use think\facade\Request;
use think\facade\Session;
use app\common\model\Foods;
use app\common\model\FoodType;


class Index extends Base
{
    public function index()
    {
        //$this->showType();
        $this->noLogin();
        return $this->fetch();
    }

    public function login()
    {
        $this->isLogin();
    	return $this->fetch();
    }

    public function checkLogin()
    {
        if(Request::isAjax())
        {
            $data = Request::post();
            $rule = [
                'studentid|学号' => 'require|length:8',
                'password|密码' => 'require|alphaNum|length:6,16'
            ];
            $res = $this->validate($data,$rule);
            if($res !== true)
            {
                return ['status' => -1,'message' => $res];
            }
            else
            {
                $result = Student::get(
                    function($query) use ($data){
                    $query->where('studentid',$data['studentid'])
                          ->where('password',md5($data['password']));
                }
                );
                if($result == null)
                {
                    return ['status' => 0,'message' => '登录失败，学号或者密码错误'];
                }
                else
                {
                    Session::set('user_id', $result->Id);
                    Session::set('user_name', $result->name);
                    return ['status' => 1,'message' => '登录成功'];
                }
            }
        }
        else{
            $this->error('请求类型错误','login');
        }
    }

    public function outLogin()
    {
        Session::clear();
        $this->success('注销成功','login');
    }

    public function newFood()
    {
        $this->noLogin();
        $data = FoodType::all();
        if(count($data) > 0)
        {
            $this->assign('data',$data);
        }
        return $this->fetch();
    }

    public function saveFood()
    {
        if(Request::isPost())
        {
            $data = Request::post();
            $rule = 'app\common\validate\Foods';
            $res = $this->validate($data,$rule);
            if($res !== true)
            {
                echo '<script>alert("'.$res.'")</script>';
            }
            else
            {
                $file = Request::file('img');
                $into = $file->validate(['size'=>5000000000,'ext'=>'jpeg,jpg,png,gif'])
                            ->move('uploads/');
                if($into)
                {
                    $data['img'] = $into->getSaveName();
                }
                else
                {
                    $this->error($file->getError(),'index/index/newFood');
                }
                if(Foods::create($data))
                {
                    $this->success('恭喜你添加成功','index');
                }
                else{
                    $this->error('添加失败');
                }
            }
        }else{
            $this->error('对不起，请求类型错误');
        }
    }

    public function newType()
    {
        //只是为了折叠写的注释
        return $this->fetch();
    }

    public function saveType()
    {
        if(Request::isPost())
        {
            $data = Request::post();
            $res = $this->validate($data,['name|类名' => 'require|chs|length:0,40|unique:food_type',
                                    'sort|优先度' => 'require','user_id|用户主键' => 'require']);
            if($res !== true)
            {
                echo '<script>alert("'.$res.'")</script>';
                echo '<script>window.location.href = "newType"</script>';
            }else{
                if(FoodType::create($data))
                {
                    $this->success('恭喜，新增成功','index/index');
                }else{
                    $this->error('对不起，新增失败');
                }
            }
        }else{
            $this->error('请求类型错误，请重试');
        }
    }
}
