<?php 
namespace app\index\model;
use app\index\model\Cate as mdCate;
use think\Model;
class Article extends Model
{
	public function getAllArticles($cateid)
	{
		$cate = new mdCate();
		$allCatesId = $cate->getChildrensId($cateid);
		$allCatesId[]=(int)$cateid;
	 // var_dump($allCatesId);
		 $strId=implode(',', $allCatesId);
		 // var_dump($strId);die;
		$articleres = db('article')->where("cateid IN($strId)")->paginate(10);
		return $articleres;
	}
	public function getHotArticles($cateid)
	{
		$cate = new mdCate();
		$allCatesId = $cate->getChildrensId($cateid);
		$allCatesId[]=(int)$cateid;
		 $strId=implode(',', $allCatesId);
		$articleres = db('article')->where("cateid IN($strId)")->order('click','desc')->limit(5)->select();
		return $articleres;
	}
	public function getParentsTitle($cateid)
	{
		$cate = new mdCate();
		$allCatesID = $cate->getParentsId($cateid);
		 $strId=implode(',', $allCatesID);
		 $titles = db('cate')->where("id IN($strId)")->field('id,catename')->order('id','asc')->select();
		 return $titles;
	}
	//相关文章
	//另外的N篇文章和当前文章拥有相同的一个或多个关键词
	public function getRelate($keywords)
	{
		 // var_dump($keywords);die;
		$key = explode(',', $keywords);
		 // var_dump($key);die;
		static $relarticles = array();
		foreach($key as $k=>$v)
		{
			$map['keywords'] = ['like','%'.$v.'%'];
			$rel = db('article')
					->where($map)
					->order('id','asc')
					->limit(5)
					->field('id,title,time,pic,cateid')
					->select();
			
			//合并数组//找到每个条件下的数据，然后存入一个空数组中
			$relarticles = array_merge($relarticles,$rel);
		}
			// var_dump($relarticles);die;
			//去重
			// $relarticles = array_unique($relarticles);//只能对一维进行去重
				//调用公共文件common.php中的函数进行去重 
			$relarticles = arr_unique($relarticles);
		return $relarticles;
		
	}
	//获得最新的文章
	public function getNewArticle()
	{
		$newArt = $this->alias('a')->join('cate c','a.cateid=c.id')->field('a.*,c.catename')->order('a.id desc')->limit(10)->select();
		// var_dump($newArt);die;
		return $newArt;
	}
//获得动态图
	public function getRecArticle()
	{
		$rec = $this->where('rec',1)->field('id,cateid,title,pic')->order('id','desc')->select();
		// var_dump($rec);die;
		return $rec;
	}
	
}