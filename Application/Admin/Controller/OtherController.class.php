<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\common;
class OtherController extends CommonController {
	public function aadd(){ 
		//给申请职位的人回复邮件
		$list = M('resume')->where("id={$_GET['id']}")->select();
		$email=$list[0]['email'];
		//将回复内容存在表中
		$data['comment']=$_POST['editorValue'];
		$res=M("resume")->where("id={$_GET['id']}")->save($data);
		//邮件回复在线交流
		if($_GET['onlineId']){
			$list = M('message')->where("id={$_GET['id']}")->select();
			//var_dump($list);exit;
			$email=$list[0]['email'];
			//var_dump($email);exit;
			$data['back']=$_POST['editorValue'];
			$res=M("message")->where("id={$_GET['id']}")->save($data);
		}

		$this->upload(); 
		$a = $this->think_send_mail($email,$_POST['name'],$_POST['title'],$_POST['editorValue'],$_POST['pic']);
		if(44){
			$this->success('发送成功！');
		}else{
			$this->error('发送失败'); 
		}
	}
	/**
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题 
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean 
 */
public function think_send_mail($to, $name, $subject, $body, $attachment = null){
	$config = C('THINK_EMAIL');
	vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
	vendor('PHPMailer.class#smtp'); //从PHPMailer目录导class.smtp.php类文件
	$mail             = new \PHPMailer(); //PHPMailer对象
	$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	$mail->IsSMTP();  // 设定使用SMTP服务
	$mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
											   // 1 = errors and messages
											   // 2 = messages only
	$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
	$mail->SMTPSecure = 'ssl';                 // 使用安全协议
	$mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
	$mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
	$mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
	$mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
	$mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
	$replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
	$replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
	$mail->AddReplyTo($replyEmail, $replyName);
	$mail->Subject    = $subject;
	$mail->MsgHTML($body);
	$mail->AddAddress($to);
	//$mail->AddAttachment('C:/wamp/www/danghongkeji/Public/file/'.$attachment);
	return $mail->Send() ? true : $mail->ErrorInfo;
}
	//图片上传
	private function upload(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		//$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->exts      =       array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		//$upload->rootPath  =     './Public/Uploads/'; // 设置附件上传根目录
		$upload->rootPath  =     './Public/Uploads/other/'; // 设置附件上传根目录
		//$upload->saveName  =     '';//设置文件命名规则
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
	
	//公司人员管理
	public function member_list(){
		$list = M('member')->order('num desc')->select();
		$this->assign('list',$list);
		$this->display('');
	}
	//修改公司人员排序
	public function member_order(){
		$data['num'] = $_POST['num'];
		M('member')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
	}
	//公司人员添加
	public function member_add(){
		if(IS_POST){
			$this->upload();
			$data['name'] = $_POST['name'];
			$data['job'] = $_POST['job'];
			$data['num'] = $_POST['num'];
			$data['content'] = $_POST['content'];
			$data['pic'] = $_POST['pic'];
			M('member')->add($data);
			$this->success('添加成功');
		}
		$this->display('');
	}
	//删除职员
	public function del_member(){
		$model = M('member')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	//修改职员信息
	public function member_save(){
		if($_POST){
			$this->upload();
			$data['name'] = $_POST['name'];
			$data['job'] = $_POST['job'];
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}
			$data['content'] = $_POST['editorValue'];
			$yes_or_no = M('member')->where("id={$_POST['id']}")->save($data);
			if($yes_or_no){
				$this->success('修改成功');
				return false;
			}else{
				$this->error('修改失败');
				return false;
			}
		}else{
			$job=M('member')->where("id={$_GET['id']}")->find();
			$this->assign("job",$job);
		}
		$this->display('');
	}
	
	//招聘信息
	public function recruit_list(){
		$list = M('recruit')->order("style")->select();
		$this->assign('list',$list);
		$this->display('');
	}
	//添加招聘信息
	public function recruit_add(){
		if($_POST){
			$data['title'] = $_POST['title'];
			$data['num'] = $_POST['num'];
			$data['pic'] = $_POST['pic'];
			$data['content'] = $_POST['editorValue'];
			$data['addtime'] = strtotime($_POST['time']);
			$lastId=M('recruit')->add($data);
				if($lastId){
					$this->success('添加成功');
					return false;
				}else{
					$this->error('添加失败');
					return false;
				}
		}

		$this->display('');
	}
   //修改招聘信息排序2017/4/19--郭添加
	public function recruit_order(){
		$data['ord'] = $_POST['ord'];
		M('recruit')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
	}
	//职位类型
	public function recruit_style(){
		$data['style'] = $_POST['style'];
		M('recruit')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
	}
	//删除招聘信息
		 public function del_recruit(){
		 	$model = M('recruit');
		 	$model->where("id={$_GET['id']}")->delete();
			if($model){
				$this->ajaxReturn('0');
			}else{
				$this->ajaxReturn('1');
			}

		 }
	//修改招聘信息
		public function recruit_save(){
			if($_POST){
				$this->upload();
				$data['title'] = $_POST['title'];
				$data['num'] = $_POST['num'];
				$data['content'] = $_POST['editorValue'];
				$data['addtime'] = strtotime($_POST['time']);
				$yes_or_no = M('recruit')->where("id={$_POST['id']}")->save($data);
				if($yes_or_no){
					$this->success('修改成功');
					return false;
				}else{
					$this->error('修改失败');
					return false;
				}
			}else{
				$recruit=M('recruit')->where("id={$_GET['id']}")->find();
				$this->assign("recruit",$recruit);
			}
			$this->display('');
		}
		
	//合作伙伴
	public function friend_list(){
		$friend = M('friend')->order("ord")->select();
		$this->assign('friend',$friend);
		$this->display();
	}
	//添加合作伙伴
	public function friend_add(){
		if($_POST){
			$this->upload();
			$data['name'] = $_POST['name'];
			$data['style'] = $_POST['style'];
			if($_POST['pic']){
				$data['logo'] = $_POST['pic'];
			}
			$data['link'] = $_POST['link'];
			$lastId=M('friend')->add($data);
			if($lastId){
				$this->success("添加成功");
				return false;
			}else{
				$this->error("添加失败");
				return false;
			}
		}
		$this->display('');
	}
	//调整合作伙伴顺序
	public function friend_order(){
		$data['ord'] = $_POST['order'];
		M('friend')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
	}
	//删除合作伙伴
	public function del_friend(){
		$model = M('friend')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	//修改合作伙伴
	public function friend_save(){
		if($_POST){
			$this->upload();
			$data['name'] = $_POST['name'];
			$data['style'] = $_POST['style'];
			$data['link'] = $_POST['link'];
			if($_POST['pic']){
				$data['logo'] = $_POST['pic'];
			}
			$yes_or_no = M('friend')->where("id={$_POST['id']}")->save($data);
			if($yes_or_no){
				$this->success('修改成功');
				return false;
			}else{
				$this->error('修改失败');
				return false;
			}
		}else{
			$friend=M('friend')->where("id={$_GET['id']}")->find();
			$this->assign("friend",$friend);
		}
		$this->display('');
	}


	//企业荣誉管理
	public function honor_list(){
		$list = M('honor')->order("ord")->select();
		$this->assign('list',$list);
		$this->display();
	}
	//企业荣誉添加
	public function honor_add(){
		if($_POST){
			$this->upload();
			$data['name'] = $_POST['name'];
			$data['pic'] = $_POST['pic'];
			$data['style'] = $_POST['style'];
			M('honor')->add($data);
			$this->success('添加成功');
			return false;
		}
		$this->display();
	}
	//调整栏目顺序2017/4/19--郭添加
	public function honor_order(){
		$data['ord'] = $_POST['order'];
		M('honor')->where("id={$_POST['id']}")->save($data);
		$this->success('修改成功');
	}
	//企业荣誉删除
	public function del_honor(){
		$model = M('honor')->where("id={$_GET['id']}")->delete();
		if($model){
			$this->ajaxReturn('0');
		}else{
			$this->ajaxReturn('1');
		}
	}
	//修改企业荣誉
	public function honor_save(){
		if($_POST){
			$this->upload();
			$data['name'] = $_POST['name'];
			$data['style'] = $_POST['style'];
			if($_POST['pic']){
				$data['pic'] = $_POST['pic'];
			}
			// var_dump($_POST);exit;
			$yes_or_no = M('honor')->where("id={$_POST['id']}")->save($data);
			if($yes_or_no){
				$this->success('修改成功');
				return false;
			}else{
				$this->error('修改失败');
				return false;
			}
		}else{
			$honor=M('honor')->where("id={$_GET['id']}")->find();
			$this->assign("honor",$honor);
		}
		$this->display('');
	}



	//企业介绍
	public function company_detail(){
		$detail = M('company')->order("updatetime desc")->find();
		$this->assign('detail',$detail);
		// var_dump($detail);return false;
		$this->display();

	} 
	//修改企业介绍
	public function company_update(){
		
		if($_POST){
			//$this->upload();
			$str=$_POST['editorValue'];
			preg_match_all("/<img.*>/", $str, $match);
			$data['title'] = $_POST['title'];
			$data['tel'] = $_POST['tel'];
			$data['tel2'] = $_POST['tel2'];
			$data['address'] = $_POST['address'];
			$data['address2'] = $_POST['address2'];
			$data['post'] = $_POST['post'];
			$data['www'] = $_POST['www'];
			$data['email'] = $_POST['email'];
			$data['content'] = $_POST['editorValue'];
			$data['map'] = $match[0][0];
			$data['updatetime'] = time();

			$detail = M('company')->order("updatetime desc")->find();
			$lastId=$detail['id'];
			$res=M("company")->where("id={$lastId}")->save($data);

			if($res){
				$this->success('修改成功');
				return false;
			}else{
				$this->success('修改失败');
				return false;
			}
			
		}
		$this->display();

	}
	//回复简历邮件
	public function article_add(){
		$this->assign("id" ,$_GET['id']);
		$this->assign("onlineId" ,$_GET['onlineId']);
		$this->display();
	}
	//简历下载
	public function file_down(){
		//下载文件存放位置
		$fileArr=M('resume')->where("id={$_GET['id']}")->find();
		$file_name= $fileArr['upfile'];
		$file_name=iconv("utf-8","gb2312//IGNORE",$file_name);//解决文件名中文问题
		$arr=explode('/', $_SERVER['SCRIPT_FILENAME']);
		array_pop($arr);
		$file_dir=implode("/", $arr);
		$file_dir=$file_dir."/Public/Uploads/resume/";
		//下载文件存放目录    
			if (!file_exists( $file_dir. $file_name )) { 
				header("Content-type: text/html; charset=utf-8");   
				 echo "File not found!";  
				  exit ();    
			} else {  
					 if( headers_sent() ) 
					    die('Headers Sent'); 
					  // Required for some browsers 
					  if(ini_get('zlib.output_compression')) 
					    ini_set('zlib.output_compression', 'Off'); 
					    // Parse Info / Get Extension 

					    $fsize = filesize( $file_dir. $file_name ); 
					    $path_parts = pathinfo( $file_dir. $file_name ); 
					    $ext = strtolower($path_parts["extension"]); 
					    // Determine Content Type 
					    switch ($ext) { 
					      case "pdf": $ctype="application/pdf"; break; 
					      case "exe": $ctype="application/octet-stream"; break; 
					      case "zip": $ctype="application/zip"; break; 
					      case "rar": $ctype="application/rar"; break; 
					      case "doc": $ctype="application/msword"; break; 
					      case "xls": $ctype="application/vnd.ms-excel"; break; 
					      case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
					      case "gif": $ctype="image/gif"; break; 
					      case "png": $ctype="image/png"; break; 
					      case "jpeg": 
					      case "jpg": $ctype="image/jpg"; break; 
					      default: $ctype="application/force-download"; 
					    } 
					    header("Pragma: public"); // required 
					    header("Expires: 0"); 
					    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
					    header("Cache-Control: private",false); // required for certain browsers 
					    header("Content-Type: $ctype"); 
					   	header("Content-Disposition: attachment; filename=". $fileArr['name']."__简历.".$ext .";" ); 
					    // header("Content-Disposition: attachment; filename=\"".basename( $file_dir. $file_name )."\";" ); 
					    header("Content-Transfer-Encoding: binary"); 
					    header("Content-Length: ".$fsize); 
					    ob_clean(); 
					    flush(); 
					    readfile( $file_dir. $file_name  );   
			 	} 
		}
		//简历信息
		public function  resume_list(){
			$list = M('resume')->select();
			$this->assign('list',$list);
			$this->display('');

		}
		//删除简历
		 public function del_resume(){
		 	$model = M('resume');
		 	$model->where("id={$_GET['id']}")->delete();
			if($model){
				$this->ajaxReturn('0');
			}else{
				$this->ajaxReturn('1');
			}

		 }
		 //回复在线交流信息
		 public function online_list(){
		 	$list=M("message")->select();
		 	$this->assign("list",$list);
		 	$this->display();
		 }
		 //删除在线交流留言信息
		 public function del_online(){
		 	$model = M('message');
		 	$model->where("id={$_GET['id']}")->delete();
			if($model){
				$this->ajaxReturn('0');
			}else{
				$this->ajaxReturn('1');
			}

		 }

		 //会员列表
		public function  user_list(){
			$list = M('user')->select();
			$this->assign('list',$list);
			// var_dump($list);
			$this->display('');
		}

		//删除会员
		 public function del_user(){
		 	$model = M('user')->where("id={$_GET['id']}")->delete();
			if($model){
				$this->ajaxReturn('0');
			}else{
				$this->ajaxReturn('1');
			}

		 }
		 //修改会员状态
		 public function save_state(){
		 	$data['state']=$_GET['state'];
		 	$res= M('user')->where("id={$_GET['id']}")->save($data);
			if($res){
				$this->success('修改会员状态成功');
			}else{
				$this->error('修改会员状态失败');
			}
		 }


}