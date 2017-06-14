<?php 
namespace app\admin\validate;

use think\Validate;

class Cate extends Validate
{
	//验证规则
	protected $rule =  [
				'catename' =>'require|max:15|unique:cate',
				//'需要验证的字段名' => '规则一|规则二属性：属性值|规则三属性：属性值'
				'type' =>'require',
	];
	//验证提示
	protected $message 		= [
				'catename.require'=>'栏目名称不能为空',
				'catename.unique'=>'栏目名称已存在',
				'catename.max'=>'栏目名称不能大于15位',
				'type.require'=>'请选择栏目类型',
	];
	//验证场景
	protected $scene    =[
				'edit'   =>['catename'=>'require'],
	];
}