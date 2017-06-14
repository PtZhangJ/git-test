<?php 
namespace app\index\model;

use think\Model;
class Cate extends Model
{
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
    //查找上级分类
     public function getParentsId($cateid)
    {

      $cateres = $this->select();
      return $this->_getParentsId($cateres,$cateid,true);
    }
    public function _getParentsId($cateres,$id,$clear=false)
    {

        static $arr = array();  
        if($clear)
        {
          $arr =array();
        }
            foreach ($cateres as $k => $v) 
            {
              # 找到父栏目的id与传递过来的$catepid相同的栏目ID，$v为$cateres的数组
               if($v['id']==$id)
               {
                  $arr[] =$v['id'];
                  $this->_getParentsId($cateres,$v['pid'],false);
               }
            }
            //排序
            asort($arr);
              //数组转字符串
              // $arrStr= implode('-', $arr);
              // var_dump($arr);die;
          return $arr;
    }
}