<?php
namespace app\admin\controller;

use app\admin\model\Cfg  as mdCfg;
use app\admin\controller\Common;
use think\Loader;
class Cfg  extends  Common
{
	  public function example()
    {
            //实例化模型
        
          $this->mdCfg = new mdCfg();
        
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
              $this->mdCfg->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功','Cfg/lst','',1);
            return;
        
      }
      $cfglist = $this->mdCfg->order('sort','asc')->paginate(10);
      $this->assign('cfglist',$cfglist);
       return $this->fetch('list');       
    }
     public function add()
    {
      if(request()->isPost())
      {
        $data = input('post.');
         // 如果可选值中有中文逗号转化成英文逗号
          if($data['values'])
          {
            $data['values'] = str_replace('，', ',', $data['values']);
          }
        
          $add = $this->mdCfg->save($data);

          if($add)
          {
            $this->success('添加成功','Cfg/lst','',1);
          }else
          {
            $this->error('添加失败','Cfg/lst','',1);
          }
      }
       

       return $this->fetch('add');       
    } 
    public function edit()
    {
      $id = input('id');

      $edit = $this->mdCfg->where('id',$id)->find();
      
      $this->assign('edit',$edit);
      if(request()->isPost())
      {
            $data = input('post.');
           if($data['values'])
          {
            $data['values'] = str_replace('，', ',', $data['values']);
          }
              $update = $this->mdCfg->save($data,$data['id']);
             if($update!==false)
             {
                $this->success('修改成功','Cfg/lst','',1);
             }else
             {
                $this->error('修改失败','Cfg/lst','',1);
             }
      }
       return $this->fetch();       
      
    } 
    public function del()
    {
      $del =$this->mdCfg->where('id',input('id'))->delete();
      if($del)
             {
                $this->success('删除成功','Cfg/lst','',1);
             }else
             {
                $this->error('删除失败','Cfg/lst','',1);
             }
       return $this->fetch();       
    }
    //配置项
    public function conf()
    {
      //展示所有的配置项
       $confres = mdCfg::order('sort','asc')->paginate(10);
       $this->assign('confres',$confres);

       if(request()->isPost())
       {
          $data = input('post.');
          if(!isset($data['validate']))
          {
             $data['validate'] = '';
          }
          // var_dump($data);die;
         foreach ($data as $k => $v) {
           # code...
           $conf = $this->mdCfg->where('enname',$k)->update(['value'=>$v]);
         }
         if($conf!==false)
         {
            $this->success('修改成功','Cfg/conf','',1);
         }
          return;
       }

       return $this->fetch();
    }
}
 