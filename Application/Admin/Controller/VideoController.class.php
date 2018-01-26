<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\common;
class VideoController extends CommonController {
	public function arrToOne($multi) 
	{
	$arr = array();
	foreach ($multi as $key => $val) {
		if( is_array($val) ) {
			$arr = array_merge($arr, $this->arrToOne($val));
		} else {
			$arr[] = $val;
		}
	}
	return $arr;
	}
	//视频列表
	public function video_list(){
		if(IS_POST){
			$map['name'] = array("like","%{$_POST['name']}%");
			$class_cp = M('video')->where($map)->select();
			$this->assign('class_cp',$class_cp);
		}else{
			
			// $class = M('class')->where("pid={$_GET['id']}")->getField('id',true);
			// //var_dump($class);exit;
			// foreach($class as $k=>$v)
			// {
			// 	$son[] = M('class')->where("pid={$v}")->getField('id',true);
			// }
			// $arr = $this->arrToOne($son);
			// foreach( $arr as $k=>$v){  
			// if( !$v )  
			// 	unset( $arr[$k] );  
			// }
			// foreach($arr as $k=>$v)
			// {	
			// 	$list[] = M('video')->where("cid={$v}")->select();
			
			// }
			// foreach( $list as $k=>$v){  
			// if( !$v )  
			// 	unset( $list[$k] );  
			// }
			// $list = array_merge($list);
			// //var_dump($list);
			// $this->assign('list',$list);
			





			$class = M('class')->where("pid={$_GET['id']}")->getField('id',true);
			foreach($class as $k=>$v)
			{	
				$list[] = M('video')->where("cid={$v}")->select();
			
			}
			foreach($class as $k=>$v)
			{
				$son[] = M('class')->where("pid={$v}")->getField('id',true);
			}
			$arr = $this->arrToOne($son);
			foreach( $arr as $k=>$v){  
				if( !$v )  unset( $arr[$k] ); 
			}
			foreach($arr as $k=>$v)
			{	
				$list[] = M('video')->where("cid={$v}")->select();
			
			}
			foreach( $list as $k=>$v){  
				if( !$v )  unset( $list[$k] );
			}
			$list = array_merge($list);
			//var_dump($list);
			$this->assign('list',$list);
		}
		$this->display('');
	}
	//添加视频模板
	public function video_add(){
		if($_POST){
			$this->upload();
			//var_dump($_POST);exit;
			$data['cid'] = $_POST['cid'];
			$data['pic'] = $_POST['pic'];
			$data['video_link'] = $_POST['video_link'];
			$data['title'] = $_POST['title'];
			$data['content'] = $_POST['editorValue'];
			$data['addtime'] = strtotime($_POST['time']);
			$lastId=M('video')->add($data);
			if($lastId){
				$this->success('添加成功');
				return false;
			}else{
				$this->error('添加失败');
				return false;
			}
			
		}else{
			$class_cp = M('class')->where("pid={$_GET['id']}")->order('id asc')->select();
			$this->assign('class_cp',$class_cp);
		}
		$this->display('');
	}
	//删除视频
	public function del_video(){
		$model = M('video')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	//查看修改视频
	public function video_save(){
		if($_POST){
			$this->upload();
			$data['cid'] = $_POST['cid'];
			$data['addtime'] = strtotime($_POST['time']);
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}
			$data['video_link'] = $_POST['video_link'];
			$data['title'] = $_POST['title'];
			$data['content'] = $_POST['editorValue'];
			//var_dump($data);exit;
			$yes_or_no = M('video')->where("id={$_POST['id']}")->save($data);
			if($yes_or_no){
				$this->success('修改成功');
			}else{
				//$this->redirect("Index/article_list",array('id' => $_POST['cid']),3,"修改失败，页面跳转中...");
				$this->error('修改失败');
			}
		}else{
			$class_cp = M('class')->where("pid='2'")->select();
			$this->assign('class_cp',$class_cp);
			$class_jj = M('class')->where("pid='4'")->select();
			$this->assign('class_jj',$class_jj);
			$class_al = M('class')->where("pid='5'")->select();
			$this->assign('class_al',$class_al);
			$class_al = M('class')->where("pid='6'")->select();
			$this->assign('class_cloud',$class_cloud);
			$class_zx = M('class')->where("pid='7'")->select();
			$this->assign('class_zx',$class_zx);
			$class_zc = M('class')->where("pid='8'")->select();
			$this->assign('class_zc',$class_zc);
			$class_wm = M('class')->where("pid='9'")->select();
			$this->assign('class_wm',$class_wm);
			$article = M('article')->where("id={$_GET['id']}")->find();
			$this->assign('article',$article);
			$video = M('video')->where("id={$_GET['id']}")->find();
			$this->assign('video',$video);
		}
		$this->display('');
	}
	
	//图片上传
	private function upload(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/Uploads/video/'; // 设置附件上传根目录
		//$upload->savePath  =     $path; // 设置附件上传（子）目录
		$upload->autoSub  =      false; // 拒绝子目录创建
		// 上传文件 
		$info   =   $upload->upload();
		if(!$info) {// 上传错误提示错误信息
			//$this->error($upload->getError());
		}else{// 上传成功
			//获取图片的名称  
			$picname=$info['pic']['savename'];
		}
		$_POST['pic']=$picname;
		
	}
	
}