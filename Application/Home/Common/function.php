<?php
//时间
function get_date($time){
	$date=date('Y/m/d',$time);
	return $date;
}

//二级分类
function getsub($pid){
	$where['pid'] = $pid;
	$cmod = M("class") -> where($where) ->order("ord asc") -> select();
	return $cmod;
}

//相关栏目应用
 function other_class($id){
		$other = M('class')->where("pid={$id}")->order("ord2 asc")->select();
		// var_dump($other);//exit;
		return $other;
	}

//三级分类跳转模板
function get_name_three($path){
	$pathid=explode(',',$path)[1];
	// var_dump($pathid);exit;
	if($pathid=='2'){
		return 'products_view';
	}elseif ($pathid=='4') {
		return 'solutions_view';
	}else{
		return 'case_class';
	}
} 
//二级分类跳转模板
function get_class_url($id){
	$pid = M('class')->where("id={$id}")->getField('pid');
	if($pid == '2'){
		$return = 'products';
	}elseif($pid == '4'){
		$return = 'solutions';	
	}elseif($pid == '5'){
		$return = 'success_case';
	}elseif($pid == '6'){
		$return = 'cloud';
	}elseif($pid == '7'){
		$return = 'news';
	}elseif($pid == '8'){
		//$return = 'service';
		if($id == '150'){
			$return = 'filedown';
		}elseif($id == '28'){
			$return = 'service';
		}elseif($id == '29'){
			$return = 'online';
		}elseif($id == '324'){
			$return='hongshiyun';
		}
	}elseif($pid == '9'){
		if($id == '30'){
			$return = 'about_us';
		}elseif($id == '31'){
			$return = 'honor';
		}elseif($id == '32'){
			$return = 'team';
		}elseif($id == '33'){
			$return = 'rec';
		}elseif($id == '34'){
			$return = 'invest';
		}elseif($id == '35'){
			$return = 'market';
		}elseif($id == '36'){
			$return = 'contact';
		}elseif($id == '278'){
			$return = 'friend';
		}
	}
	return $return;
}
//快捷入口图
function get_quick_pic($id){
	$map['id'] = $id;
	$return = M('class')->where($map)->getField('pic');
	return $return;
}
//快捷入口标题
function get_quick_title($id){
	$map['id'] = $id;
	$return = M('class')->where($map)->getField('title');
	return $return;
}
//快捷入口介绍
function get_quick_content($id){
	$map['id'] = $id;
	$return = M('class')->where($map)->getField('content');
	return $return;
}
//快捷入口介绍
function get_quick_describe($id){
	$map['id'] = $id;
	$return = M('class')->where($map)->getField('content');
	return $return;
}
//通过栏目id获取栏目名称
function get_id_classname($id){
	$return = M('class')->where("id={$id}")->getField('name');
	return $return;
}
//通过文章id获取文章添加时间
function get_article_addtime($id){
	$return = M('article')->where("id={$id}")->getField('addtime');
	$return=date('m/d',$return);
	return $return;
}
//通过文章id获取文章标题
function get_article_title($id){
	$return = M('article')->where("id={$id}")->getField('title');
	if(mb_strlen($return,'utf-8')>40){
		$item=mb_substr($return,0,40,'utf-8').'........';
		$return =  $item;
	}else{
		$return =  $return.'　　　　　　　';
	}
	return $return;
}
//通过文章分类id获取文章分类的父类
function get_id_cid_father($id){
	$return = M('class')->where("id={$id}")->getField('pid');
	return $return;
}
//截取长度
function get_substr($string){
	$return = mb_substr($string,0,75,'utf-8');
	$return = $return.'……';
	return $return;
}
//截取首页新闻长度
function get_new_substr($string){
	$return = mb_substr($string,0,150,'utf-8');
	$return = $return.'……';
	return $return;
}

//替换账号的中间字
function sub_replace($string){
	$return =substr_replace($string, '*', 3,4);
	return $return;
} 


// 过滤掉解决方案
	function jiejue_replace($string){
		$string = str_replace('解决方案','',$string);
 		return $string;

	}
