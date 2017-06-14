<?php
namespace app\admin\controller;
use think\Loader;
use app\admin\model\Cate as mdCate;
use app\admin\model\Article as mdArticle;
use app\admin\controller\Common;
class Cate extends Common
{
      
    public function example()
    {
            //实例化模型
         
          $this->mdCate = new mdCate();
          $this->mdArticle = new mdArticle();
            // var_dump($mdCate);die;
          $this->validate = Loader::validate('Cate');
    }

    //前置方法/前置钩子
    protected $beforeActionList = [
        'predel' =>['only'=>'del'],
        'example',
        // 'second' =>  ['except'=>'hello'],
        // 'three'  =>  ['only'=>'hello,data'],
    ];


    public function add()
    {
        if(request()->isPost())
        {
          $data = input('post.');
          // var_dump($data);die;
                if($this->validate->check($data))
                {
                    $add = $this->mdCate->save($data);
                      if($add)
                      {
                        $this->success('添加栏目成功','Cate/lst','',1);
                      }
                      else
                      {
                        $this->error('添加栏目失败','Cate/lst','',1);
                      }
                }else
                {
                    $this->error($this->validate->getError());
                }
        }
        //分类
        $cateres = $this->mdCate->catetree();
        $this->assign('cateres',$cateres);
  
        return $this->fetch();
    }
     public function lst()
    {
      //更新sort字段
        if(request()->isPost())
        {
            $sorts = input('post.');
            foreach($sorts as $k=>$v)
            {
              $this->mdCate->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新成功','Cate/lst','',1); 
            return;
        }
      //更新完
      $catelist =  $this->mdCate->catetree();
      $this->assign('catelist',$catelist);
        return $this->fetch('list');
    }

     public function edit()
    {

       $id = input('id');
         //分类
           $cateres = $this->mdCate->catetree();
          $catere = db('cate')->where('id',$id)->find();
        
          $this->assign([
              'cateres'=>$cateres,
              'catere'=>$catere,
            ]);
        if(request()->isPost())
        {
          $data = input('post.');
           if($this->validate->scene('edit')->check($data))
              {
                $edit = db('cate')->where('id',$id)->update($data);
                    if($edit)
                  {
                    $this->success('修改栏目成功','Cate/lst','',1);
                  }
                  else
                  {
                    $this->error('修改栏目失败','Cate/lst','',1);
                  }
               }else
              {
                  $this->error($this->validate->getError());
              }      
        }
        return $this->fetch();
    }
//删除
    public function del()
    {
     
        $del = db('cate')->where('id',input('id'))->delete();
            if($del)
            {
              $this->success('删除成功','Cate/lst','',1);
            }
            else
            {
              $this->error('删除失败','Cate/lst','',1);
            }
    }
// 删除前
// 删除子栏目
     public function predel()
    {
      //input 的数据可以在前置方法中接收
      //这样只能删除两层
        // $db = db('cate')->where('pid',input('id'))->delete();
        $childsId = $this->mdCate->getChildrensId(input('id'));
        // var_dump($childsId);die;
        if($childsId)
        {
        db('cate')->delete($childsId);
        }
        //删除该栏目以及子栏目下的文章
          //获得该栏目的ID和子栏目的ID
        $allcateId = $childsId;
        $allcateId[] = input('id');
        foreach ($allcateId as $k => $v) 
        {
          # code...
          mdArticle::destroy(['cateid'=>$v]);
        }
    }
    
      
}
