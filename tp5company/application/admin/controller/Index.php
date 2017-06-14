<?php
namespace app\admin\controller;
use think\Loader;
use app\admin\controller\Common;
class Index extends Common
{
    public function index()
    {
        return $this->fetch();
    }
}
