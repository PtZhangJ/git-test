<?php
namespace app\index\controller;
use app\index\model\Article as mdArticle;
class Index extends Common
{
    public function index()
    {
        $mdArticle = new mdArticle();
        $newArt = $mdArticle->getNewArticle();
        $hotArt = $mdArticle->order('click desc')->limit(10)->select();
        $link = db('link')->select();
        //动态图
        $recArt = $mdArticle->getRecArticle();
        // var_dump($recArt);die;
        $this->assign([
        	'newArt'=>$newArt,
        	'hotArt'=>$hotArt,
            'link'=>$link,
        	'recArt'=>$recArt,
        	]);
        return $this->fetch();
    }
   
}
