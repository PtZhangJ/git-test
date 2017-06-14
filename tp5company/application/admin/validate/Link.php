<?php 
namespace app\admin\validate;

use think\Validate;

class Link extends Validate
{
	protected $rule =  [
				'title' =>'require|max:50|unique:link',
				//'需要验证的字段名' => '规则一|规则二属性：属性值|规则三属性：属性值'
				
				
				'url' =>'require'
	];
	protected $message 	= [
				'title.require'=>'链接名称不能为空',
				'title.unique'=>'链接名称已存在',
				'title.max'=>'链接名称不能大于50位',
				'url.require'=>'链接地址不能为空',
	];
	//验证场景
	protected $scene    =[
				'edit'   =>['url'],
	];
}