<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\common;
class IndexController extends Controller {
	
	
	//首页
    public function index(){
		if(!isset($_SESSION['adminuser'])){
			$this->redirect("Index/login");
		}
		$server_name=$_SERVER['SERVER_NAME'];
		$this->assign('server_name',$server_name);
		$class_list = M('class')->where("pid=0")->select();
		$this->assign('class_list',$class_list);
		$this->display('');
    } 
	
	//退出
	public function session_del(){
		session_unset();
		session_destroy();
		$this->redirect("Index/login");
	}
	//系统信息
	public function welcome(){
		$info = array(
			'操作系统'=>PHP_OS,
			'运行环境'=>$_SERVER["SERVER_SOFTWARE"],
			'主机名'=>$_SERVER['SERVER_NAME'],
			'WEB服务端口'=>$_SERVER['SERVER_PORT'],
			'网站文档目录'=>$_SERVER["DOCUMENT_ROOT"],
			'浏览器信息'=>substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
			'通信协议'=>$_SERVER['SERVER_PROTOCOL'],
			'请求方法'=>$_SERVER['REQUEST_METHOD'],
			'ThinkPHP版本'=>THINK_VERSION,
			'上传附件限制'=>ini_get('upload_max_filesize'),
			'执行时间限制'=>ini_get('max_execution_time').'秒',
			'服务器时间'=>date("Y年n月j日 H:i:s"),
			'北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
			'服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
			'用户的IP地址'=>$_SERVER['REMOTE_ADDR'],
			'剩余空间'=>round((disk_free_space(".")/(1024*1024)),2).'M',
		);
		$this->info=$info;
		//$this->buildHtml('1.html',HTML_PATH.'/','welcome','utf8',$contentType='text/html');
		$this->display('');
	}
	//验证登录
	public function check(){
		$name	  = I('name');
		$password = I('password');
		//验证账号//lxw 禁用admin
		//  if(in_array($name,C('SUPER_NAME'))){
		// 	$this->supper();
		// }
		$res = M('admin')->where("name='{$name}' and state='0'")->find();
		if($res){
			//验证密码
			if($res['password']==md5($password)){
				if($res['node']){
					$array = array();
					$b=explode(',',$res['node']);
					foreach ($b as $key => $value) {
						$array[] = M('node')->where("id={$value}")->getField('controller,function');
					}
					$kk = array();
					$vv = array();
					foreach($array as $key => $value){
						foreach($value as $k => $v){
							$kk[] = $k;
							$vv[] = $v;
						}
					}
				}
				//$arr = array_merge($kk,$vv);
				$res['controller']=$kk;
				$res['function']=$vv;
				$res['node']=$array;
				//用户信息存入session
				$_SESSION['adminuser']=$res;
				$this->redirect("Index/index");
			}else{
				// $this->error('密码错误');
				$this->redirect("Index/errorpwd");
			}
		}else{
			// $this->error('用户不存在');
			// echo  "<script>alert('用户不存在！');window.history.go(-1);</script>";
			$this->redirect("Index/notexist");
		}
	}
	
	// admin管理员可以获得所有控制器的权限--禁用20170523lxw
	public function supper(){
		$res = M('admin')->find();
			if($res['node']){
				$array = array();
				$b=explode(',',$res['node']);
				foreach ($b as $key => $value) {
					$array[] = M('node')->where("id={$value}")->getField('controller,function');
				}
				$kk = array();
				$vv = array();
				foreach($array as $key => $value){
					foreach($value as $k => $v){
						$kk[] = $k;
						$vv[] = $v;
					}
				}
			}
			//$arr = array_merge($kk,$vv);
			$res['controller']=$kk;
			$res['function']=$vv;
			$res['node']=$array;
			//用户信息存入session
			$_SESSION['adminuser']=$res;
			$this->redirect("Index/index");
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
		$data['title'] = $_POST['title'];
		$data['stitle'] = $_POST['stitle'];
		$data['content'] = $_POST['editorValue'];
		$data['pic'] = $_POST['pic'];
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
		$upload->rootPath  =     './Public/Uploads/index/'; // 设置附件上传根目录
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
		$logo = M('index')->where("label='cloud'")->getField('other');
		$this->assign('logo',$logo);
		if($_POST){
			$this->upload();
			if($_POST['pic']){
				$data['other'] = $_POST['pic'];
			}
			$data['content'] = $_POST['content'];
			$data['label'] = 'cloud';
			if($logo){
				M('index')->where("label='cloud'")->save($data);
			}else{
				M('index')->add($data);
			}
			$this->redirect("Index/cloud");
		}
		$this->display('');
	}
	
	//轮播图
	public function carousel(){
		$carousel_list = M('carousel')->order('ord')->select();
		$this->assign('carousel_list',$carousel_list);
		if($_POST){
			$this->upload();
			$data['title'] = $_POST['title'];
			if($_POST['pic']){
			$data['pic'] = $_POST['pic'];
			}
			
			$data['content'] = $_POST['content'];
			$data['link'] = $_POST['link'];
			M('carousel')->add($data);
			$this->success('添加完成');
		}
		$this->display('');
	}
	//轮播图用栏目添加
	public function carousel_cc(){
		$class = M('class')->where("id={$_POST['id']}")->find();
		$data['title'] = $class['title'];
		$data['content'] = $class['stitle'];
		$data['pic'] = $class['pic'];
		$data['link'] = $_POST['link'];
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
			$class_jj = M('class')->where("pid='5'")->select();
			$this->assign('class_jj',$class_jj);
			$class_al = M('class')->where("pid='6'")->select();
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
	//快捷入口
	public function quick_list(){
		$list = M('quick')->order('ord desc')->select();
		$this->assign('list',$list);
		$this->display('');
	}
	//快捷入口添加
	public function quick_add(){
		if($_POST){
			$this->upload();
			$data['title'] = $_POST['title'];
			$data['link'] = $_POST['link'];
			$data['ord'] = $_POST['ord'];
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}
			$data['content'] = $_POST['content'];
			M('quick')->add($data);
			$this->success('添加成功');
		}
		$this->display();
	}
	//快捷入口删除
	public function del_quick(){
		$model = M('quick')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	//调整快捷入口顺序
	public function quick_order(){
		$data['ord'] = $_POST['order'];
		M('quick')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
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
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}
			$data['class'] = $_POST['class'];
			M('quick_video')->add($data);
			$this->success('添加成功');
		}else{
			$class_cp = M('class')->where("pid='2'")->select();
			$this->assign('class_cp',$class_cp);
			$class_jj = M('class')->where("pid='5'")->select();
			$this->assign('class_jj',$class_jj);
			$class_al = M('class')->where("pid='6'")->select();
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
	
	//从数据库选择文章作为快捷入口
	public function quick_choice(){
		if($_POST){
			$article = M('article')->where("id={$_POST['id']}")->find();
			$arr = M('class')->getField('id,pid',true);
			$id = $article['cid'];
			while($arr[$id]) {
			  $id = $arr[$id];
			}
			$data['title'] = $article['title'];
			$data['pic'] = $article['pic'];
			$data['content'] = $article['content'];
			$data['link'] = $article['link'];
			M('quick')->add($data);
			$this->success('添加成功');
		}
		$class_cp = M('class')->where("pid='2'")->select();
		$this->assign('class_cp',$class_cp);
		$class_jj = M('class')->where("pid='5'")->select();
		$this->assign('class_jj',$class_jj);
		$this->display('');
	}
}