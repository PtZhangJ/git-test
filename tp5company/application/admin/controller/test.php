<!-- 这是一些我自己写的 -->


<?php 
//无限分类
 public function fenlei()
 {
 	$data = $this->select();
 	return $this->sort($data);
 }
 public function sort($data,$pid=0,$level=0)
 {
 	static $arr = array();
 	foreach($data as $k=>$v)
 	{
 		if($v['pid']==$pid)
 		{
 			$v['level']=$level;
 			$arr[]=$v;
 			$this->sort($data,$v['id'],$level+1);
 		}
 	}
 	return $arr;
 }

 //前置钩子
  protected $beforeActionList=[
  		'predel'   =>['only'=>'del'],
  ];
  public function del()
  {
  	$del = db('cate')->where('id',input('id'))->delete();

  }
  public function predel()
  {

  	$sonsId = $this->mdCate->getchildsId(input('id')); 
  	if($sonsId)
  	{
  		db('cate')->delete($sonsId);
  	}
  }
  public function getchildsId($cateid)
  {
  	$cates = $this->select();
  	return _getChildrensId($cates,$cateid) ;
  }
  public function _getChildrensId($data,$cateid)
  {
  	static $arr = array();
  	foreach ($data as $k => $v) {
  		# code...
  		if($v['pid']=$cateid)
  		{
  			$arr[]=$v['id'];
  			$this->_getChildrensId($data,$v['id']); 
  		}
  	}
  	return $arr;
  }
  /////////////////////图上传
  if(isset($_FILES['idcard']) || isset($_FILES['license']) || isset($_FILES['xzface']) || isset($_FILES['xzfile']) || isset($_FILES['creatbodyface'])){
      $upload = new \Think\Upload();// 实例化上传类
      $upload->maxSize   =     4194304 ;// 设置附件上传大小
      $upload->exts      =     array('doc','docx','ppt','pdf','xls','xlsx','pptx','jpg','gif','png','jpeg');// 设置附件上传类型
      $upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
      $upload->savePath  =      'Cyxm/'; // 设置附件上传（子）目录
      // 上传文件
      $info   =   $upload->upload();
      if($info) {// 上传成功 获取上传文件信息
          foreach($info as $file){
            // var_dump($file);die;
            if($file['key'] == 'xzface'){
              $xzface = $file['savepath'].$file['savename'];
                  $def_xzface = $file['savepath'].'def_'.$file['savename'];
                  $sm_xzface = $file['savepath'].'sm_'.$file['savename'];
                  // 打开图片
                  $image = new \Think\Image();
                  $image->open('./Uploads/'.$xzface);
                  // 生成缩略图
                  $image->thumb(300, 300,\Think\Image::IMAGE_THUMB_CENTER)->save('./Uploads/'.$def_xzface);
                  $image->thumb(150, 80,\Think\Image::IMAGE_THUMB_SCALE)->save('./Uploads/'.$sm_xzface);
                  // 图片路径存到数据库中
                  $data['xzdef_face'] = $def_xzface;
                  $data['xzface'] = $xzface;
                  $data['xzsm_face'] = $sm_xzface;
            }elseif($file['key'] == 'creatbodyface'){
              $xzface = $file['savepath'].$file['savename'];
                  $def_xzface = $file['savepath'].'def_'.$file['savename'];
                  $sm_xzface = $file['savepath'].'sm_'.$file['savename'];
                  // 打开图片
                  $image = new \Think\Image();
                  $image->open('./Uploads/'.$xzface);
                  // 生成缩略图
                  $image->thumb(300, 300,\Think\Image::IMAGE_THUMB_CENTER)->save('./Uploads/'.$def_xzface);
                  $image->thumb(150, 150,\Think\Image::IMAGE_THUMB_SCALE)->save('./Uploads/'.$sm_xzface);
                  // 图片路径存到数据库中
                  $data['creatbodydef_face'] = $def_xzface;
                  $data['creatbodyface'] = $xzface;
                  $data['creatbodysm_face'] = $sm_xzface;
            }else{
                $data[$file['key']] = $file['savepath'].$file['savename'];
            }
          }
      }
        }