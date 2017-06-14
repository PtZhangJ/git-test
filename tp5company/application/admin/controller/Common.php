<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
class Common extends Controller
{
    public function _initialize()
    {
        if(!session('id'))
		{
			 $this->error('请登录','Login/index','',2);
		}
		  //验证管理员权限
		  $auth = new Auth();
		  //  $auth->check(当前控制器个当前方法名,用户ID）
		  $request = Request::instance();
		  $con = $request->controller();
		  $action = $request->action();
		  $name = $con.'/'.$action;
		  // var_dump($name);
		   $notCheck=array('Index/index','Admin/logout','Admin/lst');
		  if(session('id')!=20)//id=20的是初始管理员，初始管理员不需要验证
		  {
		  	if(!in_array($name,$notCheck))
		  	{
		  		  if(!$auth->check($name,session('id')))
		  	
				  {
					$this->error('您没有权限','Index/index','',1);
				  }
			}
		  }
		
		
    }
  
    
}
