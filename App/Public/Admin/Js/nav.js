/*********************************
���ļ���Ҫ��ʵ�����û������޹صĹ���
*********************************/

var now_but = new Array();
now_but.push(1,1,1);
var heigh = 125;
var arrow_speed = 300;
var img_width = 462;
function left_left(){
	if(left_button_action){
	 $(".body").find("#left-but1").css("left","6px");
	}
		for(var i=0;i<3;i++)
		{
			 $(".body").find("#left-but"+(i+1)).mouseover(function(){
				 var i =now_lpage-1;
				 if(left_button_action){
					$(this).parent().find("#left-but"+now_but[i]).css("left","13px"); 
					$(this).css("left","6px");
				}
				now_but[i] = get_last_num($(this).attr("id"));
				var tmp = (now_but[i]-1)*heigh+80;
				$(this).parent().next().children().stop().animate({top:tmp+"px"},arrow_speed);				
				var textbox = (now_lpage-1)*3+now_but[i]-1;

				
				$(".body:eq("+(3-now_lpage)+")").find("#maintext").empty();				
				$(".body:eq("+(3-now_lpage)+")").find("#maintext").prepend($("#web_list").find(".textbox:eq("+textbox+")").clone(true)	);
				$(".body:eq("+(3-now_lpage)+")").find("#maintext").css("background-position",(1-now_but[i])*img_width + 'px 0px') ;
				
			});
			

		}
		
	}


var p_width = 116;
var dom;  //��¼��ǰ��Ҫ�ƶ���dom�ڵ�
var distance;  //�ƶ��ľ���
var time_quene; //ʱ�����
var move_speed = 1000;  //�ƶ��ٶ�
function move_back(){
	$(dom).animate({'left':"0px"},move_speed,function(){
			time_quene = setTimeout("move()",2000);
		})
	}
function move(){	

		$(dom).animate({'left':"-"+distance+"px"},move_speed,function(){
			time_quene = setTimeout("move_back()",2000);
		})
}


function left_con(){
	//�б���ʽ�޸�
	$("#web_list").find(".textbox:eq(0)").find(".w1 a").mouseover(function(){
		$(this).children(".li-left").attr("class","li-left2");	
		$(this).children(".li-text").attr("class","li-text2 g");	
		$(this).children(".li-right").attr("class","li-right2");
	});
	$("#web_list").find(".textbox:eq(1)").find(".w1 a").mouseover(function(){
		$(this).children(".li-left").attr("class","li-left2");	
		$(this).children(".li-text").attr("class","li-text2 g");	
		$(this).children(".li-right").attr("class","li-right2");
	});
	$("#web_list").find(".textbox:eq(2)").find(".w1 a").mouseover(function(){
		$(this).children(".li-left").attr("class","li-left2");	
		$(this).children(".li-text").attr("class","li-text2 g");	
		$(this).children(".li-right").attr("class","li-right2");
	});
	$("#web_list").find(".textbox:eq(3)").find(".w1 a").mouseover(function(){
		$(this).children(".li-left").attr("class","li-left2");	
		$(this).children(".li-text").attr("class","li-text2 o");	
		$(this).children(".li-right").attr("class","li-right2");
	});
	$("#web_list").find(".textbox:eq(4)").find(".w1 a").mouseover(function(){
		$(this).children(".li-left").attr("class","li-left2");	
		$(this).children(".li-text").attr("class","li-text2 o");	
		$(this).children(".li-right").attr("class","li-right2");
	});
	$("#web_list").find(".textbox:eq(5)").find(".w1 a").mouseover(function(){
		$(this).children(".li-left").attr("class","li-left2");	
		$(this).children(".li-text").attr("class","li-text2 o");	
		$(this).children(".li-right").attr("class","li-right2");
	});
	$("#web_list").find(".textbox:eq(6)").find(".w1 a").mouseover(function(){
		$(this).children(".li-left").attr("class","li-left2");	
		$(this).children(".li-text").attr("class","li-text2 b");	
		$(this).children(".li-right").attr("class","li-right2");
	});
	$("#web_list").find(".textbox:eq(7)").find(".w1 a").mouseover(function(){
		$(this).children(".li-left").attr("class","li-left2");	
		$(this).children(".li-text").attr("class","li-text2 b");	
		$(this).children(".li-right").attr("class","li-right2");
	});
	$("#web_list").find(".textbox:eq(8)").find(".w1 a").mouseover(function(){
		$(this).children(".li-left").attr("class","li-left2");	
		$(this).children(".li-text").attr("class","li-text2 b");	
		$(this).children(".li-right").attr("class","li-right2");
	});
	$(".w1 a").css("cursor","pointer");
	
	$(".w1 a").mouseleave(function(){
		$(this).children(".li-left2").attr("class","li-left");	
		$(this).children(".li-text2").attr("class","li-text");	
		$(this).children(".li-right2").attr("class","li-right");			
	});
	
	//��ʾ���ڵ�������
	$(".w1 a").mouseover(function(){
		
		var span_width = $(this).find("span").width();	
		if(span_width > p_width){
			distance = span_width-p_width;
			if(distance > 40){//�����ʱ���ƶ�������
				move_speed = 2000;
			}else{
				move_speed = 1000;
			}
			$(this).find("span").stop();
			dom = $(this).find("span");
			move();
		}	
	});
	$(".w1 a").mouseleave(function(){
		$(this).find("span").stop();
		clearTimeout(time_quene);
		$(this).find("span").animate({'left':"0px"},move_speed);
	});
	
	
	$(".body:eq(2)").find("#maintext").prepend($("#web_list").find(".textbox:eq(0)").clone(true));
	$(".body:eq(1)").find("#maintext").prepend($("#web_list").find(".textbox:eq(3)").clone(true));
	$(".body:eq(0)").find("#maintext").prepend($("#web_list").find(".textbox:eq(6)").clone(true));

	
}

var now_lpage = 3;
var now_route = 'b';
var tmp_now ;
var reg = /imgs\/[b|o|g]/;
var change_success=true; //prevent someone click so fast 
function left_top(){
	 $(".body").find("#up-lbutton").children().click(function(){
		 if(!change_success){return;}//if not prepare,stop
			if(get_last_num($(this).attr("id")) != now_lpage)
		{
			
			var over_ltpage = get_last_num($(this).attr("id"));
			get_route(over_ltpage);//��ȡ��ǰ·��
		
			change_up(now_lpage,over_ltpage);
			
			change_success = false;
			var fade_speed = 500;

			//�л��м��б�
			if(tab_change_action){
				$(".body:eq("+(3-now_lpage)+")").fadeOut(fade_speed);
				$(".body:eq("+(3-over_ltpage)+")").fadeIn(fade_speed,function(){
				change_success=true;
				});
			}else{
				$(".body:eq("+(3-now_lpage)+")").css("display","none");
				$(".body:eq("+(3-over_ltpage)+")").css("display","block");
				change_success=true;	
			}
			
		if(!is_login){//δ��¼��
				var tmp = $("#auto-load").css("background-image");
				var reg = /auto-in-visited.png/;
				
			//�л��Զ���¼ͼ�걳��ͼ
			if(reg.exec(tmp)){				
					if(tab_change_action){

						
						$("#auto-load").hide();
						 var tmp = $("#auto-load").css("background-image").replace(/imgs\/[b|o|g]/,"imgs/"+now_route);
						$("#auto-load").css("background-image",tmp);
						$("#auto-load").show();
					}else{
						$("#auto-load").hide();
						 var tmp = $("#auto-load").css("background-image").replace(/imgs\/[b|o|g]/,"imgs/"+now_route);
						$("#auto-load").css("background-image",tmp);
						$("#auto-load").show();
					}
				}
			}
			//���浱ǰҳ��
			tmp_now = now_lpage;
			now_lpage = over_ltpage;
				
			
		}
	});
	 $(".body").find("#up-lbutton").children().mouseleave(function(){
		if(get_last_num($(this).attr("id")) != now_lpage)
		{
			var tmp = $(this).css("background-image").replace("-on.png",'.png') ;
			$(this).css("background-image",tmp);
		}
	});
	
	 $(".body").find("#up-lbutton").children().mouseover(function(){		
			if(get_last_num($(this).attr("id")) != now_lpage)
		{
			var tmp = $(this).css("background-image").replace('.png',"-on.png") ;
			$(this).css("background-image",tmp);
		}
	});
}

function get_route(over_ltpage){
		switch(over_ltpage){
		case 1:{
			now_route = 'g';
			break
		}
		case 2:{
			now_route = 'o';
			break
		}
		case 3:{
			now_route = 'b';
			break
		}
	}
}

function change_all(over_ltpage,aim){
	 get_route(over_ltpage);
	/*logob title-words-b undefined left-but1 left-but2 left-but3 left-back maintext right-back tianjia-ok*/
	$(".body:eq("+(aim-1)+")").find(".img_change").each(function(){
		var tmp = $(this).css("background-image").replace(reg,'/imgs/'+now_route);
				$(this).css("background-image",tmp);
	});
	

}
function change_up(now_lpage,over_ltpage){
			
			    var tmp =  $(".body").find("#button"+now_lpage).css("background-image").replace("-on.png",'.png') ;
			  		$(".body").find("#button"+now_lpage).css("background-image",tmp);

			    tmp =  $(".body").find("#button"+over_ltpage).css("background-image").replace(over_ltpage+'.png',over_ltpage+"-on.png") ;
			   $(".body").find("#button"+over_ltpage).css("background-image",tmp);
			  
			  
			  /*ԭ���ұ���������ťʱ��js�����ޣ���������
			   $(".body").find("#up-rbutton").children().each(function(){
				 	 var reg = /-([b|o|g])([.|-])/;
					 var rep = "-"+now_route;
					 rep += "$2";
			  		var tmp = $(this).css("background-image").replace(reg,rep);
					$(this).css("background-image",tmp);
			  });
			  */
			  //��������ͬ���¼�������Ӧ������user.js��ģ�������Ϊ�ڴ˴��޸�����
			  if(is_add){
				     var text1 = $(".body:eq("+(3-now_lpage)+")").find(".tianjia-text1").val();
					 var text2 = $(".body:eq("+(3-now_lpage)+")").find(".tianjia-text2").val();
					  $(".body:eq("+(3-over_ltpage)+")").find(".tianjia-text1").val(text1);
					  $(".body:eq("+(3-over_ltpage)+")").find(".tianjia-text2").val(text2);
				  if(text1_focus){
					  					
					   $(".body:eq("+(3-over_ltpage)+")").find(".tianjia-text1").focus();
				
				  }
				   if(text2_focus){
					   $(".body:eq("+(3-over_ltpage)+")").find(".tianjia-text2").focus();
				  }
			  }

}


var now_rpage = 4; //��¼��ǰ���ұ�button��������ɾ����button����ʱû��
function right_top(){

	
	 $(".body").find("#up-rbutton").children().mouseover(function(){		
		if(get_last_num($(this).attr("id")) != now_rpage)
		{
			var tmp ;
			 now_rpage = get_last_num($(this).attr("id"));
			if(now_rpage==4){
				tmp = $(".body").find("#up-rbutton").children("#button4").css("background-image").replace('.png',"-on.png");
				$(".body").find("#up-rbutton").children("#button4").css("background-image",tmp)
				
				
				tmp = $(".body").find("#up-rbutton").children("#button5").css("background-image").replace('-on.png',".png");
				$(".body").find("#up-rbutton").children("#button5").css("background-image",tmp)
				
				$(".body #r-text #r-text-con").show();
				$(".body #r-text #search").hide();
				
			} else{
				tmp = $(".body").find("#up-rbutton").children("#button5").css("background-image").replace('.png',"-on.png");
				$(".body").find("#up-rbutton").children("#button5").css("background-image",tmp)
				
				tmp = $(".body").find("#up-rbutton").children("#button4").css("background-image").replace('-on.png',".png");
				$(".body").find("#up-rbutton").children("#button4").css("background-image",tmp)
				
				$(".body #r-text #r-text-con").hide();
				$(".body #r-text #search").show();
			}
		}
	});

}

//����js
var is_auto_in = false;//��¼�Ƿ��Զ���¼
function top_show(){
	$("#xinlang").mouseover(function(){
		$(this).attr("src","imgs/share/xinlang-on.png");
	})
	$("#xinlang").mouseleave(function(){
		$(this).attr("src","imgs/share/xinlang.png");
	})
	
	$("#tengxun").mouseover(function(){
		$(this).attr("src","imgs/share/QQ-on.png");
	})
	$("#tengxun").mouseleave(function(){
		$(this).attr("src","imgs/share/QQ.png");
	})
	
	
	$("body").find("#auto-load").mouseover(function(){
		get_route(now_lpage);
		if(!is_auto_in){
			var tmp = $(this).css("background-image").replace(/imgs\/[b|o|g](.*).png/,"imgs/"+now_route+"/auto-in-hover.png");
			 $(this).css("background-image",tmp);
		}
	});	
	$("body").find("#auto-load").mouseleave(function(){
		get_route(now_lpage);
		if(!is_auto_in){
			var tmp = $(this).css("background-image").replace(/imgs\/[b|o|g](.*).png/,"imgs/"+now_route+"/auto-in-button.png");
			 $(this).css("background-image",tmp);
		}
	});	
	$("body").find("#auto-load").click(function(){
		if(!is_auto_in){
			$("body").find("#auto-load").each(function(){
				var tmp = $(this).css("background-image").replace(/auto(.*).png/,"auto-in-visited.png");
				 $(this).css("background-image",tmp);
				 			 
			})
			$.get("user.php?action=set_cookie");	
			is_auto_in =true;
		}else{
			$("body").find("#auto-load").each(function(){
				var tmp = $(this).css("background-image").replace(/auto(.*).png/,"auto-in-button.png");
				 $(this).css("background-image",tmp);
			})
			 var tmp = $(this).css("background-image").replace(/auto(.*).png/,"auto-in-hover.png");
			 $(this).css("background-image",tmp);
			 $.get("user.php?action=del_cookie");	
			 is_auto_in = false;
		}
		
	});	
	
	//ע�����ʽת��
		$("body").find("#zhuxiao").mouseover(function(){
		get_route(now_lpage);
		if(!is_auto_in){
			var tmp = $(this).css("background-image").replace(/imgs\/[b|o|g](.*).png/,"imgs/"+now_route+"/zhuxiao-hover.png");
			 $(this).css("background-image",tmp);
		}
	});	
	$("body").find("#zhuxiao").mouseleave(function(){
		get_route(now_lpage);
		if(!is_auto_in){
			var tmp = $(this).css("background-image").replace(/imgs\/[b|o|g](.*).png/,"imgs/"+now_route+"/zhuxiao.png");
			 $(this).css("background-image",tmp);
		}
	});	
}


//opinion-box-textbox
var feedback_success = false;
function feedback(){
	$("#opinion-button a").click(function(){
		var content = $("#opinion-box-text").val();
		if(content == ''){
			return false;
		}
		$.post("user.php",{'action':'feedback','content':content},function(rs){
			
			var tmp = $("#opinion-box-textbox").css("background-image").replace(/share\/(.*).png/,"share/text-box-sent.png");
			$("#opinion-box-textbox").css("background-image",tmp);
		    $("#opinion-box-textbox").children().hide();
			feedback_success = true;
		})
	});
	
	$("#opinion-box").mouseover(function(){
		$(this).stop().animate({'left':'0px'});	
	});
	$("#opinion-box").mouseleave(function(){
		$(this).stop().animate({'left':'-100px'},function(){
			if(feedback_success){
			var tmp = $("#opinion-box-textbox").css("background-image").replace(/share\/(.*).png/,"share/text-box.png");
			$("#opinion-box-textbox").css("background-image",tmp);
		    $("#opinion-box-textbox").children().show();
			$("#opinion-box-text").val("");
			feedback_success = false;
			}
		});	
	});
}



var reg2 =/(.*)imgs\/(.*)\/(.*)"{0,1}\)/;
var version = '';
var left_button_action = true;  //����Ƿ����л�Ч��
var tab_change_action = true;   //�м��Ƿ����л�Ч��
var user_action = true;         //�Ƿ����û�����
var top_action = true;          //�����Ƿ��е�¼Ч��
function pre_all(){
		
	//���ڽ�ֹ��www.guangwaidaohang.com�ķ���
	var url = location.href;
	if(!url.match(/(www.guangwaidaohang.com)|(127.0.0.1)/)){
		location.href = "http://www.guangwaidaohang.com";
	}
	
	//�����Բ���
	version = document.all ? 'IE' : 'others';
	if(version=='IE'){
		version = navigator.userAgent.indexOf("MSIE 6.0")>0 ? 'IE6' :  version;
		version = navigator.userAgent.indexOf("MSIE 7.0")>0 ? 'IE7' :  version;
	}
	if(version == 'IE7'){
		$(".body").css("margin","0 auto");	
		$(".body").css("left","auto");	
	}
	if(version == 'IE6'){
		$("#button-box a").each(function(){
		   var tmp = $(this).css("background-image").replace(".png","-ie.png");
			$(this).css("background-image",tmp);	
		});
		var tmp = $("#l-arrow1").css("background-image").replace(".png",".gif");
		$("#l-arrow1").css("background-image",tmp);	
		//����б�����ȥ��ָ��û��
		$(".w1 p").css("cursor","pointer");
	}
	if(version == 'IE7'|| version == 'IE6'){
		left_button_action = false;
		tab_change_action = false;
		user_action = false;
		top_action = false;
		
		//�л��ұߵı���ͼ
		var tmp = $(".body #right-back").css("background-image").replace("right-back-unload.png","right-back-unload-ie.png");
		$(".body #right-back").css("background-image",tmp);
		
		//�л����ϵ�¼ͼ��
		$("#xinlang").attr("src","imgs/share/xinlang-ie.png");
		$("#xinlang").attr("title","�������õ�����Ч����ʹ�ø߰汾���������");
		$("#tengxun").attr("src","imgs/share/qq-ie.png");
		$("#tengxun").attr("title","�������õ�����Ч����ʹ�ø߰汾���������");
		$("#auto-load").hide();
		//��ֹ���
		$("#xinlang").click(function(){return false;})
		$("#tengxun").click(function(){return false;})
	}

	
	
	    //���ڼ�¼��Ҫ�仯��Ԫ��
		$("*").each(function(){
		if($(this).css("background-image") != 'none'){
				if(reg.exec($(this).css("background-image"))){
					$(this).addClass("img_change"); 
				}		
		}
	
		});	
	
	//����������帱��
	$(".body:eq(0)").clone().insertAfter(".body:eq(0)");
	$(".body:eq(0)").clone().insertAfter(".body:eq(0)");
	$(".body:eq(1)").hide();
	$(".body:eq(2)").hide();
	
	 change_all(1,3); //������ɫҳ��
	 
	 change_up(3,1);
	 $(".body:eq(2)").show(); //��ʾ��ɫҳ��
	 now_lpage = 1;  //���õ�ǰҳ���� 
	 change_all(2,2); //������ɫҳ��
	
}


$(document).ready(function(){

<!--��ʼ������js -->
	pre_all();
<!--��ʼ���б� -->
	left_con();
<!--��ߵ��� -->
   left_left();
<!--���ϵ��� -->
	left_top();
<!--�м��б� -->
   

<!--�ұߵ��� -->

<!--�������� -->
if(top_action){
 	top_show();
}
$("#auto-load").click();
<!--����js-->
feedback();
});
<!--���ܺ��� -->
function get_last_num( msg){
	return parseInt(msg.substr(msg.length-1,1));
}