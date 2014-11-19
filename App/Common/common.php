<?php
/**
 * 判断是否登录
 * @return boolean
 */
function isLogged(){
	if (!empty($_SESSION['account'])){
		return true;
	}else{
		return false;
	}
	
}

function getList(String $modelNamme, $map = array(), $order){
	$model = D('Usersite');
	$data = $model->where($map)->order($order)->select();
	return $data;
}

/**
 * 提取出url的首页
 * 如：http://www.weibo.com/comment/inbox?topnav=1&wvr=5&mod=message&f=1
 * 返回：http://www.weibo.com
 * @param string $url
 * @return string
 */
function getHost($url){
// 	$url = 'http://www.weibo.com/comment/inbox?topnav=1&wvr=5&mod=message&f=1';

	$pattern = "#((https?|ftp|news):\/\/)?([\w]+\.)?([\w-]+\.)(com|net|org|gov|cc|biz|info|cn|edu)(\.(cn|hk))*#";
	preg_match($pattern, $url, $match);
	return $match[0];
}

/**
 * 得到sonhost 
 * @param string $url http://www.baidu.com
 * @return String www.baidu.com
 */
function getSonHost($url){
	$pattern = "#([\w]+\.)?([\w-]+\.)(com|net|org|gov|cc|biz|info|cn|edu)(\.(cn|hk))*#";
	preg_match($pattern, $url, $match);
	return $match[0];
}


/**
 * 获取url的顶级域名
 * 如：www.baidu.com 则返回baidu.com
 * @param string $url
 * @return string
 */
function getDomain($url){
	//http://www.google.com/s2/favicons?domain=google.com.hk
	$pattern = "/[\w-]+\.(com|net|org|gov|cc|biz|info|cn|edu)(\.(cn|hk))*/";
	preg_match($pattern, $url, $matches);
	if(count($matches) > 0) {
		return $matches[0];
	}else{
		$rs = parse_url($url);
		$main_url = $rs["host"];
		if(!strcmp(long2ip(sprintf("%u",ip2long($main_url))),$main_url)) {
			return $main_url;
		}else{
			$arr = explode(".",$main_url);
			$count=count($arr);
			$endArr = array("com","net","org","3322");//com.cn  net.cn 等情况
			if (in_array($arr[$count-2],$endArr)){
				$domain = $arr[$count-3].".".$arr[$count-2].".".$arr[$count-1];
			}else{
				$domain =  $arr[$count-2].".".$arr[$count-1];
			}
			return $domain;
		}// end if(!strcmp...)
	}// end if(count...)
}



/**
 * 获取head之间的js引用
 *
 * @param js文件路径数组
 */
function get_js($array = array()) {
    if (!is_null($array)) {
        $js_src = '';
        foreach ($array as $js) {
            $js_src .= '<script src="' . $js . '"></script>' . "\n";
        }
        echo $js_src;
    }
}
/**
 * 获取head之间的css引用
 *
 * @param css文件路径数组
 */
function get_css($array = array()) {
    if (!is_null($array)) {
        $css_href = '';
        foreach ($array as $css) {
            $css_href .= '<link rel="stylesheet" type="text/css" href="' . $css . '" />' . "\n";
        }
        echo $css_href;
    }
}

/**
 * 
 * 获取一个类型的所有站点
 * @param int $typeId
 * @return array
 */
function get_site($typeId){
	$Site = new SiteModel();
	return $Site->getSiteByTypeId($typeId);
}




















?>