<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\common;
class HomeController extends CommonController {
	
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
		$data['title'] = $_POST['title'];
		$data['stitle'] = $_POST['stitle'];
		$data['content'] = $_POST['editorValue'];
		if($_POST['pic']){
			$data['pic'] = $_POST['pic'];
		}
		$model = M('class')->add($data);
		if($model){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
    }
	//图片上传
	private function upload(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/Uploads/'; // 设置附件上传根目录
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
	
	//当虹云替换
	public function cloud(){
		//$logo = M('index')->where("label='cloud'")->getField('other');
		$cloud = M('index')->where("label='cloud'")->find();
		$this->assign('cloud',$cloud);
		if($_POST){
			$this->upload();
			if($_POST['pic']){
				$data['other'] = $_POST['pic'];
			}
			$data['link'] = $_POST['link'];
			$data['content'] = $_POST['content'];
			$data['label'] = 'cloud';
			if($cloud){
				M('index')->where("label='cloud'&&id={$cloud['id']}")->save($data);
				$this->success("添加成功！");exit;
			}else{
				$this->success("添加失败！");
			}
			
		}
		//	$this->redirect("Index/cloud");
		$this->display('');
	}
	
	//轮播图
	public function carousel(){
		$carousel_list = M('carousel')->order('ord')->select();
		$this->assign('carousel_list',$carousel_list);
		// var_dump($carousel_list);
		if($_POST){
			// $this->upload();
			// $arr=array_pop(explode('/', $_POST['link']));
			// $str=explode('.', $arr);
			// $res=in_array($str[1],  array('mp4','wmv','avi','mov','aiff' ,'viv  ','ram'));
			// if($res){
			// 	$data['pic'] = 0;
			// }else{
			// 	if($_POST['pic']){
			// 		$data['pic'] = $_POST['pic'];
			// 	}
			// }
			$data['title'] = $_POST['title'];
			$data['link'] = $_POST['link'];
			$data['content'] = $_POST['content'];
			$data['pic'] = $_POST['pic'];
			M('carousel')->add($data);
			$this->success('添加完成');
			return false;
		}
		$this->display('');
	}
	//轮播图用栏目添加
	public function carousel_cc(){
		$class = M('class')->where("id={$_POST['id']}")->find();
		$count = substr_count($class['path'],',');
		if($count == 1){
			$this->error('顶级栏目没有轮播图可选');
		}elseif($count == 2){
			$url = $this->class_url($_POST['id']);
			$link = $url.'?id='.$_POST['id'];
		}elseif($count == 3){
			$url = $this->get_class_url($class['pid']);
			$link = $url.'?id='.$_POST['id'].'&&pid='.$class['pid'];
		}
		$data['title'] = $class['title'];
		$data['content'] = $class['stitle'];
		$data['pic'] = $class['pic'];
		$data['link'] = $link;
		M('carousel')->add($data);
		$this->success('添加完成');
		$this->display('');
	}
	//轮播图添加模板
	public function carousel_add(){
		if($_GET['state']=='zz'){
			$this->display('carousel_zz');
		}elseif($_GET['state']=='cc'){
			$class_cp = M('class')->where("pid='2'")->select();
			$this->assign('class_cp',$class_cp);
			$class_jj = M('class')->where("pid='4'")->select();
			$this->assign('class_jj',$class_jj);
			$class_al = M('class')->where("pid='5'")->select();
			$this->assign('class_al',$class_al);
			$class_zx = M('class')->where("pid='7'")->select();
			$this->assign('class_zx',$class_zx);
			$class_zc = M('class')->where("pid='8'")->select();
			$this->assign('class_zc',$class_zc);
			$class_wm = M('class')->where("pid='9'")->select();
			$this->assign('class_wm',$class_wm);
			$this->display('carousel_cc');
		}
	}
	//查看修改轮播图
	public function carousel_save(){
		if($_POST){
			// lxw 20170809 全改为本地视频连接
			// $this->upload();
			// $arr=array_pop(explode('/', $_POST['link']));
			// $str=explode('.', $arr);
			// $res=in_array($str[1],  array('mp4','wmv','avi','mov','aiff' ,'viv  ','ram'));
			// if($res){
			// 	$data['pic'] = 0;
			// }else{
			// 	if($_POST['pic']){
			// 		$data['pic'] = $_POST['pic'];
			// 	}
			// }

			$data['title'] = $_POST['title'];
			$data['link'] = $_POST['link'];
			$data['content'] = $_POST['content'];
			$data['pic'] = $_POST['pic'];
			$yes_or_no = M('carousel')->where("id={$_POST['id']}")->save($data);
			if($yes_or_no){
				$this->success('修改成功');
				return false;
			}else{
				$this->error('修改失败');
				return false;
			}
		}else{
			$carousel = M('carousel')->where("id={$_GET['id']}")->find();
			$this->assign('carousel',$carousel);
		}
		$this->display('');
	}
	
	//调整轮播图顺序
	public function carousel_order(){
		$data['ord'] = $_POST['order'];
		M('carousel')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
	}
	//删除轮播图
	public function del_carousel(){
		$model = M('carousel')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}

	//删除主页的推送数据
	public function del_index(){
		$model = M('index')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	//首页新闻推送
	public function news_list(){
		if($_POST){
			$data['conid'] = $_POST['pid'];
			$data['label'] = 'news';
			$data['content'] = $_POST['content'];
			M('index')->add($data);
			$this->success('添加成功');
		}else{
			$class = M('class')->where("pid=25")->select();
			$this->assign('class',$class);
			$where['label'] = 'news';
			$list = M('index')->where($where)->select();
			$this->assign('list',$list);
			$this->display('');
		}
	}
	//首页新闻推荐
	public function index_order(){
		$data['ord'] = $_POST['order'];
		M('index')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
		return false;
	}
	//自定义首页产品推送
	public function quick_list(){
		$list = M('quick')->where("type='0'")->order('ord desc')->select();
		$this->assign('list',$list);
		//var_dump($list);
		$this->display('');
	}
	//自定义首页产品推送添加
	public function quick_add(){
		if($_POST){
			$link=array_pop(explode('/',$_POST['link'] ));
			$this->upload();
			$data['title'] = $_POST['title'];
			$data['link'] = $link;
			$data['content'] = $_POST['content'];
			$data['pic'] = $_POST['pic'];
			$data['type'] = $_POST['type'];
			M('quick')->add($data);
			$this->success('添加成功');
			return false;
		}
		$this->display();
	}
	//首页产品推送修改
	public function quick_save(){
		if($_POST){
			$this->upload();
			$link=array_pop(explode('/',$_POST['link'] ));
			$data['title'] = $_POST['title'];
			$data['link'] = $link;
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}
			$data['content'] = $_POST['content'];
			$data['type'] = $_POST['type'];
			$yes_or_no = M('quick')->where("id={$_POST['id']}")->save($data);
			if($yes_or_no){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else{
			$quick = M('quick')->where("id={$_GET['id']}")->find();
			$this->assign('quick',$quick);
		}
		$this->display('');
	}
	//首页产品推送删除
	public function del_quick(){
		$model = M('quick')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	//首页产品是否推送
	public function quick_order(){
		$data['ord'] = $_POST['order'];
		M('quick')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
		return false;
	}
	//视频入口
	public function quick_video(){
		$list = M('quick_video')->order('ord desc')->select();
		$this->assign('list',$list);
		$this->display('');
	}
	//视频入口添加
	public function quick_video_add(){
		if($_POST){
			$this->upload();
			$data['title'] = $_POST['title'];
			$data['link'] = $_POST['link'];
			$data['ord'] = $_POST['ord'];
			$data['pic'] = $_POST['pic'];
			$data['class'] = $_POST['class'];
			M('quick_video')->add($data);
			$this->success('添加成功');
		}else{
			$class_cp = M('class')->where("pid='2'")->select();
			$this->assign('class_cp',$class_cp);
			$class_jj = M('class')->where("pid='4'")->select();
			$this->assign('class_jj',$class_jj);
			$class_al = M('class')->where("pid='5'")->select();
			$this->assign('class_al',$class_al);
			$class_zx = M('class')->where("pid='7'")->select();
			$this->assign('class_zx',$class_zx);
			$class_zc = M('class')->where("pid='8'")->select();
			$this->assign('class_zc',$class_zc);
			$class_wm = M('class')->where("pid='9'")->select();
			$this->assign('class_wm',$class_wm);
		}
		$this->display();
	}
	//视频入口删除
	public function del_quick_video(){
		$model = M('quick_video')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	
	//从数据库选择产品 方案作为快捷入口
	public function quick_choice(){
		if($_POST){
		//var_dump($_POST);exit;
			$fid=M("class")->where("id={$_POST['id']}")->find();
			$path=explode(',', $fid['path']);
			if($path[1]==2){
				$article = M('product')->where("cid={$_POST['id']}")->find();
			}else{
				$article = M('solution')->where("cid={$_POST['id']}")->find();
			}
			if($article==null){
				//echo "<script>alert('选择的栏目内容为空，添加内容后才能推送！');window.history.go(-1);</script>";
				$this->error('选择的栏目内容为空，添加内容后才能推送！','',1);
			}
			$arr = M('class')->getField('id,pid',true);
			$id = $article['cid'];
			$pid = $arr[$id];
			$url = $this->get_class_url($pid);
			$link = $url.'?id='.$id.'&&pid='.$pid;

			$data['title'] = $article['title'];
			$data['pic'] = $article['pic'];
			$data['content'] = I('post.content');
			$data['link'] = $link;
			$data['type'] = '0';
			M('quick')->add($data);
			$this->success('添加成功');
			return false;
		}
		$class_cp = M('class')->where("pid='2'")->select();
		$this->assign('class_cp',$class_cp);
		$class_jj = M('class')->where("pid='4'")->select();
		$this->assign('class_jj',$class_jj);
		$this->display('');
	}
	//从数据库选择 案例推送
	public function quick_al_choice(){
		if($_POST){
		//var_dump($_POST);exit;
			$article = M('success')->where("cid={$_POST['id']}")->find();
			if($article==null){
				//echo "<script>alert('选择的栏目内容为空，添加内容后才能推送！');window.history.go(-1);</script>";
				$this->error('选择的栏目内容为空，添加内容后才能推送！','',1);
			}
			$arr = M('class')->getField('id,pid',true);
			$id = $article['cid'];
			$pid = $arr[$id];
			$url = $this->get_class_url($pid);
			$link = $url.'?id='.$id.'&&pid='.$pid;
			$data['title'] = $article['title'];
			$data['pic'] = $article['pic'];
			$data['content'] = I('post.content');
			$data['link'] = $link;
			$data['type'] = '1';
			M('quick')->add($data);
			$this->success('添加成功');
			return false;
		}
		$class_al = M('class')->where("pid='5'")->select();
		$this->assign('class_al',$class_al);
		$this->display('');
	}
	
	
	//案例添加
	public function quick_al_add(){
		if($_POST){
			$this->upload();
			$link=array_pop(explode('/',$_POST['link'] ));
			$data['title']=$_POST['title'];
			$data['link']=$link;
			$data['content']=$_POST['content'];
			$data['pic']=$_POST['pic'];
			$data['type'] = '1';
			$res=M('quick')->add($data);
			if($res){
				$this->success('添加成功');return false;
			}else{
				$this->error('添加失败！');return false;
			}
			
		}
		$this->display('');
	}
	//案例修改
	public function quick_al_save(){
		if($_POST){
			$this->upload();
			$link=array_pop(explode('/',$_POST['link'] ));
			$data['title'] = $_POST['title'];
			$data['link'] = $link;
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}
			$data['content'] = $_POST['content'];
			$data['type'] = 1;
			$yes_or_no = M('quick')->where("id={$_POST['id']}")->save($data);
			if($yes_or_no){
				$this->success('修改成功');
			}else{
				$this->error('修改失败');
			}
		}else{
			$quick = M('quick')->where("id={$_GET['id']}")->find();
			$this->assign('quick',$quick);
		}
		$this->display('');
	}
	//案例入口
	public function quick_al(){
		$list = M('quick')->where("type='1'")->order('ord desc')->select();
		$this->assign('list',$list);
		$this->display('');
	}
	//获得分类的url
	public function get_class_url($id){
		$pid = M('class')->where("id={$id}")->getField('pid');
		if($pid == '2'){
			$return = 'products_view';
		}elseif($pid == '4'){
			$return = 'solutions_view';
		}elseif($pid == '5'){
			$return = 'case_class';
		}elseif($pid == '6'){
			$return = 'cloud';
		}elseif($pid == '7'){
			$return = 'news_class';
		}elseif($pid == '8'){
			$return = 'service';
		}elseif($pid == '9'){
			if($id == '30'){
				$return = 'about_us';
			}elseif($id == '31'){
				$return = 'honor';
			}elseif($id == '32'){
				$return = 'team';
			}elseif($id == '33'){
				$return = 'rec';
			}
		}
		return $return;
	}
	//分类跳转模板
	function class_url($id){
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
			$return = 'service';
		}elseif($pid == '9'){
			if($id == '30'){
				$return = 'about_us';
			}elseif($id == '31'){
				$return = 'honor';
			}elseif($id == '32'){
				$return = 'team';
			}elseif($id == '33'){
				$return = 'rec';
			}
		}
		return $return;
	}
}