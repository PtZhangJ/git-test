
<?php

//处理二维数组去重
         function  arr_unique($arr2D)
         {
         		//降维
         		
         		foreach ($arr2D as $v) {
         			# code...
         			$v1 = join(',',$v);//拆分成用逗号隔开的字符串
         			//拼装成一维数组
         			$arr1D[]=$v1;
         			
         		}
         		//一维数组去重
         		$arr1d = array_unique($arr1D);
         		//再组装成二维
         		foreach ($arr1d as $k => $v) {
         			# code...
         			$arr1d[$k] = explode(',',$v);
         			$arr1d[$k]['id'] = $arr1d[$k][0];
         			$arr1d[$k]['title'] = $arr1d[$k][1];
                                  $arr1d[$k]['time'] = $arr1d[$k][2];
                                 $arr1d[$k]['pic'] = $arr1d[$k][3];
         			$arr1d[$k]['cateid'] = $arr1d[$k][4];
         		}
         		// var_dump($arr1d);die;
         		return $arr1d;
         		
         }