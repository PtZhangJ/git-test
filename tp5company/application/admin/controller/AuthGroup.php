<?php
namespace app\admin\controller;
use think\Controller;
 use app\admin\model\AuthGroup  as mdAG;
 use app\admin\model\AuthRule  as mdAR;
use think\Loader;
class AuthGroup  extends  Common
{

	public function lst()
  {
      $AGlist = db('auth_group')->paginate(10);
      $this->assign('AGlist',$AGlist);
     return $this->fetch();
  }
  public function add()
  {

      if(request()->isPost())
      {
        $data = input('post.');
         // var_dump($data);die;
        if(($data['rules']))
        {
          $data['rules'] = implode(',',$data['rules']);
        }
          if(!isset($data['status']))
          {
            $data['status'] =0;
          }
          // var_dump($data);die;
            $add = db('auth_group')->insert($data);
            if($add)
            {
              return $this->success('添加成功','lst','',1);
            }else
            {
              return $this->error('添加失败','','',1);
            }

      }
         //获取权限
         $mdAR =new mdAR();
         $rule = $mdAR->rulesTree();

         $this->assign('rule',$rule);
    return $this->fetch();
  }
   public function edit()
  {
      $old= db('auth_group')->where('id',input('id'))->find();
      $this->assign('old',$old);
      if(request()->isPost())
      {
        $data = input('post.');
         if(($data['rules']))
        {
          $data['rules'] = implode(',',$data['rules']);
        }
         if(!isset($data['status']))
          {
            $data['status'] =0;
          }
        $edit = db('auth_group')->where('id',$data['id'])->update($data);
           if($edit!==false)
            {
              return $this->success('修改成功','lst','',1);
            }else
            {
              return $this->error('修改失败','edit','',1);
            }
      }
       //获取权限
         $mdAR =new mdAR();
         $rule = $mdAR->rulesTree();
        
         $this->assign('rule',$rule);
    return $this->fetch();
  }
   public function del()
  {
    $del = db('auth_group')->where('id',input('id'))->delete();
        if($del)
            {
              return $this->success('删除成功','lst','',1);
            }else
            {
              return $this->error('删除失败','','',1);
            }
  }
}
 