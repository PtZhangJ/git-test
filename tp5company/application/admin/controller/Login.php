<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin  as mdAdmin;
class Login extends Controller
{
     public function index()
    {
                     if(request()->isPost())
                     {
                      $data = input('post.');
                      // var_dump($data);die;
                      //  //验证验证码
                       // $captcha = new \think\captcha\Captcha();
                       //      if (!$captcha->check($data['captcha']))
                       //       {
                       //          $this->error('验证码错误');
                       //      } 
                      //  end
                     $login = new mdAdmin();
                     $status = $login->login($data);
                     switch ($status) 
                        {
                        case 1:
                            # code...
                            $this->success('登陆成功','Index/index','',2);
                            break;
                        case 2:
                            # code...
                            $this->error('账号或密码错误','','',2);
                            break;
                        default:
                            # code...
                             $this->error('该用户不存在','','',2);
                            break;
                            }
                      }
    return $this->fetch('login');
           }
}
