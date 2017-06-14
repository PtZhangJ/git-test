<?php
namespace app\index\controller;
use think\Controller;
class Page extends Common
{
      public function index()
    {
        return $this->fetch('page');
    }
    
}
