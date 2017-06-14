<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Cfg  as mdCfg;
class Common extends Controller
{
      public function _initialize()
    {
        //配置项数据
        $conf = new mdCfg();
        $_confres = $conf->getAllConf();
        $confres = array();
        foreach($_confres as $k=>$v)
        {
        	$confres[$v['enname']] = $v['value'];

        }
        // var_dump($confres);die;
            $this->assign('confres',$confres);
            //执行导航
            $this->getNavCates();
    }
    public function getNavCates()
    {

        //导航栏栏目
        //两级联动菜单
        $onecates= db('cate')->where('pid',0)->select();
        foreach ($onecates as $k => $v)
         {
            # code...
            $twocates = db('cate')->where('pid',$v['id'])->select();
            if($twocates)
            {
                $onecates[$k]['child'] = $twocates;
            }else
            {
                  $onecates[$k]['child']=0;
            }
        }
         // var_dump($onecates);die;
        $this->assign('onecates',$onecates);
    }
}
