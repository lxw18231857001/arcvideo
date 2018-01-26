<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\common;
class CommonController extends Controller {
	//在Controller类中构造方法执行后则会自动调用的方法。
 	 public function _initialize(){
		//是否的登录验证
		if(empty($_SESSION['adminuser'])){
			$this->redirect("Index/login");
			exit();
		}

		//获取配置文件中的超级用户
		if(in_array($_SESSION['adminuser']['name'],C('SUPER_NAME'))){
			//如果登录用户是超级用户跳过权限验证
			return;
		}
		//权限验证
		//$nodelist = $_SESSION['adminuser']['node'];
		$controller = $_SESSION['adminuser']['controller'];
		$function = $_SESSION['adminuser']['function'];
		//var_dump($_SESSION['adminuser']);
		//获取当前用户访问的控制器和方法名
		$cname=strtolower(CONTROLLER_NAME);
		$fname=strtolower(ACTION_NAME);
		if(!in_array($cname,$controller) || !in_array($fname,$function)){
			echo "<script>alert('你没有执行此操作的权限');</script>";
			die;
		}
	}
}