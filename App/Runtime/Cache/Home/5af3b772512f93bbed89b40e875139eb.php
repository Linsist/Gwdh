<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>广外导航</title><?php get_css($css); ?><link rel="stylesheet" type="text/css" href="__CSS__/site.css" /><link rel="stylesheet" type="text/css" href="__CSS__/dhpc.css" /><script src="__JS__/jquery-1.7.2.min.js" type="text/javascript"></script><!-- <script src="__JS__/allactionforGwd.js" type="text/javascript"></script> --><?php get_js($js); ?><!--[if IE 6]><script type="text/javascript" src="__JS__/DD_belatedPNG_0.0.8a.js" ></script><script type="text/javascript">   DD_belatedPNG.fix('.sidebar_gmain, .sidebar_gps, .sidebar_news, .sidebar_lib, .sidebar_share');   </script><![endif]--><script type="text/javascript">$(document).ready(function(){
	$('#submit_msg').click(function(){
		var content=$('#sidebar_txt').val();
		if(content==""){
			alert('内容不能为空!');
			return false;
		}
		$.ajax({
			async: false,
			url:"<?php echo U('Feedback/submitFeedback');?>",
			type:'post',
			data:{'content':content},
			success:function(data){
				var msg = $.parseJSON(data);
				if(msg.status==1){
					alert("您的建议发布成功，我们会努力改进！");
				}
				$('#sidebar_txt').val("");
			}			
		});
	});
	$('#login-submit').click(function(){
		var username=$('[name="username"]').val();
		var password=$('[name="password"]').val();
		if(checkPassword(username,password)){
			return true;
		}else{
			return false;
		}
		
	});
	
	
});

function checkPassword(username,password){
	var bool = false;
	$.ajax({
		async: false,
		url:"<?php echo U('Accounts/checkPassword');?>",
		type:'post',
		data:{'username':username,'password':password,'submitted':'submitted'},
		dataType:'json',
		success:function(msg){
			if(msg.status == 1){
				bool = true;
			}else{
				alert(msg.info);
				bool = false;
			}
				
		}			
	});
	return bool;
}

</script><!-- 控制顶部样式 --><script type="text/javascript">$(document).ready(function() {
	$('#top_list').mouseenter(function(){
		$(this).css({height:'auto'});
		var top = $(this).find('li:first');
		var username = top.find('a');
		var li_close = top.attr('class');
		var ul_close = username.attr('class');
		// top.removeClass(li_close);
		// username.removeClass(ul_close);
		// top.next('li').addClass(li_close);
		// alert(top.next().length);
	}).mouseleave(function(){

		$(this).css({height:'40px'});
	});
});



</script></head><body><script src="__JS__/allactionforGwd.js" type="text/javascript"></script><div class="includeall" id="includeall"><div class="wrapper_outer"><div class="wrapper"><!--<div class="wrapper_logo"><a href="#"><span class="wrapper_logo_txt">广外导航</span><span>The Navigation Of GDUFS</span></a></div>--><div class="wrapper_logo"><a href="#">广外导航</a></div><div class="wrapper_private"><a href="<?php echo U('Accounts/index');?>">个人中心</a></div><div class="wrapper_login wrapper_upper"><ul><?php if(!isLogged()): ?><li class="wrapper_li_border wrapper_li_border1"><a id="loginbtn" href="#">登录</a></li><?php else: ?><li class="upper_list upper_list1"><ul id="top_list" style="height:40px;border:none;"><!-- 把ul里面的样式去掉，然后把li_close和ul_close去掉就能显示列表了 --><li class="li_close"><a class="ul_close" href="#"><?php echo ($_SESSION['account']['username']); ?></a></li><li><!-- <a class="a_onselect" href="">个人设置</a> --><a href="">个人设置</a></li><li><a href="<?php echo U('Accounts/logout');?>">注销</a></li></ul></li><li class="wrapper_li_border wrapper_li_border1"><a href="<?php echo U('Accounts/index');?>">进入个人中心</a></li><?php endif; ?></ul></div></div></div><div class="content_outer"><div class="sidebar_left"><div class="sidebar_container"><div class="sidebar_hot" id="sidebar_hot"><p>最近最火网站</p><a href="#">新生指南</a><a href="#" class="sidebar_hot_bottom">选课系统</a></div></div><div class="sidebar_container"><a class="sidebar_gmain" href="#"><span>数字广外</span></a><a class="sidebar_gps" href="#"><span>卫星电视系统</span></a></div><div class="sidebar_container"><a class="sidebar_news" href="#"><span>广外新闻网</span></a><a class="sidebar_lib" href="#"><span>广外图书馆</span></a></div><div class="sidebar_container"><a class="sidebar_special" href="#"><span class="sidebar_cspan1">特别推荐</span><span class="sidebar_cspan2">新生指南</span></a></div><div id="movediv1" class="sidebar_container sidebar_container_share"><div class="sidebar_share"><div class="sidebar_share1">期待您能分享<br />更好的想法和更好的网站...</div></div><div id="movediv2" class="sidebar_share sidebar_share2"><div class="sidebar_share_tdiv"><textarea id="sidebar_txt"></textarea></div><a href="#" id="submit_msg">发表建议</a></div></div><div class="cl"></div></div><div class="content_right"><div class="search_div"><form id="baidu_form" action="http://www.baidu.com/s" method="get"><input type="text" name="wd" class="search_input" value="百度搜索" /><span id="test1"></span><a class="search_btn2" id="baidu_search_btn" href="#">百度一下</a></form></div><div class="devides_div"><div><a class="content_entertain2" id="firstchange" href="#">学习生活娱乐</a></div><div><a class="content_stuunion1" id="secondchange" href="#">学生社团</a></div><div><a class="content_flag1" id="thirdchange" href="#">校内设施</a></div></div><div class="content_main" id="content_main"><div class="content_unit" id="learnclass" style="display:block"><div class="content_unit_head"><p>学习</p></div><div class="website_div website_learning"><div class="website_div2" id="learnclass1"><ul><?php if(is_array($arr["10"])): $i = 0; $__LIST__ = $arr["10"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site10): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($site10["site"]); ?>"><?php echo ($site10["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div><div class="content_unit" id="lifeclass" style="display:block"><div class="content_unit_head"><p>生活</p></div><div class="website_div website_learning"><div class="website_div2" id="lifeclass1"><ul><?php if(is_array($arr["2"])): $i = 0; $__LIST__ = $arr["2"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site2): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($site2["site"]); ?>"><?php echo ($site2["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div><div class="content_unit" id="entertainclass" style="display:block"><div class="content_unit_head"><p>娱乐</p></div><div class="website_div website_learning"><div class="website_div2" id="entertainclass1"><ul><?php if(is_array($arr["1"])): $i = 0; $__LIST__ = $arr["1"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site1): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($site1["site"]); ?>"><?php echo ($site1["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div><div class="content_unit" id="partyclass" style="display:none"><div class="content_unit_head"><p>团学党建</p></div><div class="website_div"><div class="website_div2" id="partyclass1"><ul><?php if(is_array($arr["4"])): $i = 0; $__LIST__ = $arr["4"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site4): $mod = ($i % 2 );++$i;?><li><a href="#"><?php echo ($site4["name"]); ?></a><span class="span_hidden"><?php echo ($site4["site"]); ?></span><span class="span_hidden"><?php echo ($site4["info"]); ?></span><span class="span_hidden"><?php echo ($site4["site"]); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div><div class="content_unit" id="workclass" style="display:none"><div class="content_unit_head"><p>勤工实体</p></div><div class="website_div"><div class="website_div2" id="workclass1"><ul><?php if(is_array($arr["17"])): $i = 0; $__LIST__ = $arr["17"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site17): $mod = ($i % 2 );++$i;?><li><a href="#"><?php echo ($site17["name"]); ?></a><span class="span_hidden"><?php echo ($site17["site"]); ?></span><span class="span_hidden"><?php echo ($site17["info"]); ?></span><span class="span_hidden"><?php echo ($site17["site"]); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div><div class="content_unit" id="unionclass" style="display:none"><div class="content_unit_head"><p>团联组织</p></div><div class="website_div"><div class="website_div2" id="unionclass1"><ul><?php if(is_array($arr["5"])): $i = 0; $__LIST__ = $arr["5"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site5): $mod = ($i % 2 );++$i;?><li><a href="#"><?php echo ($site5["name"]); ?></a><span class="span_hidden"><?php echo ($site5["site"]); ?></span><span class="span_hidden"><?php echo ($site5["info"]); ?></span><span class="span_hidden"><?php echo ($site5["site"]); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div><div id="specialclass" class="content_unit" style="display:none"><div class="content_unit_head"><p>特色组织</p></div><div class="website_div"><div class="website_div2" id="specialclass1"><ul><?php if(is_array($arr["3"])): $i = 0; $__LIST__ = $arr["3"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site3): $mod = ($i % 2 );++$i;?><li><a href="#"><?php echo ($site3["name"]); ?></a><span class="span_hidden"><?php echo ($site3["site"]); ?></span><span class="span_hidden"><?php echo ($site3["info"]); ?></span><span class="span_hidden"><?php echo ($site3["site"]); ?></span></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div><div class="content_unit" id="educlass" style="display:none"><div class="content_unit_head"><p>教学单位</p></div><div class="website_div website_learning"><div class="website_div2" id="educlass1"><ul><?php if(is_array($arr["6"])): $i = 0; $__LIST__ = $arr["6"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site6): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($site6["site"]); ?>"><?php echo ($site6["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div><div class="content_unit" id="searchclass" style="display:none"><div class="content_unit_head"><p>科研单位</p></div><div class="website_div website_learning"><div class="website_div2" id="searchclass1"><ul><?php if(is_array($arr["9"])): $i = 0; $__LIST__ = $arr["9"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site9): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($site9["site"]); ?>"><?php echo ($site9["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div><div class="content_unit" id="shitclass" style="display:none"><div class="content_unit_head"><p>政党机关</p></div><div class="website_div website_learning"><div class="website_div2" id="shitclass1"><ul><?php if(is_array($arr["8"])): $i = 0; $__LIST__ = $arr["8"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site8): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($site8["site"]); ?>"><?php echo ($site8["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="website_div3"><a href="#" class="lastpage_btn">上一页</a><a href="#" class="nextpage_btn">下一页</a></div></div><div class="cl"></div></div></div><div class="cl"></div></div><div class="footer" id="footer"><ul><li class="footer_li_1"><a href="#">Copyright © 2013 尹川东 陈勇校 袁云</a></li></ul></div></div></div><div class="popup_div" id="popup_div1"><div class="popup_content"><a class="popup_a1" href="#">官方网址</a><a class="popup_a2" href="#">新浪官方微博</a><a class="popup_a3" href="#">官方博客</a></div><div class="popup_sharp"></div></div><div class="login_div" id="login_div" style="display:none"><div class="login_divhead"></div><div class="login_divbody"><div class="login_adv"><img src="__IMG__/adv_img.png"></div><div class="login_form"><form action="<?php echo U('Accounts/login');?>" method="post"><div class="login_account"><input type="text" name="username" /></div><div class="login_password"><input type="password" name="password" /></div><p><input id="remenber_pwd" type="checkbox" name="autoLogin" checked="checked" /><label for="remenber_pwd">记住密码</label><a href="#">忘记密码？</a></p><div class="login_getAc"><input type="submit" id="login-submit" value="登录" /><a href="http://passport.mygdufs.com/Account/register?appid=8">没账号？<span>马上注册！</span></a></div></form></div></div></div><div class="popup_div2" id="popup_div2"><div class="popup_div_c1"><a href="#">登录</a></div><form action="<?php echo U('Accounts/login');?>" method="post"><div><label>账号</label><br /><input class="input1" name="username" type="text" /></div><div><label>密码</label><br /><input class="input1" name="password" type="password" /></div><div><div class="popup_div_c2"><label><input type="checkbox" name="autoLogin" checked="checked" />                            自动登录
                        </label></div><div class="popup_div_c3"><input type="submit" name="submitted" id="login-submit" value="登录" /></div></div></form></div>