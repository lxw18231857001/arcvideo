<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\common;
class ArticleController extends CommonController {
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
	//产品 解决方案之间推送
	public function form_add(){
		$data['aid'] = $_POST['aid'];
		$data['acid'] = $_POST['acid'];
		$data['cid'] = $_POST['cid'];
		//var_dump($data);//exit;
		if ($_POST['cid']=='') {
			echo "<script>alert('不能推送到顶级栏目，请推送到三级栏目！');window.history.go(-1);</script>";
		}else{
			$model = M('quick_three')->add($data);
			if($model){
			$this->success('添加成功');
			}
		}
		
	}
	//撤销相关产品的推送
	public function article_back(){
		//var_dump($_GET);exit;
		$res=M("quick_three")->where("cid={$_GET['cid']}")->delete();
		//$this->redirect("Article/article_list");
		echo "<script>alert('撤销推送成功！');window.history.go(-1);</script>";
	}
	//文章列表
	public function article_list(){
		if(IS_POST){
			$map['name'] = array("like","%{$_POST['name']}%");
			$class_cp = M('class')->where($map)->select();
			$this->assign('class_cp',$class_cp);
		}else{
			$tableId=$_GET['id'];
			if($_GET['id']==6){//后期开启当虹云时，去掉
				//echo "该功能暂未开通！";
				return false;
			}
			$class = M('class')->where("pid={$_GET['id']}")->getField('id',true);
			foreach($class as $k=>$v)
			{
				$son[] = M('class')->where("pid={$v}")->getField('id',true);
			}
			$arr = $this->arrToOne($son);
			foreach( $arr as $k=>$v){  
			if( !$v )  
				unset( $arr[$k] );  
			}

			// 缓存 2017729lxw
			// 初始化缓存
			// S(array('type'=>'xcache', 'prefix'=>'think','expire'=>60));

			//每个类时间倒序出
			foreach($arr as $k=>$v)
			{	
				if($tableId==2){
					$m=M('product');
					$list[] = $m->where("cid={$v}")->order('addtime desc')->select();
				}elseif($tableId==4){
					$m=M('solution');
					$list[] = $m->where("cid={$v}")->order('addtime desc')->select();
				}elseif($tableId==5){
					$m=M('success');
					$list[] =$m->where("cid={$v}")->order('addtime desc')->select();
				}elseif($tableId==6){
					$m=M('cloud');
					$list[] =$m->where("cid={$v}")->order('addtime desc')->select();
				}elseif($tableId==7){
					$m=M('article');
					$list[] = $m->where("cid={$v}")->order('addtime desc')->select();
				}elseif($tableId==8){
					$m=M('file_down');
					$list[] = $m->where("cid={$v}")->order('addtime desc')->select();
				}elseif($tableId==9){
					$m=M('about_us');
					$list[] = $m->where("cid={$v}")->order('addtime desc')->select();

				}
			}
			foreach( $list as $k=>$v){  
				if( !$v ) { 
					unset( $list[$k] ); 
				}
			}
			// $p=getpage($m,$where,10);//每页显示条数
			// $this->list=$list;
			// $page=$this->page=$p->show();
			
			$class_service=$_GET['id'];
			$list = array_merge($list);
			$this->assign('list',$list);
			//var_dump($list);
		}
			$class_cp = M('class')->where("pid='2'")->select();
			$this->assign('class_cp',$class_cp);
			$class_jj = M('class')->where("pid=4")->select();
			$this->assign('class_jj',$class_jj);
			$class_cg = M('class')->where("pid=5")->select();
			$this->assign('class_cg',$class_cg);
			$class_cloud = M('class')->where("pid='6'")->select();
			$this->assign('class_cloud',$class_cloud);
			$class_zx = M('class')->where("pid='7'")->select();
			$this->assign('class_zx',$class_zx);
			$class_zc = M('class')->where("pid='8'")->select();
			$this->assign('class_zc',$class_zc);
			$class_wm = M('class')->where("pid='9'")->select();
			$this->assign('class_wm',$class_wm);
		
		$this->assign('class_service',$class_service);
		$this->display('');
	}
	//添加文章模板
	public function article_add(){
		if($_POST){
			$this->upload();
			// var_dump($_POST);exit;
			$data['cid'] = $_POST['cid'];
			$data['pid']=M("class")->where("id={$_POST['cid']}")->getField('pid');
			$data['title'] = $_POST['title'];
			$data['pic'] = $_POST['pic'];
			$data['pic'] = $_POST['pic'];
			$data['content'] = $_POST['editor_arcticle'];
			$data['link'] = $_POST['link'];
			$data['addtime'] = strtotime($_POST['time']);
			// var_dump($data);exit;
			switch ($_GET['id']) {
					case '2':
					$lastId=M('product')->add($data);
					break;
					case '4':
					$lastId=M('solution')->add($data);
					break;
					case '5':
					$lastId=M('success')->add($data);
					break;
					case '6':
					$lastId=M('cloud')->add($data);
					break;
					case '7':
					$lastId=M('article')->add($data);
					break;
					case '8':
					$lastId=M('file_down')->add($data);
					break;
					case '9':
					$lastId=M('about_us')->add($data);
					break;
				default:
					echo "您的操作不合法！";
					break;
			}
			if($lastId){
				$this->success('添加成功');
				return false;
			}else{
				$this->error('添加失败');
				return false;
			}
		}else{
			$class_cp = M('class')->where("pid={$_GET['id']}")->order('id desc')->select();
			$this->assign('class_cp',$class_cp);
			$this->assign('getId',$_GET['id']);
		}
		$this->display('');
	}
	
	//删除文章
	public function del_article(){
		if(!isset($_SESSION['adminuser'])){
			$this->redirect("Index/login");
		}
		$pid=M("class")->where("id={$_GET['cid']}")->find();
		$arr=explode(',', $pid['path']);
		if($arr[1]==2){
			$model = M('product');
			$model->where("id={$_GET['id']}")->delete();
		}elseif($arr[1]==4) {
			$model = M('solution');
			$model->where("id={$_GET['id']}")->delete();
		}elseif($arr[1]==5) {
			$model = M('success');
			$model->where("id={$_GET['id']}")->delete();
		}elseif($arr[1]==6) {
			$model = M('cloud');
			$model->where("id={$_GET['id']}")->delete();
		}elseif($arr[1]==7) {
			$model = M('article');
			$model->where("id={$_GET['id']}")->delete();
		}elseif($arr[1]==8) {
			$model = M('file_down');
			$model->where("f_id={$_GET['id']}")->delete();
		}elseif($arr[1]==9) {
			$model = M('about_us');
			$model->where("id={$_GET['id']}")->delete();
		}
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	//查看修改文章
	public function article_save(){
		if($_POST){
			$this->upload();
			//var_dump($_POST);exit;
			$time = strtotime($_POST['time']);
			$data['cid'] = $_POST['cid'];
			$data['pid']=M("class")->where("id={$_POST['cid']}")->getField('pid');
			// $data['pid'] = M("class")->where("id={$_POST['cid']}")->getField("pid");
			$data['title'] = $_POST['title'];
			$data['content'] = $_POST['editor_arcticle'];
			$data['addtime'] = $time;
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}
			$data['link'] = $_POST['link'];
			//var_dump($data);exit;
			$pid=M("class")->where("id={$_POST['cid']}")->find();
			$arr=explode(',', $pid['path']);
			// var_dump($data);exit;
			if($arr[1]==2){
				$yes_or_no = M('product')->where("id={$_POST['id']}")->save($data);
			}elseif($arr[1]==4) {
				$yes_or_no = M('solution')->where("id={$_POST['id']}")->save($data);
			}elseif($arr[1]==5) {
				$yes_or_no = M('success')->where("id={$_POST['id']}")->save($data);
			}elseif($arr[1]==6) {
				$yes_or_no = M('cloud')->where("id={$_POST['id']}")->save($data);
			}elseif($arr[1]==7) {
				$yes_or_no = M('article')->where("id={$_POST['id']}")->save($data);
			}elseif($arr[1]==8) {
				$yes_or_no = M('file_down')->where("f_id={$_POST['id']}")->save($data);
			}elseif($arr[1]==9) {
				$yes_or_no = M('about_us')->where("id={$_POST['id']}")->save($data);
			}
			if($yes_or_no){
				//$this->redirect("Index/article_list",array('id' => $_POST['cid']),3,"修改成功，页面跳转中...");
				$this->success('修改成功');
				return false;
			}else{
				//$this->redirect("Index/article_list",array('id' => $_POST['cid']),3,"修改失败，页面跳转中...");
				$this->error('修改失败');
				return false;
			}
		}else{
			//显示内容
			$pid=M("class")->where("id={$_GET['cid']}")->find();
			$arr=explode(',', $pid['path']);
			if($arr[1]==2){
				$class_cp = M('product')->where("id={$_GET['id']}")->find();
				$this->assign('article',$class_cp);
			}elseif ($arr[1]==4) {
				$class_jj = M('solution')->where("id={$_GET['id']}")->find();
				$this->assign('article',$class_jj);
			}elseif ($arr[1]==5) {
				$class_al = M('success')->where("id={$_GET['id']}")->find();
				$this->assign('article',$class_al);
			}elseif ($arr[1]==6) {
				$class_cloud = M('cloud')->where("id={$_GET['id']}")->find();
				$this->assign('article',$class_cloud);
			}elseif ($arr[1]==7) {
				$class_zx = M('article')->where("id={$_GET['id']}")->find();
				$this->assign('article',$class_zx);
			}elseif ($arr[1]==8) {
				$class_zc = M('file_down')->where("f_id={$_GET['id']}")->find();
				$this->assign('article',$class_zc);
			}elseif ($arr[1]==9) {
				$class_wm = M('about_us')->where("id={$_GET['id']}")->find();
				$this->assign('article',$class_wm);
			}
			$this->assign('getId',$arr[1]);
			// $article = M('article')->where("id={$_GET['id']}")->find();
			// $this->assign('article',$article);
			//var_dump($class_cp);
			// 所属栏目列表
			$class_cp = M('class')->where("pid='2'")->select();
			$this->assign('class_cp',$class_cp);
			$class_jj = M('class')->where("pid='4'")->select();
			$this->assign('class_jj',$class_jj);
			$class_al = M('class')->where("pid='5'")->select();
			$this->assign('class_al',$class_al);
			$class_cloud = M('class')->where("pid='6'")->select();
			$this->assign('class_cloud',$class_cloud);
			$class_zx = M('class')->where("pid='7'")->select();
			$this->assign('class_zx',$class_zx);
			$class_zc = M('class')->where("pid='8'")->select();
			$this->assign('class_zc',$class_zc);
			$class_wm = M('class')->where("pid='9'")->select();
			$this->assign('class_wm',$class_wm);
		}
		$this->display('');
	}
	//修改文章点击量
	public function article_hits(){
		$data['hits'] = $_POST['hits'];
		M('article')->where("id={$_POST['id']}")->save($data);
		$this->redirect("Article/article_list",array('id' => $_POST['cid']),3,"修改成功，页面跳转中...");
	}
	//推荐新闻首页
	public function article_index(){
		//var_dump($_POST);
		$data['recommend'] = $_POST['recommend'];
		$res=M('article')->where("id={$_POST['id']}")->save($data);
		if($res==1){
			echo "<script>alert('推送修改成功！');window.history.go(-1);</script>";
		}else{
			echo "<script>alert('推送修改失败！');window.history.go(-1);</script>";
		}
		
	}
	
	//图片上传
	private function upload(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     12582912;// 设置附件上传大小3M
		$upload->exts      =     array('jpg','jpeg', 'gif', 'png', 'zip','rar','pdf','doc','docx','xls','xlsx','txt');// 设置附件上传类型
		$upload->rootPath  =     './Public/Uploads/content/'; // 设置附件上传根目录
		//$upload->savePath  =     $path; // 设置附件上传（子）目录
		$upload->autoSub  =      false; // 拒绝子目录创建
		// 上传文件 
		$info   =   $upload->upload();
		if(!$info) {// 上传错误提示错误信息
			//$this->error($upload->getError());
		}else{// 上传成功
			//获取图片的名称  
			$picname=$info['pic']['savename'];
			//$picname=$info['pdf']['savename'];
		}
		$_POST['pic']=$picname;
	}
	//上传附件 (word pdf zip rar)
	 // private function uploadPdf(){


	 // 	define ("filesplace","./");

		//  if (is_uploaded_file($_FILES['classnotes']['tmp_name'])) {

		//  if ($_FILES['classnotes']['type'] != "application/pdf") {
		//  echo "<p>请上传 PDF 格式的文件.</p>";
		//  } else {
		// 	 $name = $_POST['name'];
		// 	 $result = move_uploaded_file($_FILES['classnotes']['tmp_name'], filesplace."/$name.pdf");
		// 	 if ($result == 1) echo "<p>成功上传。</p>";
		// 	 else echo "<p>对不起，上传发生错误。 </p>";
		// } 
		//  } 


	 // 	$upload = new \Think\Upload();// 实例化上传类
		// $upload->maxSize   =     3145728 ;// 设置附件上传大小
		// $upload->exts      =     array('zip','rar');// 设置附件上传类型
		// $upload->rootPath  =     './Public/Uploads/'; // 设置附件上传根目录
		// //$upload->savePath  =     $path; // 设置附件上传（子）目录
		// $upload->autoSub  =      false; // 拒绝子目录创建
		// // 上传文件 
		// $info   =   $upload->upload();
		// if(!$info) {// 上传错误提示错误信息
		// 	//$this->error($upload->getError());
		// }else{// 上传成功
		// 	//获取图片的名称  
		// 	$pdfname=$info['pdf']['savename'];
		// }
		// $_POST['pdf']=$pdfname;

	 //}
}