<?php 
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
	protected $rule =  [
				'username' =>'require|max:30|unique:Admin',
				//'需要验证的字段名' => '规则一|规则二属性：属性值|规则三属性：属性值'
				'password' =>'require'
	];
	protected $message 	= [
				'username.require'=>'管理员名称不能为空',
				'username.unique'=>'管理员名称已存在',
				'username.max'=>'管理员名称不能大于30位',
				'password.require'=>'密码不能为空',
	];
	//验证场景
	protected $scene    =[
				'edit'   =>['username'=>'require'],
	];
}