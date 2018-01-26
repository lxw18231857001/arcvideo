<?php
//admin用户状态
function get_admin_status($status){
	if($status == '0'){
		return '正常';
	}elseif($status == '1'){
		return '禁用';
	}
}
//时间
function get_date($time){
	$date=date('Y/m/d',$time);
	return $date;
}
//父类名称
function get_class_pid($pid){
	$father = M('class')->where("id={$pid}")->select();
	if($father){
		return $father['0']['name'];
	}else{
		return '-';
	}
}
//判断是否是顶级
function get_class_orson($name){
	$father = M('class')->where("name='{$name}'")->getField('path');
	$count = substr_count($father,',');
	if($count==2){
		$name = '|_ _ _'.$name;
	}elseif($count==1){
		$name =  $name;
	}else{
		$name =  '　　　|_ _ _ _ _ _'.$name;
	}
	return $name;
}

//获得顶级导航类名
function get_father($pid){
	$fid=M('class')->where("id={$pid}")->getField('pid');
	$name = M('class')->where("id='{$fid}'")->getField('name');
	// var_dump($name);
	return $name;
}

//获得顶级导航类名id
function get_father_id($pid){
	$fid=M('class')->where("id={$pid}")->getField('pid');
	return $fid;
}

//获取一级分类和二级分类
function getsub($pid){
	$mod = D("class");
	//$where['pid'] = $pid;
	$cmod1 = $mod -> where("id={$pid}") -> select();//栏目
	$cmod2 = $mod -> where("pid={$pid}") -> order('ord2 asc')->select();//子栏目
	$cmod = array_merge($cmod1,$cmod2);
	// var_dump($cmod);//exit;
	return $cmod;
}
//获取分类下的文章
function getarticle($pid){
	$mod = D("article");
	$cmod = $mod -> where("cid={$pid}") -> select();
	return $cmod;
}
//用栏目id获取栏目名称
function get_classname($id){
	$return = M('class')->where("id={$id}")->getField('name');
	return $return;
}
//用广告id获取广告图
function get_picture($id){
	$return = M('class')->where("id={$id}")->getField('pic');
	return $return;
}
//用广告id获取广告图
function get_picture_no($id){
	$return = M('class')->where("id={$id}")->getField('pic');
	return $return;
}
//查看该广告是否已经添加
function get_advertisement($id){
	$return = M('class')->where("cid={$id}")->getField('id');
	if($return){
		$return = '修改';
	}else{
		$return = '添加';
	}
	return $return;
}
//主页新闻标题
function get_article_name($id){
	$return = M('article')->where("id={$id}")->getField('title');
	return $return;
}
//用分类id拿该分类的所有文章
function get_article($pid){
	$mod = D("article");
	$cmod = $mod -> where("cid={$pid}") -> select();
	return $cmod;
}
//权限描述
function get_node($node,$name){
	if($node){
		$b=explode(',',$node);
		if(count($b) == count(M('node')->select()) ){
			$node = '他拥有至高无上的权利';
		}elseif(in_array($name,C('SUPER_NAME'))){
			$node = '他拥有至高无上的权利';
		}else{
			foreach ($b as $key => $value) {
				$node_name[] = M('node')->where("id={$value}")->getField('name');
			}
			$node= '他拥有'.implode(',',$node_name).'的权限'; 
		}
		return $node;
	}else{
		$node = '该管理员没有被分配任何权限';
		return $node;
	}
	
}   
 