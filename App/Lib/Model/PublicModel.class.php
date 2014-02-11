<?php
class PublicModel extends Model{
	
	public function test(){
		echo $this->getModelName();
	}
	
	/**
	 * 根据模型名，保存截得的图片  如：Usersite 和 site共用
	 * @param int $id 个人收藏网址的id
	 * @param string $logo 网址的logo图片的名字
	 */
	public function saveWebshot($id,$logo){
		$data = array('logo'=>$logo);
		if($this->where(array('id'=>$id))->save($data)){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 网址截图
	 * @param string $url 要截屏的url ,
	 * @return string $logo 截取的图片的名字
	 */
	public function webShot($url){
		header("Content-type:text/html;charset=utf-8");
		//要截图的网址
// 		$url = 'http://www.weibo.com';//http://weibo.com
		//输出图片的位置与名称
		$dirname = dirname(dirname(dirname(__FILE__)));
		$dir = $dirname.'\Public\uploads\webshot\\';
// 		$logo = getSonHost($url).'_'.date('YmdHis').'.png';

		$logo = getSonHost($url).'.png';
		$out = $dir.$logo;
		$webshot = dirname($dirname).'\webshot\url2bmp.exe';
		$cmd = "$webshot -url $url -format png -file $out -wx 1280 -wy 780 -bx 230 -by 140 -maximize -wait 1 -removesb -notinteractive";
		system($cmd);
		return $logo;		
	}
	
	/**
	 * 给site 格式化，如果没有http://则自动加上http
	 * @param String $site
	 * @return string
	 */
	public function parseSite($site){
		if (empty($site)){
			return '';
		}else{
			$reg = "#^((https?|ftp|news):\/\/){1}#";
			if(!preg_match($reg,$site)){//自动加http头
				$site = 'http://'.$site;
			}
			return $site;
		}
	}
	
	public function checkIsRightUrl($url){
		$pattern = "#((https?|ftp|news):\/\/)?([\w]+\.)?([\w-]+\.)(com|net|org|gov|cc|biz|info|cn|edu)(\.(cn|hk))*#";
		if(preg_match($pattern, $url, $match)){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	
}