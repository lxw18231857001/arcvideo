<?php
//类别信息控制器
namespace Admin\Controller;
use Think\Controller;
class BakController extends CommonController {
	//所有表的信息
	public function index()
	{
		$dbName=C('DB_NAME');
		$re=M()->query('SHOW TABLE STATUS FROM '.$dbName);
		$this->assign("re",$re);
		$this->display();
	}
	//备份数据表
	public function back()
	{	
		// var_dump($_POST);exit;
		 if(empty($_POST['tablearr']))

		 {
		 	echo "<script>alert('请选择要备份的数据表！');javascript:window.history.go(-1);</script>";
		 	//$this->redirect("Bak/index",'',1,'请选择要备份的数据表！');
			//$table=$this->getTable();
		 }else

		 {

		$table=explode(",",$_POST['tablearr']);

		 }

		 $struct=$this->bakStruct($table);
		 $record=$this->bakRecord($table);
		 $sqls=$struct.$record;
		 // var_dump($record);exit;

		 $arr=explode('/', $_SERVER['SCRIPT_FILENAME']);
		 array_pop($arr);
		 $dir=implode('/',$arr);
		 $dir=$dir."/Public/Sql/".date("y_m_d").".sql";
		 // $dir="C:/wamp/www/danghongkeji/Public/Sql/".date("y_m_d").".sql";
		$_SESSION['dir']=$dir;

		
		// var_dump($dir);exit;
		 file_put_contents($dir,$sqls);

		 if(file_exists($dir))

		 {

		$this->success("备份成功");

		 }else

		 {

		$this->error("备份失败");

		 }

	}

	//导出数据库到本地
	public function download(){
		//下载文件存放位置
		$filename=array_pop(explode('/', $_SESSION['dir']));
		$filepath=$_SESSION['dir'];
		
		//下载文件存放目录    
			if (!file_exists( $filepath )) { 
				header("Content-type: text/html; charset=utf-8");   
				 echo "File not found!";  
				  exit ();    
			} else {  
					 if( headers_sent() ) 
					    die('Headers Sent'); 
					  // Required for some browsers 
					  if(ini_get('zlib.output_compression')) 
					    ini_set('zlib.output_compression', 'Off'); 

					    $fsize = filesize( $filepath ); 
					    $path_parts = pathinfo( $filepath ); 
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
					   	header("Content-Disposition: attachment; filename=". $filename .";" ); 
					    header("Content-Transfer-Encoding: binary"); 
					    header("Content-Length: ".$fsize); 
					    ob_clean(); 
					    flush(); 
					    readfile( $filepath  );   
			 	} 
	}

	 //

	// protected function getTable()

	// {

	// 	 $dbName=C('DB_NAME');

	// 	 $result=M()->query('show tables from '.$dbName);
	// 	// var_dump($result);exit;

	// 	 foreach ($result as $v){
	// 	 	//var_dump($v);exit;
	// 	$tbArray[]=$v['Tables_in_'.C('DB_NAME')];

	// 	 }

	// 	 return $tbArray;

	// }

	 
	//数据表结构
	protected function bakStruct($array)

	{

	 foreach ($array as $v){

	  $tbName=$v;

	  $result=M()->query('show columns from '.$tbName);
//var_dump($result);exit;
	  $sql.="--\r\n";

	  $sql.="-- 数据表结构: `$tbName`\r\n";

	  $sql.="--\r\n\r\n";

	  $sql.="DROP TABLE IF EXISTS `$tbName`;\r\n";

	  $sql.="create table `$tbName` (\r\n";

	  $rsCount=count($result);

	  foreach ($result as $k=>$v){

	  $field  =       $v['Field'];

	  $type   =       $v['Type'];

	  $default=       $v['Default'];

	  $extra  =       $v['Extra'];

	  $null   =       $v['Null'];

	if(!($default=='')){

	 $default='default '.$default;
//var_dump($default);exit;
	}      

	  if($null=='NO'){

	  $null='not null';

	  }else{

	  $null="null";

	  }          

	  if($v['Key']=='PRI'){

	  $key    =       'primary key';

	  }else{

	  $key    =       '';

	  }

	if($k<($rsCount-1)){

	 $sql.="`$field` $type $null $default $key $extra ,\r\n";

	}else{

	 //最后一条不需要","号

	 $sql.="`$field` $type $null $default $key $extra \r\n";

	}



	  }

	  $sql.=") ENGINE=MyISAM DEFAULT CHARSET=utf8;\r\n\r\n";

	 }

	 return str_replace(',)',')',$sql);

	}

	 
	//数据表中数据
	protected function bakRecord($array)

	{


	foreach ($array as $v){

	 

	  $tbName=$v;

	 

	 $rs=M()->query('select * from '.$tbName);


	 if(count($rs)<=0){

	 continue;

	 }


	  $sql.="--\r\n";

	  $sql.="-- 数据表中的数据: `$tbName`\r\n";

	  $sql.="--\r\n\r\n";


	 foreach ($rs as $k=>$v){


	 $sql.="INSERT INTO `$tbName` VALUES (";

	  foreach ($v as $key=>$value){

	  if($value==''){

	  $value='null';

	  }

	  $type=gettype($value);

	  if($type=='string'){

	  $value="'".addslashes($value)."'";

	  }

	  $sql.="$value," ;

	  }

	  $sql.=");\r\n\r\n";

	}

	 }
	 $sql = str_replace(',)',')',$sql);
	 return $sql;

	}

	//执行 优化 修复 结构 操作
	public function click()

	{	//echo $_GET['zhi'];exit;
		$url=explode("&",$_GET['zhi']);
		
		$do=$url[0];

		$table=$url[1];

		switch($do)

		{

		case optimize://优化

		$rs =M()->Query("OPTIMIZE TABLE `$table` ");
		if($rs)

		{

		echo "执行优化表： $table  OK！";

		}

		else

		{

		echo "执行优化表： $table  失败，原因是：".M()->GetError();

		}

		break;

		case repair://修复

		$rs = M()->Query("REPAIR TABLE `$table` ");
		if($rs)

		{

		echo "修复表： $table  OK！";

		}

		else

		{

		echo "修复表： $table  失败，原因是：".M()->GetError();

		}

		break;

		default://结构

		$dsql=M()->Query("SHOW CREATE TABLE ".$table);

		foreach($dsql as $k=>$v)

		{

		foreach($v as $k1=>$v1)

		{

		$rs=$v1;

		}

		}

		echo trim($rs);

		}

	}
	
	//系统设置
	public function system_base(){
		if(IS_POST){
			$data['name'] = $_POST['name'];
			$data['key'] = $_POST['key'];
			$data['describe'] = $_POST['describe'];
			$data['copyright'] = $_POST['copyright'];
			$data['record_number'] = $_POST['record_number'];
			$yes_or_no = M('system')->where("id='1'")->save($data);
			$this->success('修改成功');
		}else{
			$system = M('system')->where("id='1'")->find();
			$this->assign('system',$system);
		}
		$this->display('system-base');
	}
	//logo替换
	public function logo(){
		if(IS_POST){
			$this->upload();
			// var_dump($_POST);
			if($_POST['pic']){
				$data['other'] = $_POST['pic'];
			}
			$data['label'] = 'logo';
			M('index')->where("label='logo'")->save($data);
			$this->success('修改成功');
			return false;
		}
		$logo = M('index')->where("label='logo'")->getField('other');
		$this->assign('logo',$logo);
		$this->display('');
	}

	//整站查找
	public function search(){
		// var_dump($_POST['title']);
		$_POST['title']=trim($_POST['title']);
		if($_POST['title']===null||$_POST['title']===''){
			
		}else{
			// $m=M("article");
			$_SESSION['title']=$_POST['title'];
			$where['title|content'] = array("like","%".$_POST['title']."%");
			
			$kyw=explode('%', $where['title|content'][1])[1];
			$productList=M("product")->where($where)->order('addtime desc')->select();
			$solutionList=M("solution")->where($where)->order('addtime desc')->select();
			$successList=M("success")->where($where)->order('addtime desc')->select();
			$newsList=M("article")->where($where)->order('addtime desc')->select();
			$mergeArr=array_merge($newsList,$productList,$solutionList,$successList);

			// 二三级页面上半部分
			$map['title|content|name']=array("like","%".$_POST['title']."%");
			$kyw2=explode('%', $where['title|content|name'][1])[1];
			$classList=M("class")->where($map)->order()->select();
		// var_dump($classList);exit;
		// var_dump($mergeArr);exit;
		// $res=M("class")->getLastSql();
		// echo $res;exit;
			foreach($mergeArr as $v){
				$v['title']=preg_replace("/($kyw)/i","<b style='color:red'>\\1</b>",$v['title']);
				$sear[]=$v;
			}
			// foreach($classList as $v){
			// 	// $v['title']=preg_replace("/($kyw2)/i","<b style='color:red'>\\1</b>",$v['title']);
			// 	$sear2[]=$v;
			// }
				// $v['title']=preg_replace("/($kyw2)/i","<b style='color:red'>\\1</b>",$v['title']);
			$this->assign('mergeArr',$sear);
			$this->assign('classArr',$classList);
		}

		$this->display('');
	}


	//整站替换
	public function replace(){
		// var_dump($_SESSION);exit();
		// var_dump($_POST['tablearr']);
		// var_dump($_POST['tablearr_class']);exit;
		// var_dump($_POST);exit;
		$_POST['replace']=trim($_POST['replace']);
		$tableArr=explode(',',$_POST['tablearr'] );
		foreach ($tableArr as  $k=> $v) {
			$idArr=explode('-',$v);
			// var_dump($idArr);exit;
			switch ($idArr['1']) {
				case '2':
					$content =M("product")->where("id={$idArr['0']}")->getField("content");
					$newContent=str_replace($_SESSION['title'], $_POST['replace'], $content,$count);
					$title =M("product")->where("id={$idArr['0']}")->getField("title");
					$newTitle=str_replace($_SESSION['title'], $_POST['replace'], $title,$count);
					
					$data['title']=$newTitle;
					$data['content']=$newContent;
					$res=M("product")->where("id='{$idArr['0']}'")->save($data);
					break;
				case '4':
					$content =M("solution")->where("id={$idArr['0']}")->getField("content");
					$newContent=str_replace($_SESSION['title'], $_POST['replace'], $content,$count);
					$title =M("solution")->where("id={$idArr['0']}")->getField("title");
					$newTitle=str_replace($_SESSION['title'], $_POST['replace'], $title,$count);
					
					$data['title']=$newTitle;
					$data['content']=$newContent;
					$res=M("solution")->where("id='{$idArr['0']}'")->save($data);
					break;
				case '5':
					$content =M("success")->where("id={$idArr['0']}")->getField("content");
					$newContent=str_replace($_SESSION['title'], $_POST['replace'], $content,$count);
					$title =M("success")->where("id={$idArr['0']}")->getField("title");
					$newTitle=str_replace($_SESSION['title'], $_POST['replace'], $title,$count);
					
					$data['title']=$newTitle;
					$data['content']=$newContent;
					$res=M("success")->where("id='{$idArr['0']}'")->save($data);
					break;
				case '7':
					$content =M("article")->where("id={$idArr['0']}")->getField("content");
					$newContent=str_replace($_SESSION['title'], $_POST['replace'], $content,$count);
					$title =M("article")->where("id={$idArr['0']}")->getField("title");
					$newTitle=str_replace($_SESSION['title'], $_POST['replace'], $title,$count);
					
					$data['title']=$newTitle;
					$data['content']=$newContent;
					$res=M("article")->where("id='{$idArr['0']}'")->save($data);
					break;
				// 二三级页面上半部分
				case 'class':
					$content =M("class")->where("id={$idArr['0']}")->getField("content");
					$newContent=str_replace($_SESSION['title'], $_POST['replace'], $content,$count);
					$title =M("class")->where("id={$idArr['0']}")->getField("title");
					$newTitle=str_replace($_SESSION['title'], $_POST['replace'], $title,$count);
					$name =M("class")->where("id={$idArr['0']}")->getField("name");
					$newName=str_replace($_SESSION['title'], $_POST['replace'], $name,$count);
					
					$data['title']=$newTitle;
					$data['content']=$newContent;
					$data['name']=$newName;
					$res=M("class")->where("id='{$idArr['0']}'")->save($data);
					break;
				default:
					# code...
					break;
					
			}
	
			// unset($_SESSION['title']);
			// var_dump($_SESSION);exit;
		}
		$res=M("article")->getLastSql();
		 // var_dump($res);exit;
		if($res){
			// unset($_SESSION['title']);
			$this->success("替换成功！");
		}else{
			$this->error("替换失败！");
		}
		
	}


	//图片上传
	private function upload(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/Uploads/system/'; // 设置附件上传根目录
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