<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Link  as mdLink;

use think\Loader;
class Link  extends  Common
{
	  public function example()
    {
            //实例化模型
         
          $this->mdLink = new mdLink();
        
    }
       //前置方法/前置钩子
    protected $beforeActionList = [
        'example',
    ];
    public function lst()
    {       
        
         if(request()->isPost())
         {
            $sort = input('post.');
            foreach ($sort as $k => $v)
             {
              # code...
              $this->mdLink->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功','Link/lst','',1);
            return;
         }

            $linklist=$this->mdLink
            // ->select();
          ->order('sort','asc')
          ->paginate(10);
          //   // var_dump($link);
          $this->assign('linklist',$linklist);

        return $this->fetch('list');
    }


     public function add()
    {
    //传入数据
        if(request()->isPost())
        {
              $data   =    [
                     'title' =>input('title'),
                   'url' =>input('url'),
               
                                 ];
      
                    //验证
                  $validate = Loader::validate('Link');
                  if($validate->check($data))
                  {
                    //添加数据
                    $db = $this->mdLink->save($data);
                        if($db)
                        {
                             return $this->success('添加成功','lst','',1);
                        }
                        else
                        {
                            return $this->error('添加失败','lst','',1);
                        }    
                  }else
                  {
                    return $this->error($validate->getError());
                  }
         }

        return $this->fetch();
    }
    //链接修改
    public function edit()
    {
       //读取需要修改的链接
       $id = input('id');
       $edit =$this->mdLink->where('id',$id)->find();
       // var_dump($edit);die;
       $this->assign('edit',$edit);
       //接受更新后的数据
           if(request()->isPost())
        {
                $data   =   input('post.'); 
                   // var_dump($data);die;
           //验证
                   $validate = Loader::validate('link');
                   if($validate->scene('edit')->check($data))  
                   {

                      $db =$this->mdLink->save($data,$data['id']);

                          if($db)
                          {
                             return $this->success('修改成功','lst','',1);
                          }else
                          {
                             return $this->error('修改失败','lst','',1);
                          }
                   }else
                   {
                           return $this->error($validate->getError());
                   }
             }
        return $this->fetch();
    }
    //删除链接
    public function del()
        {
            $id = input('id');
            $delete =mdLink::destroy($id);
            return $this->success('删除成功！','lst','',2) ;
    }    
}
 