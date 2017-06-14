<?php
namespace app\admin\model;
use think\Model;
class AuthRule extends Model
{
 
	//权限名称的无限极分类
	public function rulesTree()
	{
		$data = $this->order('sort','asc')->select();

		return $this->sort($data);
	}
	public function sort($data,$pid=0,$level=0)
	{
		static $arr = array();
		foreach($data as $k=>$v)
		{
			if($v['pid']==$pid)
			{
				$v['dataid'] = $this->getParentsId($v['id']);
				$v['level'] = $level;
				$arr[]=$v;
				 $this->sort($data,$v['id'],$level+1);
			}
		}
		return $arr;
	}
	//获得子权限ID
	 public function getChildrensId($ruleid)
    {
      $ruleres = $this->select();
      return $this->_getChildrensId($ruleres,$ruleid);
    }
    public function _getChildrensId($ruleres,$pid)
    {
        static $arr = array();  
          foreach ($ruleres as $k => $v) 
          {
            # 找到子栏目的pid与传递过来的$ruleid相同的栏目ID，$v为$ruleres的子数组
             if($v['pid']==$pid)
             {

                $arr[] =$v['id'];
                $this->_getChildrensId($ruleres,$v['id']);
             }
          }
          return $arr;
    }
    // 获得父ID
     public function getParentsId($ruleid)
    {

      $ruleres = $this->select();
      return $this->_getParentsId($ruleres,$ruleid,true);
    }
    public function _getParentsId($ruleres,$id,$clear=false)
    {

        static $arr = array();  
        if($clear)
        {
        	$arr =array();
        }
	          foreach ($ruleres as $k => $v) 
	          {
	            # 找到父栏目的id与传递过来的$rulepid相同的栏目ID，$v为$ruleres的数组
	             if($v['id']==$id)
	             {
	                $arr[] =$v['id'];
	                $this->_getParentsId($ruleres,$v['pid'],false);
	             }
	          }
	          //排序
	          asort($arr);
          		//数组转字符串
          		$arrStr= implode('-', $arr);
          		// var_dump($arr);die;
          return $arrStr;
    }
}
