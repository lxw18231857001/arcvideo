<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html style="width:100%;height:100%">
<head>
    <title><?php echo ($title["name"]); ?> <?php echo ($system["name"]); ?>：全球领先的智能视频解决方案与视频云服务提供商</title>
    <!-- <title><?php echo ($system["name"]); ?>：全球领先的智能视频解决方案与视频云服务提供商</title> -->
    <meta charset=utf-8 >
    <!-- 启用360浏览器的极速模式(webkit) -->
    <meta name="renderer" content="webkit" />
    <!-- 避免IE使用兼容模式 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="robots" content="index, follow" >
    <meta name="keywords" content="<?php echo ($system["key"]); ?>" >
    <meta name="description" content="<?php echo ($system["describe"]); ?>" >
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/arc/Public/home/images/favicon.ico">
    <!-- CSS begin -->
    <script type="text/javascript" src="/arc/Public/home/js/html5.js"></script>
    <link rel="stylesheet" type="text/css" href="/arc/Public/home/css/style.css" >
    <link rel="stylesheet" type="text/css" href="/arc/Public/home/css/skeleton.css" >
    <link rel="stylesheet" type="text/css" href="/arc/Public/home/css/friend-slider.css">
    <link rel="stylesheet" type="text/css" href="/arc/Public/home/css/jquery.fancybox-1.3.4.css"  >
    <link rel="stylesheet" href="/arc/Public/home/css/switcher/style.css">
    <link rel="stylesheet" href="/arc/Public/home/css/layout/wide.css" id="layout">

    <!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="css/ie-warning.css" ><![endif]-->
    <!--[if lte IE 9]><link rel="stylesheet" type="text/css" media="screen" href="css/style-ie.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" type="text/css" href="css/ei8fix.css" ><![endif]-->

    <!-- flexslider slider CSS 2017/3/31 -->

    <link rel="stylesheet" type="text/css" href="/arc/Public/home/css/flexslider2.css"  >
    <link href="/arc/Public/home/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/arc/Public/home/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
    <!--end flexslider slider CSS -->
    <!-- CSS end -->

    <!--[if lt IE 9]>
    <script type="text/javascript" src="js/html5.js"></script>
    <![endif]-->

    <!-- JS begin -->

    <script type="text/javascript" src="/arc/Public/home/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/superfish.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/bootstrap.js"></script>
    <!-- Flex Slider   -->
    <script src="/arc/Public/home/js/jquery.flexslider.js"></script>
    <script src="/arc/Public/home/js/flex-slider2.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/jquery.flexslider-min.js"></script>
    <!-- end Flex Slider -->
    <script type="text/javascript" src="/arc/Public/home/js/jquery.jcarousel.js"></script>
    <script type="text/javascript" src="/arc/Public/home//js/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="/arc/Public/home//js/jQuery.BlackAndWhite.min.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/jflickrfeed.min.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/jquery.quicksand.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/main.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/jquery-cookie.js"></script>
    <script type="text/javascript" src="/arc/Public/home/js/friend.js"></script>

    <script type="text/javascript" id="ipone_script"></script>
    <script>
        addEventListener('DOMContentLoaded',function(){
            var oW=document.documentElement.clientWidth;
            var oS1=document.getElementById('ipone_script');
            if(oW<=1019){
                oS1.src='/arc/Public/home/js/ipone_script.js';
                
            }

        },false);


           /* window.onmousewheel = function (e) {
                e = e || event;
               if (e.wheelDelta) {  //判断浏览器IE，谷歌滑轮事件
                    if (e.wheelDelta < 0) { //当滑轮向下滚动时
                        $(".productList").css("display", "none");
                    }
               } else if (e.detail) {  //Firefox滑轮事件
                    if (e.detail < 0) { //当滑轮向下滚动时
                        $(".productList").css("display", "none");
                        return false;
                    }
               }


            }
*/

    </script>
    <!-- JS end -->
    <script type="text/javascript">
        function bigImg(x)
        {return;}
    </script>
</head>
<body>
<style type="text/css">
  .nav-collapse .nav>li:hover>a{ border-bottom: #00A0E8 solid 3px; }
</style>
<div id="wrap" class="boxed">
  <div class="header-bg ">
    <div class="grey-bg ">
      <!-- HEADER -->
      <header id="header " >
        <div class="container clearfix">
          <div class="navbar navbar-inverse">
            <!--手机右上角-->
            <div class="navbar-inner">
              <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse" onclick="collapse()" style="z-index:999">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
              <a class="brand" href="/arc/Home/Index/index.html">
                <img src="/arc/Public/Uploads/system/<?php echo ($logo); ?>" >
              </a>
              <div class="nav-collapse collapse">
                <ul class="nav">
                  <li class="dropdown menuitem">
                    <a href="/arc/Home/Index/index.html" class="dropdown-toggle" >首页</a>
                  </li>
                  <?php if(is_array($class)): foreach($class as $key=>$vo): ?><li class="dropdown menuitem  item<?php echo ($vo["id"]); ?> ">
                      <?php if($vo["id"] == 6): ?><a href="<?php echo ($vo["link"]); ?>" class="dropdown-toggle"  target="_blank">当虹云</a>
                      <?php elseif($vo["id"] == $currentId): ?>
                        <a href="/arc/Home/Index/<?php echo ($vo["link"]); ?>" class="dropdown-toggle active"  ><?php echo ($vo["name"]); ?></a>
                      <?php else: ?>
                        <a href="/arc/Home/Index/<?php echo ($vo["link"]); ?>" class="dropdown-toggle"  ><?php echo ($vo["name"]); ?></a><?php endif; ?>

                      <!-- 二级 -->
                      <?php if($vo["id"] == 2 ): ?><ul class="dropdown-menu submenu productList chanpin">
                          <?php $_result=getsub($vo['id']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><li>
                              <p class="erji">
                                <a href="/arc/Home/Index/<?php echo (get_class_url($vv["id"])); ?>?id=<?php echo ($vv["id"]); ?>" ><?php echo ($vv["name"]); ?></a>
                              </p>
                              <!-- =========三级========= -->
                              <div class="product1 productL">
                              <?php $_result=other_class($vv['id']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i;?><p><a href="/arc/Home/Index/<?php echo (get_name_three($vvv["path"])); ?>?id=<?php echo ($vvv["id"]); ?>&&pid=<?php echo ($vv["id"]); ?>"><?php echo ($vvv["name"]); ?></a></p><?php endforeach; endif; else: echo "" ;endif; ?>
                              </div>
                              <!-- =========三级========= -->
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    <?php elseif( $vo["id"] == 4 ): ?>
                        <ul class="dropdown-menu submenu productList jiejue">
                          <?php $_result=getsub($vo['id']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><li>

                              <p class="erji">
                                <a href="/arc/Home/Index/<?php echo (get_class_url($vv["id"])); ?>?id=<?php echo ($vv["id"]); ?>" ><?php echo (jiejue_replace($vv["name"])); ?></a>
                              </p>
                              <!-- =========三级========= -->
                              <div class="product1 productL">
                              <?php $_result=other_class($vv['id']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvv): $mod = ($i % 2 );++$i;?><p><a href="/arc/Home/Index/<?php echo (get_name_three($vvv["path"])); ?>?id=<?php echo ($vvv["id"]); ?>&&pid=<?php echo ($vv["id"]); ?>"><?php echo (jiejue_replace($vvv["name"])); ?></a></p><?php endforeach; endif; else: echo "" ;endif; ?></div>
                              <!-- =========三级========= -->
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                      <?php else: ?>
                        <ul class="dropdown-menu submenu">
                          <?php $_result=getsub($vo['id']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i; if($vv["id"] == 324): ?><li>
                                <a href="/arc/Home/Index/<?php echo (get_class_url($vv["id"])); ?>?id=<?php echo ($vv["id"]); ?>" target="_blank"><?php echo ($vv["name"]); ?></a>
                                 </li>
                            <?php else: ?>
                              <li>
                                <a href="/arc/Home/Index/<?php echo (get_class_url($vv["id"])); ?>?id=<?php echo ($vv["id"]); ?>" ><?php echo ($vv["name"]); ?></a>
                              </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                      <!-- 二级 -->
                    </li><?php endforeach; endif; ?>
                  <!-- <li class="dropdown menuitem">
                    <a href="http://channel.hongshiyun.net/" class="dropdown-toggle">渠道计费</a>
                  </li> -->
                </ul>
                  <script>
                  // var ww=$(".item8 .submenu li:last");
                  //  ww.find("a").attr("target","_blank");

                    var whidth =  $(".navbar-inner").width();
                    var whidh = window.screen.availWidth;
                    var pol =  (whidh-1220)/2;
                    $(".productList").css("left",pol);
                    $(".productList").width(whidth);
                  </script>
             <div class="menuend">
                  <div class="guoleft">
                    <div class="commonTopbar_login">

                    <?php if($account != null): ?><span class="userName"><?php echo (substr_replace($account,'*',3,4)); ?>,您好</span>
                    <?php else: ?>
                        <a href="/arc/Home/Index/login.html" target="_self">登录</a>
                        <span class="xiexian">/</span>
                        <a href="/arc/Home/Index/registe.html" target="_self">注册</a><?php endif; ?>

                    </div>
                  </div>
                  <div class="bar_right">
                    <div class="sou">
                      <div class="topForm">
                        <form name="form1"  action="/arc/Home/Index/search" class="sou_from" method="get">
                          <input type="button" class="btn1 btn_2" value="">
                          <input type="submit" class="btn1 btn_3" value="">
                          <input type="text" name="title" id="search" class="input1 input_hover" placeholder="关键词" style="overflow: hidden;">
                        </form>
                      </div>
                      <a href="javascript:;" class="navA"></a> </div>
                     <script type="text/javascript">
                    $(function(){
                        $('.topForm').click(function(){
                          $(this).find('.input1').stop().animate({width: 110}, 500);
                          $(this).find('.input1').css("border","1px solid #ccc");
                          $(this).stop().animate({right: 110}, 500);
                          $(this).find('.input1').focus().css("border-left","none");
                          $(".btn1").css({"border":"1px solid #ccc","border-right":"none","width":"24"});
                          $(".btn_2").css("width","24");

                        });
                        $(".input1").blur(function(){
                          $('.input1').stop().animate({width: 0}, 500).css("border","none");
                          $(".topForm").stop().animate({right: 24}, 500);
                          $(".btn1").css("border","none");
                          $(".btn_3").css("display","black");
                          $(".btn_2").css("width","36");

                        });
                        var whide = $(".input1").width(0);
                        if(whide){
                          $(".input1").css("border","none");
                        }
                      })
                    </script>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>

        <!--end: Navigation -->

    </header>
  </div>
</div>
</div>
<!-- Grey bg end --> 


<style type="text/css">
.sticky-wrapper{ border-top:1px solid #e2e2e2; }
.sticky-wrapper.is-sticky{ border-top:0; }
.blog-item .container{ width:inherit; }
</style>
<!-- banner -->
<div id="slider-containerb" class=" clearfix">
  <?php if(($two_pic) != ""): ?><div class="flexsliderb loading" >
      <img src="/arc/Public/Uploads/class/<?php echo ($two_pic['pic']); ?>" class="item"  />
      <div class="flex-captionb">
        <div class="container columns">
          <div class="title">
            <h2><span class="bold" ><?php echo ($two_pic['title']); ?></span></h2>
            <p class="subtitle-2"><?php echo ($two_pic['stitle']); ?></p>
          </div>

        </div>
      </div>
    </div><?php endif; ?>
</div>
<!-- banner --> 

<!-- 二级/三级标题 -->
<div id="menu-s">
  <div class="grey-b">
    <div class="container clearfix" style="width: 80%">
     <div class="mains-nav column nanv">
        <ul>
         <li class="mainn"><a href="/arc/Home/Index/<?php echo ($class[0]['link']); ?>" ><?php echo ($class[0]['name']); ?></a></li>
          <li><a href="/arc/Home/Index/products?id=<?php echo ($styleOne["id"]); ?>" style="padding: 0;margin: 0"><?php echo ($styleOne['name']); ?></a></li>
          <li class="xiexian">/</li>
          <li class="lanLie"><?php echo ($info['name']); ?></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- CONTENT -->
<div class="clearfix clearfix m-top-40">
  <div class="sixteen columns m-bot-25 sinpic"> 
    <!-- PORTFOLIO ITEM -->
    <div class="blog-item m-bot-35 clearfix ">
      <div class="blog-item m-bot-10 clearfix" >
        <div class="blog-item-text-container single" style="margin:0px auto;">

          <div style="margin-bottom: 60px;">
            <h5 style="font-weight: bold;line-height: 20px;">产品简介</h5>
              <P><?php echo ($info['content']); ?></P>
          </div>

          <div class="ingR">
            <img src="/arc/Public/Uploads/class/<?php echo ($info['pic']); ?>" alt="Ipsum" >
            <div class="mask"></div>
          </div>

          <div class="ingL">
            <ul class="tabs-nav">
              <?php if(is_array($show)): foreach($show as $key=>$v): ?><li> <a href="#tab<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a> </li><?php endforeach; endif; ?>
            </ul>

            <div class="content-container-white tab-main-container">
            <!-- TABS -->
              <!-- <div class="content-container-white tab-main-container"> -->
                <?php if(is_array($show)): foreach($show as $key=>$vv): ?><div id="tab<?php echo ($vv["id"]); ?>" class="tab-content" >
                    <ul class="tab-post-container_product text" style="padding-left: 0;">
                      <li> <?php echo ($vv["content"]); ?> </li>
                    </ul>
                  </div><?php endforeach; endif; ?>
              <!-- </div> -->
            </div>
          </div>
        </div>
        </div>

      </div>
    </div>
  </div>

<!-- Sticky nav start --> 
<script type="text/javascript" src="/arc/Public/home/js/jquery.sticky.js"></script> 
<script type="text/javascript">
  $(document).ready(function(){
    $("#menu-s").sticky({topSpacing:0});
  });
</script> 
<!-- Sticky nav end --> 

<!-- FOOTER --> 
<!-- FOOTER -->
	<footer>
		<div class="footer-content-bg p-top-35 p-bot-25 foot ">
			<div class="container  clearfix">
			
			<!-- <div class="two-thirds-footer-spec column alpha"> -->
			<div class="two-thirds-footer-spec column" >
                  <div class="footer-menu-container">
						<nav class="clearfix" id="footer-nav">
						<?php if(is_array($class)): foreach($class as $key=>$vo): ?><ul class="footer-menu">									
									<?php if($vo["id"] == 6 ): else: ?> <h9><?php echo ($vo["name"]); ?></h9><?php endif; ?>
									<?php $_result=getsub($vo['id']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><li><a href="/arc/Home/Index/<?php echo (get_class_url($vv["id"])); ?>?id=<?php echo ($vv["id"]); ?>"><?php echo ($vv["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul><?php endforeach; endif; ?>	
						</nav>
					</div>

						<img src="/arc/Public/home/images/weixin-arc.jpg"  class="logo">
						<div class="newsname"><p>引领全球视听技术的发展</p><p>让人们获得最佳的视听体验</p></div>

				</div>		
			</div>
			<div class="container" style="text-align: center">
				<div class="sixteen columns clearfix" style="color: #9F9F9F;margin-top: 40px;">
					
					<div>
						<span>杭州总部：<?php echo ($contact["address2"]); ?></span> <span> 电话：<?php echo ($contact["tel2"]); ?></span>
						<span style="margin: 0 10px;">|</span>
						<span> 北京办事处：<?php echo ($contact["address"]); ?></span><span> 电话：<?php echo ($contact["tel"]); ?></span>

					</div>
					<div><?php echo ($system["copyright"]); ?> <span class="haogongsi"><?php echo ($system["record_number"]); ?></span></div>
				</div>
			</div>
		</div>

		</div>
	</footer>	
		<p id="back-top">
			<a href="#top" title="顶部"><span></span></a>
		</p>

		<p id="back-mas">
			<a href="/arc/Home/Index/online?id=29" title="留言"><span></span></a>
		</p>
</div>

	</body>
</html>