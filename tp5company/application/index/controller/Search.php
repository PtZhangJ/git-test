<?php
namespace app\index\controller;
class Search extends Common
{
      public function index()
    {
    	   $key = input('get.keyword');
    	   // var_dump($key);die;
    	   $serRes = db('article')->where('title','like','%'.$key.'%')->order('id desc')
    	   //paginate传参
    	   ->paginate(2,false,$config=['query'=>array('keyword'=>$key)]);
    	   // ->select();
    	   $ser = db('article')->where('title','like','%'.$key.'%')->order('id desc')->select();
    	   //hot
    	   $hotRes = db('article')->order('click desc')->limit(5)->select();
    	   $this->assign([
    	   		'serRes'=>$serRes,
    	   		'hotRes'=>$hotRes,
    	   		'ser'=>$ser,
    	   	]);
        return $this->fetch('search');
    }
    
}
