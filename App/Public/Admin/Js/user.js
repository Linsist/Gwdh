/*********************************
本文件主要是实现与用户操作相关的功能
*********************************/
$(document).ready(function(){
//如果禁止了登录，user_action来自nav.js
if(user_action){
	    login();
		add_show();
		up_down_action();
		edit();
		load_script();
}		
})
//首页加载好时登录
var is_login =false;
function login(){
	
    $.get("user.php?action=login",function(result){
		if(result != 'false'){//登录了，进行相关的操作
			is_login =true;
			for(var i=0;i<3;i++){
			var tmp = $(".body:eq("+i+")").find("#right-back").css("background-image").replace("unload","in");
			 		   $(".body:eq("+i+")").find("#right-back").css("background-image",tmp);//暂时少图片
			}
			 $(".body").find("#r-inside-button").show();
			 
			 //网址
			$(".body").find("#r-text-con").append(result);
			//网址列表的class
			$(".body:eq(0)").find("#r-text-con").addClass('blue');		
			$(".body:eq(1)").find("#r-text-con").addClass('orange');			
			$(".body:eq(2)").find("#r-text-con").addClass('green');
			//顶上用户信息	
			var add='';
			$.get("user.php?action=get_user_info",function(result){
				$("#load-in").html(result);
			})
			//隐藏自动登录
			$("#auto-load").hide();
			$("#zhuxiao").show();
			//添加框确定按钮
			$(".body").find("#tianjia-ok").mouseover(function(){
				get_route(now_lpage);//nav.js 里面的函数，获取当前页面的路径
				var tmp;
				tmp = $(this).css("background-image").replace(/imgs\/[b|o|g](.*).png/,'imgs/'+now_route+'/r-tianjia-ok-on.png');
				 $(this).css("background-image",tmp);
			});
			$(".body").find("#tianjia-ok").mouseleave(function(){
				get_route(now_lpage);
				var tmp;
				tmp = $(this).css("background-image").replace(/imgs\/[b|o|g](.*).png/,'/imgs/'+now_route+'/r-tianjia-ok.png');
				 $(this).css("background-image",tmp);
			});
			count_list()
		}
  });
}

var num;
var height;
var list_height = 22;
var con_height = 310;
function count_list(){
	num = $(".body:eq(0)").find("#r-text-con li").length;

	
	height = list_height*Math.ceil(num/2);
	if(height <= 310){
		$(".body").find("#up-go").hide();
		$(".body").find("#down-go").hide();
		$(".body").find("#r-text-con").css("top","0px");
	}else{
		$(".body").find("#up-go").show();
		$(".body").find("#down-go").show();
		
	}
}


var is_add = false;
var text1_focus = 0;
var text2_focus = 0;
var text1_first = true;
var text2_first = true;
function add_show(){
	//出现的效果
	$(".body #r-inside-button #jia").click(function(){
		//底下加号的变化
		if(is_edit){
		show_error('编辑状态下禁止！');
		 return false;}
		if($(this).attr("id")=="dele"){
		$(".body #dele").attr("id","jia")
		$(".body #tianjia").hide();
		$(".body #bian").show();
		is_add = false;		
		}else{
			$(".body #jia").attr("id","dele")
			var name = trim($(".body #tianjia .tianjia-text1").val());
			var site = trim($(".body #tianjia .tianjia-text2").val());
			
			if(name == ''){
			//未弄好	
				
			}
			if(site == ''){
					$(".body #tianjia .tianjia-text2").val("www.");
					text2_first = true;
			}
			$(".body #tianjia").fadeIn('slow');
			$(".body #bian").hide();
			count_list();
			is_add = true;
		}
		
		return false;
	});
	
	
	//input同步事件,有一部分写在了nav.js

/*未完成
 function text1_timeout(){
		if(text1_focus>0){
			var value = $(".body:eq("+(3-now_lpage)+")").find("#tianjia input:eq(0)").val();
			var text1_len = len(value);	
			if(text1_len >15){
					$(".body:eq("+(3-now_lpage)+")").find("#tianjia input:eq(0)").val(m_substr(value,16));
			}
			setTimeout(text1_timeout,5);		
		}
}
*/
	$(".tianjia-text1").focus(function(){
			text1_focus ++;
			
	});
	$(".tianjia-text2").focus(function(){
			text2_focus ++;
			if(text2_first){
				$(".body #tianjia .tianjia-text2").val("");
				text2_first = false;
			}
			
	});
	$(".tianjia-text1").blur(function(){
			text1_focus --;
	});
	$(".tianjia-text2").blur(function(){
			text2_focus --;
	});
	//
	
	/*未完成
		$(".tianjia-text1").keypress(function(){
			var value = $(this).val();
			var text1_len = len(value);	
			if(text1_len>15){
				event.preventDefault();	
			}			
	});
	*/
	$("input").keypress(function(){
		if(event.keyCode == 13){
			$("#tianjia-ok").click();
		}
	});
	//添加的事件
	$(".body #tianjia-ok").click(function(){
		
		if(is_edit==1) return false;
			var name = trim($(".body:eq("+(3-now_lpage)+")").find("#tianjia input:eq(0)").val());
			var site = $(".body:eq("+(3-now_lpage)+")").find("#tianjia input:eq(1)").val();
			if(check_add(name,site)){
				var n_class ="self-w2";
		
				if($(".body:eq("+(3-now_lpage)+")").find(".self-w2").length == 0){
					n_class = "self-w3";
				}
				var  all_num =$(".body:eq("+(3-now_lpage)+")").find("."+n_class).length;
				var   add = '';		
				
							
				if(all_num == 1)
				{
					add = "&add=1|"+ $(".body:eq("+(3-now_lpage)+")").find("."+n_class+":first").attr("alt");
					$(".body:eq("+(3-now_lpage)+")").find("."+n_class+":first").attr("name","0");
				}else if(all_num >1){
					
					add = "&add=2|"+$(".body:eq("+(3-now_lpage)+")").find("."+n_class+":last").prev().attr("name")+"|"+$(".body:eq("+(3-now_lpage)+")").find("."+n_class+":last").attr("alt");
					
				}
				$.get("user.php?action=add&name="+name+"&site="+site+add,function(result){
						result=result.split("|");
						var name;
						var title;
						var id;
						var site;
						if(result.length==5){
							$(".body:eq("+(3-now_lpage)+")").find("."+n_class+":last").attr("name",result[0]);
							id =  result[1];
							name = result[2];
							title = result[3];	
							site =  result[4];							
						}else{
							id =  result[0]
							name = result[1];
							title = result[2];
							site =  result[3];			
						}
						$(".body #r-text-con").append('<li class="self-w3 cancle" title="'+title+'" alt="'+id+'" name="1000" >'+'<a href="'+site+'" target="_blank">'+name+'</a></li>');
						$(".body #tianjia").hide();
						$(".body #tianjia input").val('');
						$(".body #dele").attr("id","jia");
						$(".body #bian").show();
						count_list();
						is_add = false;
				})
			}
			
	});
	
}

var is_edit =0;
var is_already_edit = 0;  //是不是已经编辑过，用于减少加载js
function edit(){
	$(".body #r-inside-button #bian").click(function(){
		//编辑的变化
		if(is_add){
			show_error('添加状态下禁止');
			return false
			};
		if($(this).attr("id")=="bian"){
		$(".body #bian").attr("id","back");
		$(".body #jia").hide();
		}else{
			$(".body #back").attr("id","bian")
			$(".body #jia").show();
		}
		if(is_edit == 0){
			$(".body:eq("+(3-now_lpage)+")").find(".self-w3").each(function(){
				//更改样式
				var name = $(this).find("a").html();
				var site = $(this).find("a").attr("href");
				var id =  $(this).find("a").attr("alt");
				var change = '<div class="self-w1-text"><p alt="'+site+'">'+name+'</p></div><a alt="'+id+'" class="s-bian" href="#">修</a><a  alt="'+id+'" class="s-delete" href="#">删</a>';
				$(this).html(change);
				$(this).attr("class","self-w2");
				
				var add = '';
				if(is_already_edit == 0 ){//动态添加js
				 add += '<script src="admin/js/development-bundle/ui/jquery.ui.core.js"></script><script src="admin/js/development-bundle/ui/jquery.ui.widget.js"></script><script src="admin/js/development-bundle/ui/jquery.ui.mouse.js"></script><script src="admin/js/development-bundle/ui/jquery.ui.sortable.js"></script>';
				 is_already_edit = 1;		
				$("head").append(add);				
				}
				
				
				$.getScript("js/sortable.js");
				
			});
			is_edit = 1;
			
				
			//加载修改以及删除事件
			edit_action();

			

		}
		else{//取消编辑状态
			$(".body .self-w2").unbind();
			$(".body .self-w2").each(function(){
				var name = $(this).find("p").html();
				var site = $(this).find("p").attr("alt");	
				var change = '<a href="'+site+'" target="_blank">'+name+'</a>';
				$(this).html(change);
				$(this).attr("class","self-w3 cancle");
				var tmp = $(this).css("background-image","");
			});
			is_edit = 0;
		}
	});
	
	//同步拖拉事件
	var allow_tongbu =true;
	$(".body #right-back").mouseleave(function(){
		if(allow_tongbu)
		{	
			$(".body:eq("+ (3-now_lpage+1) % 3 +")").find("#r-text-con").html($(this).find("#r-text-con").html());			
			$(".body:eq("+ (3-now_lpage+2) % 3 +")").find("#r-text-con").html($(this).find("#r-text-con").html());
			edit_action();
		}	
	});
}


function edit_action(){
	//事件重新安排
	$(".body .self-w2 .s-delete").unbind();
	$(".body .self-w2 .s-bian").unbind();
	$(".body .self-w2 .s-delete").click(function(){
		var id =$(this).parent().attr("alt");
		
		$.get("user.php?action=delete&id="+id,function(result){			
			if(result == 'true'){
				success =true;
				$(".body .self-w2[alt="+id+"]").remove();
				count_list();
			}
			else{
				success = false;
					show_error("出错鸟~~");
					return false;
			}
		});

	});	
	$(".body .self-w2 .s-bian").click(function(){

		//先隐藏
		$(this).siblings().hide();
		$(this).hide();
		$(this).parent().addClass("cancle");
		
		//出现修改
		var b_name;
		var a_name; 
		var name =  $(this).parent().find('p:eq(0)').html();
		var title = $(this).parent().attr("title");
		if(title==''){
			 b_name = name;
		}else{
			 b_name = title;
		}
		var add ='<div class="bian">'+
				  '<p><input type="text" class="edite-input" value="'+b_name+'"/></p>'+
				  '</div>';
		$(this).parent().append(add);
		$(this).parent().find("input").focus(function(){
		});
		$(this).parent().find("input").focus();
		$(this).parent().find("input").blur(function(){
			var li_id = $(this).parent().parent().parent().attr("alt");
			var li_dom = $(".body").find("#r-text li[alt="+li_id+"]");
			var input_dom = $(this);
;			

			a_name = $(this).val();
			if(!check_name(a_name)){//名字有问题重新写
				$(li_dom).find(".bian").remove();
				$(li_dom).children().show();
				$(li_dom).removeClass("cancle");
				return;
			}
			var id = $(this).parent().parent().parent().attr("alt");
			$.get("user.php?action=edite&id="+id+"&name="+a_name,function(result){
	
				if(result=='false'){
					show_error("操作失败了~~~");	
				}else{
					result = result.split("|");
					name = result[0];
					title = result[1];
					
					$(li_dom).attr("title",title);
					$(li_dom).find("p:eq(0)").html(name);
					
					$(li_dom).find(".bian").remove();
					$(li_dom).children().show();
					$(li_dom).removeClass("cancle");
				}
			});
			
			
		});
		
	});
	//鼠标移上的事件
	$(".body .self-w2").unbind();
	$(".body .self-w2").mouseover(function(){
		var tmp = $(this).css("background-image").replace("r-text-border.png","r-text-border-on.png");
		
		$(this).css("background-image",tmp);	
	});
	$(".body .self-w2").mouseleave(function(){
		var tmp = $(this).css("background-image").replace("r-text-border-on.png","r-text-border.png");
		$(this).css("background-image",tmp);	
	});
}

function right_con(){
	
}


var now_pos = 0;
var time_out_queue;

function up_down_action(){

	$(".body #r-inside-button #up-go").mousedown(function(){
		time_out_queue = setTimeout(up,25);
		event.preventDefault();	
	});	
		$(".body #r-inside-button #up-go").mouseup(function(){
		clearTimeout(time_out_queue);
		event.preventDefault();	
	});	
	
	$(".body #r-inside-button #down-go").mousedown(function(){
		time_out_queue = setTimeout(down,25);
		event.preventDefault();	
	});
	$(".body #r-inside-button #down-go").mouseup(function(){
		clearTimeout(time_out_queue);
		event.preventDefault();	
	});	
}

function up(){
	count_list();
		if(now_pos<0){
				now_pos += 5;
				$(".body #r-text-con").css("top",now_pos+"px");		
				time_out_queue = setTimeout(up,25);	
				
		}
		return false;

}

function down(){
	count_list();
		if(height-con_height+now_pos>0){
				now_pos -= 5;
				$(".body #r-text-con").css("top",now_pos+"px");
				time_out_queue = setTimeout(down,25);
				
		}
		
		return false;
}

//自动加载编辑移动的js,用于减少页面初始负担
function load_script(){
	function add_script(){
		var add= '<script src="admin/js/development-bundle/ui/jquery.ui.core.js"></script><script src="admin/js/development-bundle/ui/jquery.ui.widget.js"></script><script src="admin/js/development-bundle/ui/jquery.ui.mouse.js"></script><script src="admin/js/development-bundle/ui/jquery.ui.sortable.js"></script>';
		if(is_already_edit == 0 ){//动态添加js	 
				 is_already_edit = 1;		
				$("head").append(add);				
		}
	}
	setTimeout(add_script,2000);
	
}


var name_len = 30;
var site_len = 120;

//辅助函数
function check_add(name,site)
	{	
		//检查名字
		if(name =='')
		{
			show_error('说好的名字呢？'); 
			return false;
		}
		if(name.length>name_len)
		{	
			show_error('名字长度超过30了'); 
			return false;
		}
		if(len(site)>site_len)
		{
			
			show_error('网址长度超过了！');
			return false; 
		}
		//检查网址
		//var patten =/^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)(:[0-9]{1,5})?|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])(:[0-9]{1,5})?)(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/;
		
		var patten = /^((https?|ftp|news):\/\/)?([^\s"<>\.\*]+)(\.[^\s"<>\.\*]+)+$/; //为了扩大限制而设置的
		var  rs = patten.exec(site);
		if ( rs == null)
		{
			show_error('网址格式有误！');
			return false;
		}
		return true;
	}

function check_name(name){
	if(name =='')
		{
			show_error('说好的名字呢？'); 
			return false;
		}
	if(name.length>name_len)
		{	
			show_error('名字长度超过30了'); 
			return false;
		}
	return true;	
}

function len(s) {
 var l = 0;
 var a = s.split("");
 for (var i=0;i<a.length;i++) {
  if (a[i].charCodeAt(0)<299) {
   l++;
  } else {
   l+=2;
  }
 }
 return l;
}
function m_substr(str,lenth){
	var a = str.split("");
	var str_return='';
	var tmp;
	 for(var i=0;i<lenth;) {
		str_return += a[i];
		var reg=/[^\x00-\xff]/g;
	 if (reg.test(a[i])) {
  		  i+=2;
	  } else {
 		  i++;
	  } 	 
 	}
	
	return str_return;
}

function   trim(str){
	for(var i = 0; i < str.length && str.charAt(i)==" "; i++ );
	for(var j = str.length; j>0 && str.charAt(j-1)==" "; j--);
	if(i >= j )   return   "";  
	return   str.substring(i,j);  
}
	
function show_error(msg){
	 $(".body #message-box p").html(msg);
	 $(".body #message-box").fadeIn('slow');
	 delayTime = setTimeout(function() {
                $(".body #message-box").hide();
            },3000)
			
	
}	