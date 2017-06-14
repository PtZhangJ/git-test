<?php
namespace app\admin\controller;
use think\Loader;
use app\admin\model\Article as mdArticle;
use app\admin\model\Cate as mdCate;
use app\admin\controller\Common;
class Article extends Common
{
  public function example()
    {
            //实例化模型
          
          $this->mdArticle = new mdArticle();
          $this->mdCate = new mdCate();
            // var_dump($mdAdmin);die;
          $this->validate = Loader::validate('Article');
    }
       //前置方法/前置钩子
    protected $beforeActionList = [
        'example',
    ];
  public function lst()
  {
    $artlist= $this->mdArticle->alias('a')->field('a.*,c.catename')->join('company_cate c','a.cateid=c.id')
    // ->select();
 ->paginate(10);
    $this->assign('artlist',$artlist);
    return $this->fetch('list');
  }
  public function add()
  {
    $cates = $this->mdCate->catetree();
    // var_dump($cates);die;
    $this->assign('cates',$cates);
      if(request()->isPost())
      {
        $add=input('post.');
        $add['time']= time();
        // var_dump($add);die;
            if($this->validate->check($add))
            {
                       $add = $this->mdArticle->save($add);
              //
                if($add)
                {
                  $this->success('添加成功','Article/lst','',2);
                }else
                {
                     $this->error('添加失败','','',2);
                }
            }else
            {
              $this->error($this->validate->getError());
            }
      }
    return $this->fetch();
  }
  public function edit()
  {
    //查找栏目名
    $cate = $this->mdCate->catetree();
    //查找原来的数据
    $oldData = db('article')->where('id',input('id'))->find();
    $this->assign([
        'cate'=>$cate,
        'oldData'=>$oldData,
      ]);
      if(request()->isPost())
      {
          $newData = input('post.');
          $newData['time'] = time();
            if($this->validate->scene('edit')->check($newData))
            {
                $edit = $this->mdArticle->save($newData,$newData['id']);
                  if($edit!=false)
                  {
                     $this->success('修改成功','Article/lst','',2);
                  }else
                  {
                       $this->error('修改失败','Article/lst','',2);
                  }
              }else
            {
              $this->error($this->validate->getError());
            }
      }
    return $this->fetch();
  }
  public function del()
  {
    $del = mdArticle::destroy(input('id'));
      if($del)
            {
               $this->success('删除成功','Article/lst','',2);
            }else
            {
                 $this->error('删除失败','Article/lst','',2);
            }
  }

}
