<?php
namespace app\admin\model;
use think\Model;
class Article extends Model
{
  //图片的上传
  protected static function init()
  {
  	Article::event('before_insert',function($data)
  	{
  		// var_dump($data);die;
  		if(request()->file('pic'))
  		{
  			$pic = request()->file('pic');
  			//图片存储地址
  			$info = $pic->move(ROOT_PATH.'public/static/admin'.DS.'uploads');
  			if($info)
  			{
  					// 成功上传后 获取上传信息
  			       $data['pic'] = '/static/admin/uploads/'.date('Ymd').'/'.$info->getFileName();
  				
  			}else
  			{
  				 // 上传失败获取错误信息
                          echo $data->getError();

  			}
  		}else
            {
                    $data['pic'] = '/static/admin/uploads/20170415/default.jpg';
            }
  	});
  	Article::event('before_update',function($data)
  		{
  			
  			if(request()->file('pic'))
  			{
  				$oldPic = Article::find($data['id']);
  				$picPath = $_SERVER['DOCUMENT_ROOT'].$oldPic['pic'];
                    // var_dump($oldPic['pic']);die;
	  		    if(file_exists($picPath))
	  			{//判断原来图片，删除旧图片
                            if($oldPic['pic']!="/static/admin/uploads/20170415/default.jpg")
                            {//如果不是默认图的话删除
                              @unlink($picPath);
                            }
	  				
	  			}
  				//图像上传
  				$pic= request()->file('pic');
  				$info = $pic->move(ROOT_PATH.'public/static/admin/'.DS.'uploads');
  				if($info)
  				{
  					$data['pic'] = '/static/admin/uploads/'.date('Ymd').'/'.$info->getFileName();
  				}else
  				{
  					echo $data->getError();
  				}
  			}
                
  				
  				
  			
  		});
  	Article::event('before_delete',function($data)
  		{
  			
  			
  				$oldPic = Article::find($data['id']);
  				$picPath = $_SERVER['DOCUMENT_ROOT'].$oldPic['pic'];
	  		    if(file_exists($picPath))
	  			{//判断原来图片，删除旧图片

	  				@unlink($picPath);
	  			}
			
  			
  		});

   }
   
}
