<?php
namespace app\qasystem\controller;
 
use think\Controller;
 
class Test extends Controller
{
    public function index()
    {
     	$array['name'] = '苏东航';
        $array['email'] = 'liu21st@gmail.com';
        $array['phone'] = '12335678';
        $this->assign($array);
    	return $this->fetch();
    }
        // 用户提交问题
    public function putQuestion()
    {
    	$param = input('post.');
    	if(empty($param['projectType'])){
    		
    		$this->error('分类不能为空');
    	}
    	
    	if(empty($param['projectId'])){
    		
    		$this->error('项目不能为空');
    	}
      
      	if(empty($param['question'])){
          
        	$this->error('问题描述不能为空');
          
    	}
    	
		$data=[
            'categoryFath'=>$param['projectType'],
            'categorySon'=>$param['projectId'],
            'content'=>$param['question'],
            'student_id'=>1
        ];
      	db("questions")->insert($data);
      	
    	
    	// 记录用户登录信息
    	cookie('user_id', $has['id'], 3600);  // 一个小时有效期
    	cookie('user_name', $has['user_name'], 3600);
    	
    	$this->redirect(url('feedback/index'));
    }
  // 退出登陆
  public function loginOut()
  {
    cookie('user_id', null);
    cookie('user_name', null);
    
    $this->redirect(url('login/index'));
    
  }
}