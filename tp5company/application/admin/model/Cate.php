<?php
namespace app\admin\model;
use think\Model;
class Cate extends Model
{

    //后台无限分类
    public function catetree()
    {
      $cateres = $this->order('sort','asc')->select();
       return $this->sort($cateres);

    }
    public function sort($data,$pid=0,$level=0)
    {
      //排序
      static $arr = array();
        foreach ($data as $k => $v) 
        {
          //使用递归，第一次找顶级分类，即$data['pid']=0,即$data['pid']=$pid
            if($v['pid']==$pid)
            {
              $v['level'] =$level;//给$data新增一个level数组
              $arr[] = $v;
              $this->sort($data,$v['id'],$level+1);//找当前栏目的子栏目
            }
        }
      return $arr;
    }
    public function getChildrensId($cateid)
    {
      $cateres = $this->select();
      return $this->_getChildrensId($cateres,$cateid);
    }
    public function _getChildrensId($cateres,$pid)
    {
        static $arr = array();  
          foreach ($cateres as $k => $v) 
          {
            # 找到子栏目的pid与传递过来的$cateid相同的栏目ID，$v为$cateres的子数组
             if($v['pid']==$pid)
             {
                $arr[] =$v['id'];
                $this->_getChildrensId($cateres,$v['id']);
             }
          }
          return $arr;
    }
}
