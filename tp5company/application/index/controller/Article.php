<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Article as mdArtcle;
class Article extends Common
{
      public function index()
    {
    	$mdArtcle = new mdArtcle();
    	$a =input('cateid'); 
    	if($a!='')
    	{
    		$catepaths = $mdArtcle->getParentsTitle(input('cateid'));
    	}else
    	{
    	$catepaths = $mdArtcle->getParentsTitle(input('id'));
    	}
    	//点赞
    	 $mdArtcle->where('id',input('id'))->setInc('click');
    	//主文章
    	$article = $mdArtcle->where('id',input('id'))->find();
    	//热点文章
    	$hotArt = $mdArtcle->getHotArticles($a);
            //相关文章(你可能喜欢)
            //找关键词
            $keywords = db('article')->field('keywords')->where('id',input('id'))->find();
            // var_dump($keywords);die;
            $keyart =  $mdArtcle->getRelate($keywords['keywords']);
               // var_dump($keyart);die;
    	$this->assign([
    		'catepaths'=>$catepaths,
    		'article'=>$article,
                       'hotArt'=>$hotArt,
    		'keyart'=>$keyart,
    		]);
        return $this->fetch('article');
    }
    
}
