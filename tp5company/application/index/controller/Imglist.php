<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Article as mdArtcle;
class Imglist extends Common
{
      public function index()
    {
    	$mdArtcle = new mdArtcle();
    	$catepaths = $mdArtcle->getParentsTitle(input('id'));
    	$this->assign('catepaths',$catepaths);
        return $this->fetch('imglist');
    }
    
}
