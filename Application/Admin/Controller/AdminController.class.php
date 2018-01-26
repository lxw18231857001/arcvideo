<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\common;
class AdminController extends CommonController {
	
	//后台管理员管理
	public function admin_list(){
		if(!isset($_SESSION['adminuser'])){
			$this->redirect("Index/login");
		}
		$admin = M('admin')->select();
		$this->assign('admin',$admin);
		$this->display('');
	}
	
	//管理员添加
	public function admin_add(){
		if(IS_POST){
			$node= implode(',',$_POST['node']); 
			$data['name'] = $_POST['name'];
			$data['password'] = md5($_POST['password']);
			$data['node'] = $node;
			$model = M('admin')->add($data);
			if($model){
				$this->success('添加成功');
			}
		}else{
			$class = M('node')->where("controller='Class'")->select();
			$this->assign('class',$class);
			$article = M('node')->where("controller='Article'")->select();
			$this->assign('article',$article);
			$video = M('node')->where("controller='Video'")->select();
			$this->assign('video',$video);
			$admin = M('node')->where("controller='Admin'")->select();
			$this->assign('admin',$admin);
			$other = M('node')->where("controller='Other'")->select();
			$this->assign('other',$other);
			$index = M('node')->where("controller='Index'")->select();
			$this->assign('index',$index);
			$bak = M('node')->where("controller='Bak'")->select();
			$this->assign('bak',$bak);
			$this->display('');
		}
	}
	//修改管理员权限
	public function admin_save(){
		if(IS_POST){
			$adminName = M('admin')->where("id={$_POST['id']}")->find();
			// if($_POST['password']==null||$_POST['password']==''){
			// 	$this->error("密码不能为空！");
			// 	return false;
			// }elseif ($_POST['password']!=$adminName['password']) {
			// 	$this->error("账户名或密码输入错误！");
			// 	return false;
			// }
			$node= implode(',',$_POST['node']); 
			$data['name'] = $_POST['name'];
			//$data['password'] = $_POST['password'];
			$data['node'] = $node;
			$model = M('admin')->where("id={$_POST['id']}")->save($data);
			if($model){
				$this->success('修改成功');
				return false;
				}
		}else{
			$adminName = M('admin')->where("id={$_GET['id']}")->find();
			$this->assign('adminName',$adminName);
			$class = M('node')->where("controller='Class'")->select();
			$this->assign('class',$class);
			$article = M('node')->where("controller='Article'")->select();
			$this->assign('article',$article);
			$video = M('node')->where("controller='Video'")->select();
			$this->assign('video',$video);
			$admin = M('node')->where("controller='Admin'")->select();
			$this->assign('admin',$admin);
			$other = M('node')->where("controller='Other'")->select();
			$this->assign('other',$other);
			$index = M('node')->where("controller='Home'")->select();
			$this->assign('index',$index);
			$bak = M('node')->where("controller='Bak'")->select();
			$this->assign('bak',$bak);
		}
		$this->display('');
	}
	
	//修改管理员密码
	public function admin_change_pwd(){
		if(IS_POST){
				if(md5($_POST['newpwd'])==md5($_POST['checkpwd'])&&$_POST['newpwd']!=null&&$_POST['newpwd']!=''){
							$data['password'] = md5($_POST['newpwd']);
							$model = M('admin')->where("id={$_POST['id']}")->save($data);
							if($model){
								$this->success('修改成功');
								return false;
							}

				}else{
							$this->error("新密码为空或输入不一致！");
							return false;
				}
		}else{
			$adminName = M('admin')->where("id={$_GET['id']}")->find();
			$this->assign('adminName',$adminName);
		}
		
		$this->display('');
	}
	//删除管理员
	public function del_admin(){
		$model = M('admin')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	//节点列表
	public function node_list(){
		$list = M('node')->select();
		$this->assign('list',$list);
		$this->display('');
	}
	//添加节点
	public function node_add(){
		if(IS_POST){
			$data['name'] = $_POST['name'];
			$data['controller'] = $_POST['controller'];
			$data['function'] = $_POST['function'];
			$model = M('node')->add($data);
			if($model){
				$this->success('添加成功');
			}
		}
		$this->display('');
	}
	//删除节点
	public function node_del(){
		$model = M('node')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	
}