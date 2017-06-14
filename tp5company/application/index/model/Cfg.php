<?php 
namespace app\index\model;

use think\Model;
class Cfg extends Model
{
	public function getAllConf()
	{
		$confres = $this->field('value,enname')->select();
		return $confres;
	}
}