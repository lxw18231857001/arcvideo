<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\common;
class ClassController extends CommonController {
	
	//分类页
    public function class_list(){
		if($_GET['id']){
			$_SESSION['classid']=$_GET['id'];
		}
		if(IS_POST){
			$map['name'] = array("like","%{$_POST['name']}%");
			$class_cp = M('class')->where($map)->select();
			$this->assign('class_cp',$class_cp);

		}else{
			$class_cp = M('class')->where("pid={$_SESSION['classid']}")->order('ord asc')->select();
			// $class_son = M('class')->where("pid={$_SESSION['classid']} && ")->order('ord2 asc')->select();
			// var_dump($class_cp);
			$this->assign('class_cp',$class_cp);
			$class = M('class')->where("id={$_SESSION['classid']}")->find();
			$this->assign('class',$class);
		}

		$this->display('');
    } 
	//数据类别添加模板
	public function class_add(){
		if($_GET['id']){
			$_SESSION['classid']=$_GET['id'];
		}
		if($_POST){
			$this->insert_class();
		}else{
			$class_cp = M('class')->where("id={$_SESSION['classid']} OR pid={$_SESSION['classid']}")->order('id asc')->select();
			$this->assign('class_cp',$class_cp);
		}
		$this->display('');
	}
	//数据类别修改模板
	public function class_save(){
		if(!isset($_SESSION['adminuser'])){
			$this->redirect("Index/login");
		}
		$id = I('id');
		if($_POST){
			if($_POST['pid']>0){
				//查找父类别信息
				$vo = M("class")->find($_POST['pid']);
				$path = $vo['path'].$vo['id'].",";
				$pid = $vo['id'];
			}else{
				$path = "0,";
				$pid = 0;
			}
			$this->upload();
			$data['path'] = $path;
			$data['pid'] = $pid;
			$data['name'] = $_POST['name'];
			$data['title'] = $_POST['title'];
			$data['stitle'] = $_POST['stitle'];
			$data['content'] = $_POST['editorValue'];
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}
			$save = M('class')->where("id={$id}")->save($data);
			$this->success('修改成功');
		}else{
			$gg = M('class')->where("id={$id}")->find();
			$this->assign('gg',$gg);
			$count = substr_count($gg['path'],',');
			$this->assign('count',$count);
			$class = M('class')->where("pid=0")->select();
			$this->assign('class',$class);

		}
		$this->display('');
	}
	//调整栏目顺序2017/4/19--郭添加
	public function class_order(){
		$data['ord'] = $_POST['order'];
		M('class')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
	}
	//调整子栏目顺序具体产品、案例
	public function class_order_son(){
		$data['ord2'] = $_POST['ord2'];
		M('class')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
	}
	//删除分类
	public function del_class(){
		if(!isset($_SESSION['adminuser'])){
			$this->redirect("Index/login");
		}
		$model = M('class');
		$model->where("id={$_GET['id']}")->delete();
		$class = $model->where("pid={$_GET['id']}")->select();
		foreach($class as $value){
			$model->where("id={$value['id']}")->delete();
		}
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
		//$this->redirect("Index/picture_class");
	}
	//自定义添加
	 public function insert_class(){
		if(!isset($_SESSION['adminuser'])){
			$this->redirect("Index/login");
		}
        if($_POST['pid']>0){
            //查找父类别信息
            $vo = M("class")->find($_POST['pid']);
            $path = $vo['path'].$vo['id'].",";
            $pid = $vo['id'];
		}else{
			$path = "0,";
            $pid = 0;
		}
		$this->upload();
		$data['path'] = $path;
		$data['pid'] = $pid;
		$data['name'] = $_POST['name'];
		
		// $data['stitle'] = $_POST['stitle'];
		$data['content'] = $_POST['editorValue'];
		$count=substr_count($data['path'],',');
		 if($count==2){
		 	$data['pic'] = $_POST['pic'];
		 	$data['title'] = $_POST['title'];
		 }
		//var_dump($data);exit;
		if($data['name']!=null){
			$model = M('class')->add($data);
		}
		
		if($model){
			 	$this->success('添加成功');
				return false;
		}else{
			$this->error('添加失败,栏目名称不能为空');
			return false;
		}
    }
	//图片上传
	private function upload(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/Uploads/class/'; // 设置附件上传根目录
		//$upload->savePath  =     $path; // 设置附件上传（子）目录
		$upload->autoSub  =      false; // 拒绝子目录创建
		// 上传文件 
		$info   =   $upload->upload();
		if(!$info) {// 上传错误提示错误信息
			// $this->error($upload->getError());
		}else{// 上传成功
			//获取图片的名称  
			$picname=$info['pic']['savename'];
		}
		$_POST['pic']=$picname;
		
	}
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

	// 主导航列表
	public function class_navigation() 
	{
	$navList = M('class')->where("pid='0'")->select();
	// var_dump($navList);
	$this->assign("navList",$navList);
	$this->display();
	}
	// 修改主导航链接
	public function class_navigation_save() 
	{
		// var_dump($_POST);exit;
		$data['link']=$_POST['link'];
	$res = M('class')->where("id={$_POST['id']}")->save($data);
	// var_dump($navList);
	if($res){
		$this->success("修改主导航链接成功！");
		return false;
	}else{
		$this->error("修改主导航链接失败！");
		return false;
	}
	}
	
}