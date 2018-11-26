<?php
namespace app\index\controller;
 
use think\Controller;

class Register extends Controller
{
    public function index()
    {
    	return $this->fetch();
    }
  	//跳转到注册页面
	public function doRegister(){
      	$param = input('post.');
    	if(empty($param['user_name'])){
    		
    		$this->error('用户名不能为空');
    	}
    	
    	if(empty($param['user_pwd'])){
    		
    		$this->error('密码不能为空');
    	}
      	// 验证用户名
    	$has = db('users')->where('user_name', $param['user_name'])->find();
    	if(!empty($has)){
    		
    		$this->error('该用户名已被注册');
    	}
      	$data=[
            'user_name'=>$param['user_name'],
            'user_pwd'=>md5($param['user_pwd'])
        ];
      	db("users")->insert($data);
      	$this->redirect(url('login/index'));
    	
    }
}
