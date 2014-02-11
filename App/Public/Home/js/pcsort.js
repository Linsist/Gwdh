var source; //从哪一页开拖动，
var destin; //拖动到哪一页
var isScrolling = false; //是否正在滚动，用于同步

$(document).ready(function() {
	// sortWebsite();
	var scollArea = document.getElementById('include_web');
	addScrollListener(scollArea,wheelHandle);
	setIncludeWebWidth();
	sideScroll();
});	//end of ready


/**
 * 动态设置include_web的宽度
 */
function setIncludeWebWidth(){
    var thea = $('.pc_nomalwebsite');
    var length = thea.length;
    var oldWidth = parsePxToInt(thea.css('width'));
    var marginRight = parsePxToInt(thea.css('margin-right'));
    var marginLeft = parsePxToInt(thea.css('margin-left'));
    var newWidth = (oldWidth+marginLeft+marginLeft)*parseInt(length);
    $('#include_web').css({width:newWidth+'px'});
}





/**
 * 
 */
function wheelHandle(event){
	// alert(1);
	scrollTo(getWheelData(event));
	// $('.search_input').val(22);
}

/**
 * 切换显示
 * @param direction 方向
 */
function scrollTo(dir){
	if (isScrolling) {
		isScrolling = false;
		return false;
	}
	var scrollul = $('.pc_nomalwebsite');
	var s_width = parsePxToInt(scrollul.css('width'));
	var s_margin_right = parsePxToInt(scrollul.css('margin-right'));
	var s_margin_left = parsePxToInt(scrollul.css('margin-left'));
	var scrollWidth = s_width + s_margin_right+s_margin_left;
		// alert(scrollWidth);
	var element = $('#include_web');
	var	oldLeft = (parsePxToInt(element.css('left'))+200);
	if (oldLeft% scrollWidth!=0) {
		// isScrolling = true;
		return false;
	}
	if (dir>0) {
		if (oldLeft>=0) {return false;}
		newleft = oldLeft + scrollWidth-200;
		newleft = newleft + 'px';
		element.animate({'left':newleft},300);
		// $('#all').append('右');
	}else{
		if (oldLeft<=-getAllWidth(scrollul)) {return false;}
		newleft = oldLeft - scrollWidth-200;
		newleft = newleft + 'px';
		element.animate({'left':newleft},300);
		// $('#test').append('左');
	}
	isScrolling = true;
}


//把像素转化为数字
function parsePxToInt(px){
	var num = px.split('px');
	return parseInt(num[0]);
}

/**
 *获取包括padding_left,right,width的和
 *@param obj thea
 */
function getAllWidth(thea){
	var width,marginRight;
	width = parsePxToInt(thea.css('width'));
	marginRight = parsePxToInt(thea.css('margin-right'));
	marginLeft = parsePxToInt(thea.css('margin-left'));
	return (width+marginRight+marginLeft)*(thea.length-1);
}


function sideScroll(){
	var sourcePage=1;
	var destPage=1;
	var allowScroll = true;
	var isDragging = false;

	$('.pc_nomalwebsite a').mousedown(function(){
		
		sourcePage = $(this).parent('.pc_nomalwebsite').attr('alt');
		destPage = sourcePage;
		isDragging = true;

	}).mouseup(function(){
		// alert(12);
		isDragging = false;
	});

	$('.pc_nomalwebsite').mousemove(function(event){
		// var nowPage = $(this).index();
		// var len = $(this).children('a').length;
		var left = $(this).parent('#include_web').css('left');
		//这个是插件里面拖动的时候自动生成的一个节点，只在当前拖动的div存在
		var ph = $('[data-placeholder="true"]');
		var page = ph.parent('.pc_nomalwebsite').attr('alt');
		destPage = page;
		// $('.search_input').val(destPage);
		
	});

	$('#leftBar').mouseenter(function(){
		// scrollTo(1);
	});
	$('#rightBar').mouseenter(function(){
		// scrollTo(-1);
	});

	$('.pc_nomalwebsite a.siteSquare').mousemove(function(event){
		// alert(event.pageX);
		// return ;
		if (isDragging) {
			var draggingX = event.clientX-event.offsetX;
			var draggingY = event.clientY-event.offsetY;
			draggingX = parseInt(draggingX);
			if (draggingX<30) {//向左滑动
				setTimeout(function(){allowScroll=true;},800);
				if (allowScroll == true) {
					scrollTo(1);
					allowScroll = false;
				}
			}

			if (draggingX>1111) {//向右滑动
				setTimeout(function(){allowScroll=true;},800);
				if (allowScroll == true) {
					scrollTo(-1);
					allowScroll = false;
				}
			}
			
			if ( destPage != undefined && sourcePage !=destPage) {
				// $('.search_input').val('s:'+sourcePage+'/d:'+destPage);
				moveSiteWhenFull(sourcePage, destPage);
				sourcePage = destPage;
			}else{
				// $('.search_input').val(destPage);
			}
		}//end of if isDragging
		
	});
}

/**
 * 当前页或者目的页满了的时候,方块的排序
 * @param int page
 */
function moveSiteWhenFull(sourcePage,destPage){
	var dp = $('.pc_nomalwebsite[alt="'+destPage+'"]');
	var sp = $('.pc_nomalwebsite[alt="'+sourcePage+'"]');
	var pageNum = $('.pc_nomalwebsite').length;
	var dpIndex = parseInt(destPage);
	var spIndex = parseInt(sourcePage);
	var dpLen = dp.children('a.siteSquare').length;
	var spLen = sp.children('a.siteSquare').length;
	var dpson = dp.find('a.siteSquare');
	


	// 从前一页拖到后一页
	if (spIndex<dpIndex) {
		
		for (var i = spIndex; i < dpIndex; i++) {
			var pre = $('.pc_nomalwebsite[alt="'+i+'"]');
			var next = $('.pc_nomalwebsite[alt="'+(parseInt(i)+1)+'"]');
			var preLen = pre.find('a.siteSquare').length;
			var nextLen = next.find('a.siteSquare').length;
			
			if (dpLen>=8) {
				var temp = next.children('a.siteSquare:first');
				// $('.search_input').val();
				pre.find('a.pc_right_noweb').hide();
				next.find('a.pc_right_noweb').hide();
				pre.append(temp);
				break;
			};

			// if(preLen < 8 && nextLen<8){
			// 	// alert(1);
			// 	break;
			// }else if (preLen>=8 && nextLen>=8) {//两个都大于8
			// 	var temp = next.children('a.siteSquare:first');
			// 	// $('.search_input').val();
			// 	pre.find('a.pc_right_noweb').hide();
			// 	next.find('a.pc_right_noweb').hide();
			// 	pre.append(temp);
			// 	break;
			// }else if(pre<8 && next>=8) {};{
			// 	// var temp = next.children('a.siteSquare:first');
			// 	// pre.append(temp);
			// 	// pre.find('a.pc_right_noweb').hide();
			// 	// next.find('a.pc_right_noweb').hide();
			// 	break;
			// }

			// if (preLen<8) {
			// 	pre.find('a.pc_right_noweb').show();
			// }
			// if(nextLen<8){
			// 	nex.find('a.pc_right_noweb').show();
			// }
		}			
	}
	// // $('.search_input').val('s:'+spIndex+'/d:'+dpIndex+ '/len:'+ pre.children('a.siteSquare').length);

	// //从后一页拖到前一页
	// if (spIndex>dpIndex) {
	// 	for (var i = dpIndex; i < $('.pc_nomalwebsite').length; i++) {
	// 		var pre = $('.pc_nomalwebsite[alt="'+i+'"]');
	// 		var next = $('.pc_nomalwebsite[alt="'+(parseInt(i)+1)+'"]');
	// 		if (pre.children('a.siteSquare').length>=8) {
	// 			pre.find('a.pc_right_noweb').hide();
	// 			var temp = pre.children('a.siteSquare:last');
	// 			next.prepend(temp);
	// 		}else{
	// 			// pre.find('a.pc_right_noweb').show();
	// 		}
	// 	// $('.search_input').val('s:'+spIndex+'/d:'+dpIndex+ '/len:'+ pre.children('a').length);	

	// 	}
	// }//end of if

	
}


function checkSquareNumByPage(page){
	var now = $('.pc_nomalwebsite[alt="'+page+'"]');
	var son = now.find('a.siteSquare');
	$('.search_input').val(son.length);
	if (son.length>=7) {
		now.find('a.pc_right_noweb').hide();
	}else{
		now.find('a.pc_right_noweb').show();
	}
}
function checkDestNum(page){
	var now = $('.pc_nomalwebsite[alt="'+page+'"]');
	var son = now.find('a.siteSquare');
	$('.search_input').val(son.length);
	if (son.length>=7) {
		now.find('a.pc_right_noweb').hide();
	}
}

function checkSourceNum(page){
	var now = $('.pc_nomalwebsite[alt="'+page+'"]');
	var son = now.find('a.siteSquare');
	$('.search_input').val(son.length);
	if (son.length<=8) {
		now.find('a.pc_right_noweb').show();
	}
}

