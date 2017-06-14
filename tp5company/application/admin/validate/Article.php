<?php 
namespace app\admin\validate;

use think\Validate;

class Article extends Validate
{
	protected $rule =  [
				'title' =>'require|max:50|unique:article',
				//'需要验证的字段名' => '规则一|规则二属性：属性值|规则三属性：属性值'
				'keywords' =>'require|max:30',
				'desc' =>'require',
				'content' =>'require',
				'cateid' =>'require'
	];
	protected $message 	= [
				'title.require'=>'文章标题不能为空',
				'title.unique'=>'文章标题已存在',
				'title.max'=>'文章标题不能大于50位',
				'keywords.require'=>'必须有关键字',
				'cateid.require'=>'请填写文章所属栏目',
			
				'content.require'=>'文章内容不能为空',
	];
	//验证场景
	protected $scene    =[
				'edit'   =>['keywords'],
	];
}