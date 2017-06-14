<?php
namespace app\admin\controller;
use think\Controller;
 use app\admin\model\AuthRule  as mdAR;

use think\Loader;
class AuthRule  extends  Common
{

  //前置钩子
    protected $beforeActionList=[
                  'predel' =>['only'=>'del'],
    ];


	public function lst()
  {
    if(request()->isPost())
        {
            $sorts = input('post.');
            // var_dump($sorts);die;
            foreach($sorts as $k=>$v)
            {

              mdAR::update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新成功','lst','',1); 
            return;
        }
        $mdAR = new mdAR();
      $ARlist = $mdAR -> rulesTree();
      $this->assign('ARlist',$ARlist);
     return $this->fetch();
  }
  public function add()
  {
      if(request()->isPost())
      {
        $data = input('post.');
          if(!isset($data['status']))
          {
            $data['status'] =0;
          }
          //找到父level
                $plevel = db('auth_rule')->field('level')->where('id',$data['pid'])->find();
                // var_dump($plevel);die;
                if($plevel!=null)
                {
                $data['level']=$plevel['level']+1;
                }
            $add = db('auth_rule')->insert($data);
            if($add)
            {
              return $this->success('添加成功','lst','',1);
            }else
            {
              return $this->error('添加失败','','',1);
            }

      }

      $authrules = db('auth_rule')->select();
      // var_dump($authrules);die;
      $this->assign('authrules',$authrules);
    return $this->fetch();
  }
   public function edit()
  {
      $old= db('auth_rule')->where('id',input('id'))->find();
      // var_dump($old);die;
      $this->assign('old',$old);
      $namelist = db('auth_rule')->select();
      $this->assign('namelist',$namelist);
      if(request()->isPost())
      {
        $data = input('post.');
        // var_dump($data);die;
         if(!isset($data['status']))
          {
            $data['status'] =0;
          }
           //找到父level
                $plevel = db('auth_rule')->field('level')->where('id',$data['pid'])->find();
                // var_dump($plevel);die;
                if($plevel!=null)
                {
                $data['level']=$plevel['level']+1;
                }else
                {
                  $data['level']=1;
                }
        $edit = db('auth_rule')->where('id',$data['id'])->update($data);
           if($edit!==false)
            {
              return $this->success('修改成功','lst','',1);
            }else
            {
              return $this->error('修改失败','edit','',1);
            }
      }
    return $this->fetch();
  }
   public function del()
  {
    $del = db('auth_rule')->where('id',input('id'))->delete();
        if($del)
            {
              return $this->success('删除成功','lst','',1);
            }else
            {
              return $this->error('删除失败','','',1);
            }
  }
    public function predel()
    {

        $mdAR = new mdAR();
        $childsId = $mdAR->getChildrensId(input('id'));
           //获得当前权限的父ID
         $parentId = $mdAR->getParentsId(input('id'));
         // var_dump($parentId);die;
            if($childsId)
            {
            db('auth_rule')->delete($childsId);
            }
          //删除该栏目以及子栏目下的文章
            //获得该栏目的ID和子栏目的ID
          // $allcateId = $childsId;
          // $allcateId[] = input('id');
          // foreach ($allcateId as $k => $v) 
          // {
          //   # code...
          //   mdArticle::destroy(['cateid'=>$v]);
          // }
      }
  
}
 