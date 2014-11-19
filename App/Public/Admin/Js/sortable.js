// JavaScript Document
$(function(){
	$( ".body #r-text-con" ).sortable({
cancel: ".cancle",
update:function(){
	var now_dom 
	 $(".body:eq("+(3-now_lpage)+")").find(".self-w2").each(function(){
		if($(this).attr("alt") == id_click){
			now_dom =$(this);
			now_dom =now_dom[0];
			}
		});
	after_position = $(now_dom).prevAll().length+1;

	var order ='';
	if(all_num>2){
		if(after_position == 1){//移到了第一个
			$(now_dom).attr("name","0");
			order = '1|'
			order +=$(now_dom).attr("alt")
			order +='|'
			order +=$(now_dom).next().attr("alt")
			order +='|'
			order +=$(now_dom).next().next().attr("name");
			
		}else if(after_position == all_num){//最后一个 
	  
			order =  '2|'
			order +=$(now_dom).prev().prev().attr("name")
			order +='|'
			order +=$(now_dom).prev().attr("alt")
			order +='|'
			order +=$(now_dom).attr("alt");
			$(now_dom).attr("name","1000");
		}else{//移动了中间
			order = '' ;
			order +="3|"+$(now_dom).prev().attr("name");
			order +="|";
			order +=$(now_dom).attr("alt");
			order +="|";
			order +=$(now_dom).next().attr("name");
		}
	}else{//只有两个的情况才会触发这个事件
	
		order = '4|'+$(".body:eq("+(3-now_lpage)+")").find(".self-w2:eq(0)").attr("alt")+'|'+$(".body:eq("+(3-now_lpage)+")").find(".self-w2:eq(1)").attr("alt");
		
		$(".body:eq("+(3-now_lpage)+")").find(".self-w2:eq(0)").attr("name","0");
		$(".body:eq("+(3-now_lpage)+")").find(".self-w2:eq(1)").attr("name","1000");
	}
	var get ="user.php?action=order&order="+order;
	$.get(get,function(reslut){
			eval(reslut);
	});
	}}
		);
	$( "#sortable" ).disableSelection();
	});


var id_click ;
var pre_position ;
var after_position;
var all_num ;




$(".self-w2").mousedown(function(){
	id_click = $(this).attr("alt");
    all_num =$(".body:eq("+(3-now_lpage)+")").find(".self-w2").length;
	pre_position =$(this).prevAll().length+1;
});

function sortable_success(){	

}