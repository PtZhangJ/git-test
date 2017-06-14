<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Article as mdArtcle;
class Artlist extends Common
{
      public function index()
    {
    	$mdArtcle = new mdArtcle();
    	$articleres = $mdArtcle->getAllArticles(input('id'));
    	$hotarticleres = $mdArtcle->getHotArticles(input('id'));
    	$catepaths = $mdArtcle->getParentsTitle(input('id'));
    	  // var_dump($catepaths);die;
    	$this->assign([
    		'articleres'=>$articleres,
    		'hotarticleres'=>$hotarticleres,
    		'catepaths'=>$catepaths,
    		]);
        return $this->fetch('artlist');
    }
    
}
