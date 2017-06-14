<?php
namespace app\admin\controller;
use think\Loader;

use app\admin\controller\Common;
use app\admin\model\Admin as mdAdmin;
use app\admin\model\AuthGroup as mdAG;
class Admin extends Common
{

    public function example()
    {
            //实例化模型
          
          $this->mdAdmin = new mdAdmin();
          $this->mdAG = new mdAG();
            // var_dump($mdAdmin);die;
            //验证器实例化
            $this->validate = Loader::validate('Admin');
    }
       //前置方法/前置钩子
    protected $beforeActionList = [
        'example',
    ];
    public function add()
    {
        if(request()->isPost())
        {
            // $data = ([
            //     'username' =>input('username'),
            //     'password' =>input('password'),
            // ]);
            $data = input('post.');
           
            if($this->validate->check($data))
            {
                  $add=$this->mdAdmin->addAdmin($data);
                  if($add)
                  {
                      $this->success('添加成功','Admin/lst','',1);
                  }else
                  {
                      $this->error('添加失败','','',1);
                  }
            }else
            {
              $this->error($this->validate->getError());
            }
        }
        //调用用户组
      $group = $this->mdAG->select();
      // var_dump($group);die;
      $this->assign('group',$group);
        return $this->fetch();
    }
     public function lst()
    {
      $auth =new Auth();
    
      // var_dump($groups);die;
        $adminlist = $this->mdAdmin->getAdmin(5);
        // var_dump($list);die;
            foreach ($adminlist as $k => $v) 
            {
              # code...
              $sss=db('auth_group_access')->where('uid',$v['id'])->find();
                      if($sss)
                      {
                          $groupTitle = $auth->getGroups($v['id']);
                     }
                    if(!isset($groupTitle[0]['title']))
                        {   
                         $groupTitle['groupTitle'] = "请为管理员选择用户组";
                         $v['groupTitle']  = $groupTitle['groupTitle'];                        
                      }else
                      { 
                        $groupTitle =  $groupTitle[0]['title'];
                        $v['groupTitle']  = $groupTitle;
                      }
                  
            }
        $this->assign('adminlist',$adminlist);

        return $this->fetch('list');
         
    }

     public function edit()
    {
        $id = input('id');
         $db = $this->mdAdmin->getAdmin1($id);
         $old = db('auth_group_access')->where('uid',$id)->find();
         // var_dump($old);die;
            $this->assign('db',$db);
            $this->assign('old',$old);
         if(request()->isPost())
         {
                    $data = input('post.');
                    // var_dump($data);die;
                  if($this->validate->scene('edit')->check($data))
                  {
                        $edit = $this->mdAdmin->editAdmin($data,$db);
                         // var_dump($edit);die;
                         
                              if($edit!==false)
                              {
                                  $this->success('修改成功','Admin/lst','',2);
                              }else
                              {
                                  $this->error('修改失败','Admin/lst','',2);
                              }
                   }
                   else
                   {
                          $this->error($this->validate->getError());
                   }       
        }
          //调用用户组
      $group = $this->mdAG->select();
      // var_dump($group);die;
      $this->assign('group',$group);
        return $this->fetch();
    }

    public function del()
    {
        $id = input("id");
        $del =$this->mdAdmin->del($id);
        if($del)
        {
            $this->success('删除成功','Admin/lst','',2);
        }else
        {
            $this->error('删除失败','Admin/lst','',2);
        }
    }


      //管理员退出登陆
      public  function logout()
      {
         session(null);

        $this->success('已退出','Login/index','',2);
      } 
}
