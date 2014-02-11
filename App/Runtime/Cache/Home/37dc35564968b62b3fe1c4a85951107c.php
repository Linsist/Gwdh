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



</script></head><body><div id="template" class="template"><!-- 每一页的模板 --><!-- <div class="pc_nomalwebsite" alt=""></div> --><!-- 添加网址的方块 --><a href="#" alt="" class="pc_right_noweb"></a></div><script type="text/javascript" src="__JS__/jquery.dragsort-0.5.1.js"></script><script type="text/javascript" src="__JS__/onmousewheel.js"></script><script type="text/javascript" src="__JS__/pc_square.js"></script><script type="text/javascript" src="__JS__/pcscroll.js"></script><script type="text/javascript" src="__JS__/pc_library.js"></script><script type="text/javascript" src="__JS__/scrollBar.js"></script><script type="text/javascript">var page = new page();
var square = new Square();

$(document).ready(function() {
    siteSquareMove();
    controlSiteOver();
    addScrollListener(document.getElementById('include_web'),
        function(event){
            page.scrollTo(getWheelData(event),1);
    });
    controlSearch();
    controlPage();

});

/**
 * 控制搜索框
 */
function controlSearch(){
    $('#baidu_input').click(function(){
        $(this).val('');
    }).blur(function(){
        var value = $(this).val();
        if (value=='') {
            $(this).val('百度搜索');
        }
    });

    $('#baidu_search_btn').click(function(){
        $('#baidu_form').submit();
    });
}


function controlPage(){
    var ajaxAdd = '<?php echo U("Userpage/add");?>';
    var ajaxDelete = '<?php echo U("Userpage/delete");?>';
    var ajaxUpdate = '<?php echo U("Userpage/update");?>';
    var ajaxCheckPageNum = '<?php echo U("Userpage/checkPageNum");?>';
    var ajaxEmptyPage = '<?php echo U("Userpage/emptyPage");?>';
    page.setUrl({
        add:ajaxAdd,
        delete:ajaxDelete,
        update:ajaxUpdate,
        checkPageNum: ajaxCheckPageNum,
        emptyPage: ajaxEmptyPage,
    });
    page.checkPageNum();
    // 添加分类
    $('#addpage').click(function(){       
        page.addPage(function(msg){
            if (msg.status==1) {
                page.appendPage(msg.data.pageId);
                
                setIncludeWebWidth();//重新调整宽度
                page.scrollTo(-1,page.getLength()-page.index-1);
                page.appendLowerList(msg.data.title);
                page.checkPageNum();
                
            }
        });
    });

    //删除分类
    $('#deletePage').click(function(){
        
        var pageId = $('.pc_nomalwebsite:eq('+page.index+')').attr('alt');
        // alert(pageId);return;
        var lastIndex = $('.pc_nomalwebsite:last').attr('alt');
        // alert(lastIndex+"/"+pageId);
        page.deletePage(pageId, function(msg){
            if (msg.status==1) {
                $('.pc_nomalwebsite[alt="'+pageId+'"]').remove();
                resetAllEvent();
                if (lastIndex==pageId) {
                    page.scrollTo(1,1);
                }else{
                    page.scrollTo(-1,1);
                }
                page.removeLowerLi();
                page.checkPageNum();
            }
        });
    });

    $('.lower_list li:not(.last_li)').click(function(){
        var lower_index = $(this).index();
        var dir = lower_index - page.index;
        if (dir == 0) return;
        page.scrollTo(-dir, Math.abs(dir));
    }).dblclick(function(){
        $(this).find('a').hide();
        $(this).find('input').show().focus();
    });
    $('.lower_list li:not(.last_li)').find('input').blur(function(){
        var pageId = page.getPageId(page.index);
        var title = $(this).val();
        var li_a = $(this).prev('a');
        page.updatePage(pageId,title,function(msg){
            if (msg.status==1) {
                li_a.text(title);
            }
        });
        
        li_a.show();
        $(this).hide();

    });

    $('#emptyPage').click(function(){
        page.emptyPage(function(msg){
            if (msg.status==1) {
                $('.pc_nomalwebsite:eq('+page.index+')').find('.siteSquare').remove();
            }
        });
    });

    //初始化lower_list第一个li：hover样式
    $('.lower_list li:first').addClass('li_onselect');
    $('.lower_list li:first').find('a').addClass('a_first');

}


function siteSquareMove(){
    $(".pc_nomalwebsite").dragsort({ 
        dragSelector: "a", 
        dragBetween: false, 
        dragSelectorExclude:'.pc_right_noweb',
        container: window,
        placeHolderTemplate: "<a ><div style='width:224px;height:140px;border: 2px dashed #333;'></div></a>" ,
        dragEnd: function(){
            // alert($(this).parent('.pc_nomalwebsite').attr('alt'));
            saveOrder();
        }
        // scrollSpeed: 20,
    });
}
function saveOrder(){
    
    // alert(1);
    $('.pc_nomalwebsite').each(function(){
        var ordersArr = [];
        var site={};
        $(this).find('.siteSquare').each(function(){
            ordersArr.push($(this).attr('alt'));
        });
        site.orders = ordersArr.join('|');
        site.pageId = $(this).attr('alt');
        doAjaxSaveOrder(site);
    });
}

/**
 * @param obj site = {pageId,orders}
 * @return boolean
 */
function doAjaxSaveOrder(site){
    var bool = true;
     $.ajax({
        async:true,
        type:'post',
        url:'<?php echo U("Usersite/saveOrder");?>',
        dataType:'json',
        data:{'pageId':site.pageId, 'orders':site.orders},
        success:function(msg){
        }

    });
    return bool;
}



/**
 * 重新添加事件
 * 避免事件重复，先移除再添加
 */
function resetAllEvent(){
    $('.pc_nomalwebsite').dragsort('destroy');
    siteSquareMove();
    setIncludeWebWidth();
    // sideScroll();
}







/**
 * 控制鼠标移到方块上，显示设置和删除
 */
function controlSiteOver(){
    $('.siteSquare').mouseover(function(){
        $(this).children('.pc_right_div2,.pc_right_span2').show();
    }).mouseout(function(){
        $(this).children('.pc_right_div2,.pc_right_span2').hide();
    });
 }



</script><div class="includeall" id="includeall"><div class="wrapper_outer wrapper_pc_outer"><div class="wrapper wrapper_pc"><!--<div class="wrapper_logo"><a href="#"><span class="wrapper_logo_txt">广外导航</span><span>The Navigation Of GDUFS</span></a></div>--><div class="wrapper_logo"><a href="<?php echo U('Index/home');?>">广外导航</a></div><div class="wrapper_private wrapper_pripc"><a href="#">个人中心</a></div><div class="wrapper_login wrapper_upper"><ul><li class="upper_list"><ul id="top_list" style="height:40px;border:none;"><!-- 把ul里面的样式去掉，然后把li_close1和ul_close1去掉就能显示列表了 --><li class="li_close1"><a class="ul_close1" href="#"><?php echo ($_SESSION['account']['username']); ?></a></li><li><a  href="">个人设置</a></li><li><a href="<?php echo U('Accounts/logout');?>">注销</a></li></ul></li><li class="wrapper_li_border"><a href="<?php echo U('Index/home');?>">返回首页</a></li></ul></div></div></div><div class="content_outer"><div class="pc_right"><div class="search_div"><form id="baidu_form" action="http://www.baidu.com/s" method="get"><input type="text" id="baidu_input" name="wd" class="search_input" value="百度搜索" /><span id="test1"></span><a class="search_btn2" id="baidu_search_btn" href="#">百度一下</a></form></div><!-- -网址入口 --><a href="#" class="trashbin">垃圾箱</a><div class="trashbin_list"><a href="#" id="emptyPage" class="clearbtn">清空标签</a><a href="#" id="deletePage" class="deletebtn">删除分类</a></div><!-- <div id="leftBar"></div> --><!-- <div id="rightBar"></div> --><div id="include_web"><?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$page): $mod = ($i % 2 );++$i;?><div class="pc_nomalwebsite" alt="<?php echo ($page["pageId"]); ?>"><?php $map = array( 'pageId'=>$page['pageId'], 'uid'=>$_SESSION['account']['uid'], ); $li = getList('Usersite',$map,'orders asc'); if(is_array($li)): $i = 0; $__LIST__ = $li;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$site): $mod = ($i % 2 );++$i;?><a  class="siteSquare" href="<?php echo ($site["url"]); ?>" alt="<?php echo ($site["id"]); ?>" page="<?php echo ($page["pageId"]); ?>"><span class="pc_right_span1"><img src="__UPLOAD__/<?php echo ($site["logo"]); ?>"/></span><div class="pc_right_div1"></div><div class="pc_right_div2"><span class="pc_right_aset">设置</span><span class="pc_right_adel">删除</span></div><span class="pc_right_span2"><?php echo ($site["title"]); ?></span></a><?php endforeach; endif; else: echo "" ;endif; ?><a href="#" alt="<?php echo ($page["pageId"]); ?>" class="pc_right_noweb"></a></div><?php endforeach; endif; else: echo "" ;endif; ?></div><div class="cl"></div></div><div class="lower_list"><ul><?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$page): $mod = ($i % 2 );++$i;?><li><a href="javascript:void(0)"><?php echo ($page["title"]); ?></a><input type="text" style="width:80px;display:none" value="<?php echo ($page["title"]); ?>" /></li><?php endforeach; endif; else: echo "" ;endif; ?><li class="last_li"><a class="a_last" id="addpage" href="#">+</a></li><!--     当这个a标签添加了分类不再是加号的时候记得把里面的a_last去掉   --></ul></div><div class="footer footer2"><ul><li class="footer_li_1"><a href="#">Copyright © 2013 尹川东 陈勇校 袁云</a></li></ul></div></div></div><script type="text/javascript">$(document).ready(function() {

    checkSquareNum();//检查每一页网址的个数
    initSquare();
    controlSiteEvent();   
});

function initSquare(){
    var add = '<?php echo U("Usersite/add");?>';
    var update = '<?php echo U("Usersite/update");?>';
    var del = '<?php echo U("Usersite/del");?>';
    var getSelectWebSite = '<?php echo U("Usersite/getSelectWebSite");?>';//供选网址框
    var searchSite = '<?php echo U("Usersite/searchSite");?>';
    // var search = '<?php echo U("Usersite/del");?>';
    // var search = '<?php echo U("Usersite/del");?>';
    var url = {
        add:add,
        update: update,
        del: del,
        getSelectWebSite: getSelectWebSite,
        searchSite: searchSite,
        upload: '__UPLOAD__',
    };
    square.setUrl(url);

}

/**
 * 控制方块的事件
 */
function controlSiteEvent(){
    //打开弹出框
    $('.pc_right_noweb').click(function(){
        $('#addweb_ntab').find('a:first').trigger('click');
        $('#addwebsite_div').show();
        $('#add_complete').attr('action','add');
    });

    //关闭弹出框
    $('#close_offer_list').click(function(){
        $('#addwebsite_div').hide();
        
    });

    //添加网址的时候，控制类别的选择
    $('#addweb_ntab').find('a').click(function(){
        $('#addweb_ntab').find('a').removeClass('addweb_ntbchosen');
        $(this).addClass('addweb_ntbchosen');
        var typeId = $(this).attr('alt');
        var webbase_unit = $('.webbase_unit a');
        webbase_unit.remove();
        square.getSelectWebSite(typeId);  
    });

    //网址库中，单击一个供选的网址，自动添加
    $('.selectSite').dblclick(function(){ 
        var url = $(this).attr('url');
        var title = $(this).children('.addweb_right_txt').text();
        var title = $(this).attr('title');
        var logo = $(this).attr('logo');
        var pageId = page.getPageId(page.index);
        var site = {
            pageId: pageId,
            url: url,
            title: title,
            logo: logo,
        };
        if (!checkSiteUrl(site.url) || !checkSiteTitle(site.title)) {
            return false;
        }
        square.add(site,function(msg){
            if (msg.status==1) {
                var data = msg.data;
                var newSite = square.createSqureNode(data);
                var contain = $('.pc_nomalwebsite[alt="'+data.pageId+'"]');
                contain.children('.pc_right_noweb').before(newSite);
            }
            $('#close_offer_list').trigger('click');
        });      
        checkSquareNum();
    });

    //云网址里面添加的搜索框
    $('#add_search_title,#add_search_url').keyup(function(){
        var title = $('#add_search_title').val();
        var url = $('#add_search_url').val();
        square.searchSite(title,url);
    });

    $('#add_complete').click(function(){
        var action = $(this).attr('action');
        if (action=='add') {
            var title = $('#add_search_title').val();
            var url = $('#add_search_url').val();
            var pageId = page.getPageId(page.index);
            var site = {
                pageId: pageId,
                url: url,
                title: title,
                logo: '',
            };
            addSite(site);
        }else if (action=='update') {
            updateStie();
        }     
    });

    //删除网址
    $('.pc_right_adel').click(function(e){
        e.preventDefault();//阻止事件的冒泡 
        var parent = $(this).parents('a.siteSquare');  
        var id = parent.attr('alt');
        square.delete(id,function(msg){
            if (msg.status == 1) {
                parent.remove();
            }else{
                alert('删除失败');
            }
        });
        
        checkSquareNum();//检查删除之后还有多少个网址
    });

    //修改网址
    $('.pc_right_aset').click(function(e){
        e.preventDefault();
        $('#addweb_ntab').find('a:first').trigger('click');//显示热门网址
        $('#addwebsite_div').show();
        $('#add_complete').attr('action','update');//更新网址

        var square = $(this).parents('a.siteSquare');
        var title = square.find('.pc_right_span2').text();
        var url = square.attr('href');
        var s_id = square.attr('alt');
        $('#add_search_title').val(title);
        $('#add_search_url').val(url);
        $('#add_complete').attr('alt', s_id);
    });

}


/**
 * 执行添加网址的事件
 */
function addSite(site){
    
    if (!checkSiteUrl(site.url) || !checkSiteTitle(site.title)) {
        return false;
    }
    square.add(site,function(msg){
        if (msg.status==1) {
            var data = msg.data;
            var newSite = square.createSqureNode(data);
            var contain = $('.pc_nomalwebsite[alt="'+data.pageId+'"]');
            contain.children('.pc_right_noweb').before(newSite);

            var url = data['url'];
            var parten = /^((https?|ftp|news):\/\/){1}/;
            if (!parten.test(url)) {
                url = 'http://'+url;
            }

            var imgSquare = $('.siteSquare[alt="'+data.id+'"]').find('img');
            imgSquare.attr('src','__IMG__/loading.gif');
            webshot(data.id,url,function(logo){
                data.logo = 'webshot/'+logo;
                // square.update(data.id,data,function(){});
                imgSquare.attr('src','__UPLOAD__/'+data.logo);
            });
            checkSquareNum();
        }
        $('#close_offer_list').trigger('click');
    });         
}

/**
 * 执行更行网址的事件
 */
function updateStie(){
    var title = $('#add_search_title').val();
    var url = $('#add_search_url').val();
    var s_id = $('#add_complete').attr('alt');
    var site = {
        title:title,
        url:url
    };
    square.update(s_id,site,function (msg) {
        var data = msg.data;
        var square = $('a.siteSquare[alt="'+s_id+'"]');
        square.attr('href',url);
        square.find('.pc_right_span2').html(title);
    });

    $('#addwebsite_div').hide();

}








/**
 * 控制更新网址
 *
 */
function controlUpdateSite(){
    //更新网址的弹出
    $('.pc_right_aset').click(function(e){
        e.preventDefault();//阻止事件的冒泡
        var site = {};
        site.id = $(this).parents('a.siteSquare').attr('alt');
        alert(site.id);
    });

    //删除网址
    $('.pc_right_adel').click(function(e){
        e.preventDefault();//阻止事件的冒泡 
        var parent = $(this).parents('a.siteSquare');  
        var id = parent.attr('alt');

        square.del(id,function(msg){
            if (msg.status == 1) {
                parent.remove();
            }else{
                alert('删除失败');
            }
        });
        
        checkSquareNum();//检查删除之后还有多少个网址
    });

    //添加这个事件是为了让删除按钮更灵敏
    $('.pc_right_adel').mouseover(function(){
        $('.pc_nomalwebsite').dragsort('destroy');
    }).mouseout(function(){
        resetAllEvent();
    });

}



/**
 * 检查square的个数，如果大于8个就隐藏添加框
 */
function checkSquareNum(){
    var contain = $('.pc_nomalwebsite');
    contain.each(function(){
        var site = $(this).find('a.siteSquare');
        if (site.length >= 8 ) {
            $(this).find('a.pc_right_noweb').hide();
        }else{
            $(this).find('a.pc_right_noweb').show();
        }
    });
}







</script><!-- 增加网址的时候用来clone的模板 --><div id="siteTemplate" style="display:none"><a  class="siteSquare" href="http://www.baidu.com" alt="1"><span class="pc_right_span1"><img src="__UPLOAD__/webshot/"></span><div class="pc_right_div1"></div><div class="pc_right_div2"><span class="pc_right_aset">设置</span><span class="pc_right_adel">删除</span></div><span class="pc_right_span2">123</span></a></div><!-- 删除网址确认框 --><div class="delete_confirm" style="display:none;"><div class="confirm_head"><a href="#">关闭</a></div><div class="confirm_body"><p class="cfp-14">你确认要把标签</p><p class="cfp-18">全！部！都！删！掉！吗！</p><div class="btn_div"><a class="confirm_no" href="#">不要</a><a class="confirm_yes" href="#">确认</a></div></div></div><!-- 供选网址列表 --><div class="addwebsite_div" id="addwebsite_div"><a href="#" id="close_offer_list" class="close_btn">关闭</a><div class="addweb_search"><div class="search_ipt"><div><input id="add_search_title" type="text" /></div><span>网站标题：</span></div><div class="search_ipt"><div><input id="add_search_url" type="text" /></div><span>请输入网址：</span></div><a href="#" id="add_complete" class="complete_btn">完成</a></div><div id="add_cloud_web"><div id="addweb_ntab" class="addweb_ntab"><a href="#" class="addweb_ntbchosen" alt="1">热门</a><a href="#" alt="2">视频</a><a href="#" alt="3">音乐</a><a href="#" alt="4">购物</a><a href="#" alt="18">新闻</a><a href="#">社区</a><a href="#">更多</a></div><div class="divide_line"></div><div id="addweb_right" class="addweb_right"><!--         	<div class="addweb_searchinput"><form><input id="search_input" type="text" /><input type="submit" id="search_btn"  /></form></div> --><div class="webbase_unit"><a href="#" class="selectSite onselect" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span><span class="flag_on"></span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span><span class="flag_on"></span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span><span class="flag_on"></span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><a href="#" class="selectSite" title="淘宝" logo="baidu.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="__UPLOAD__/webshot/www.taobao.com.png"/></span><span class="addweb_right_txt">淘宝</span></a><!-- 这一堆东西纯属是哪里测试自定义下拉条的，完事可以删掉 --></div><!-- 用来复制的 --><div class="webase_unit example"  style="display:none"><a href="#" class="selectSite" title="淘宝" logo="taobao.com" url="http://www.taobao.com"><span class="addweb_right_back"><img src="" width="160px" heigt="97px"/></span><span class="addweb_right_txt">淘宝</span></a></div><div id="search_board" class="webbase_unit" style="display:none"></div></div></div><script type="text/javascript">        var scrollMoveObj = null, scrollPageY = 0, scrollY = 0;
        var scrollDivList = new Array();
        jsScroll("addweb_right", 8 ,"diyScroll");//这是添加自定义滚动条的函数，上面两行的全局变量你就找个地方安置它们就好
        // 在调整网址库里面网址数量的时候，建议先删除原有的滚动条，待网址加载完进去之后再进行滚动条的创建
        // removeScrollBar();这是删除自定义滚动条的函数，切记保证页面里只有一个自定义滚动条，如有超过要与我联系制定解决方案
    </script><div id="add_user_define"><div class="left"><p><label>网址:</label><input type="text" class="url"/><span class="tips1"></span></p><p><label>标题:</label><input type="text" class="title"/><br/><span class="tips2"></span></p><p class="sub_menu"><a href="#" id="confirm">确定</><a href="#" id="concel">取消</><a href="#" id="getWebshot">获取网页截图</></p></div><div class="right"><div class="display-logo"><img class="logo" logo="webshot/www.taobao.com.png" src="__UPLOAD__/webshot/www.taobao.com.png" width="160px" heigt="97px;"></div></div><div class="bottom"><img logo="webshot/www.taobao.com.png" src="__UPLOAD__/webshot/www.taobao.com.png"/><img logo="webshot/www.watergw.cn.png" src="__UPLOAD__/webshot/www.watergw.cn.png"/><img logo="webshot/tl.gdufs.edu.cn.png" src="__UPLOAD__/webshot/tl.gdufs.edu.cn.png"/><img logo="webshot/www.suidaokou.com.png" src="__UPLOAD__/webshot/www.suidaokou.com.png"/><img logo="webshot/www.dangdang.com.png" src="__UPLOAD__/webshot/www.dangdang.com.png"/><img logo="webshot/www.taobao.com.png" src="__UPLOAD__/webshot/www.taobao.com.png"/></div></div><!-- end of add_user_define --></div><script type="text/javascript">$(document).ready(function() {
    //自定义站点url检查事件
    $('.url').blur(function(){
        var url = $(this).val();
        if (checkSiteUrl(url)) {
            var site = getSiteByUrl(url);
            if (site) {
                $('.title').val(site[0].name);
                $('.logo').attr('src','__UPLOAD__/webshot/'+site[0].logo);
                $('.logo').attr('logo','webshot/'+site[0].logo);
            }else{

            }
            return true;
        }else{
            return false;
        }
    });

    //自定义站点title事件监听
    $('.title').blur(function(){
        var title = $(this).val();
        return checkSiteTitle(title);
    });

    //选择官方提供的网址截图
    $('.bottom img').click(function(){
        // $('.display-logo').empty();
        var thea = $('img.logo');
        var logo = $(this).attr('logo');
        var src = $(this).attr('src');
        thea.attr({'logo':logo, 'src':src});
        // $('.display-logo').append(thea);
    });

    //获取网页截图
    $('#getWebshot').click(function(){
        var logo;
        var url = $('input.url').val();
        var parten = /^((https?|ftp|news):\/\/){1}/;
        if (!parten.test(url)) {
            url = 'http://'+url;
        }
        webshot(url,function(logo){
            $('img.logo').attr({
                'logo':'webshot/'+ logo,
                'src':'__UPLOAD__/webshot/'+logo,
            });
        });
    });

});


function checkSiteUrl(url){
    var bool = false;
    var parten = /^((https?|ftp|news):\/\/)?([\w]+\.)?([\w-]+\.)(com|net|org|gov|cc|biz|info|cn|edu)(\.(cn|hk))*/;
    if (!parten.test(url)) {
        // alert(1);
        return false;
    }else{
        // alert(2);
        return true;
    }
}

function checkSiteTitle(title){
    var bool = false;
    $.ajax({
        async: false,
        type:'post',
        url: '<?php echo U("Usersite/ajaxCheck");?>',
        dataType:'json',
        data:{'title':title},
        success:function(msg){
            if (msg.status==1) {
                bool = true;
                $('.tips2').html('');
            }else{
                bool = false;
                $('.tips2').html(msg.info);
                alert(msg.info);
            }
        }
    });
    return bool;
}

/**
 * @param string url
 * @return json
 */
function getSiteByUrl(url){
    var site;
    $.ajax({
        async: false,
        type:'post',
        url: '<?php echo U("Usersite/getSiteByUrl");?>',
        dataType:'json',
        data:{'url':url},
        success:function(msg){
            if (msg.status==1) {
                site = msg.data;
            }else{
                site = false;
            }
        }
    });
    return site;
}

/**
 * @param int id 网址的id
 * @param string url
 * @return String 截图名字
 */
function webshot(id,url,callback){
    $.ajax({
        // xhr: null,
        async: true,
        type:'post',
        url: '<?php echo U("Usersite/ajaxWebshot");?>',
        dataType:'json',
        data:{'id':id, 'url':url},
        timeout: 60000,
        success:function(msg){
            callback(msg);
        },
        error: function(xhr,msg,exception){
            xhr.abort();
            alert(msg+'截图失败');
            
        }

    });
}

</script><div class="coverdiv" id="coverdiv" style="display:none;width:100%;height:100%"></div></body></html>