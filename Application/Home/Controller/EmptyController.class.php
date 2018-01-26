<?php 
namespace Home\Controller;
use Think\Controller;
use Home\Common\common;
    class EmptyController extends Controller{ 
        function _empty(){ 
            header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
            $this->display("404.html"); 
        } 
    } 
    ?>