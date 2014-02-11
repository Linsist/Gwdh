<?php
class PublicAction extends Action{
	
	public function __construct(){
		parent::__construct();
		$model = new AccountsModel();
		$account = $model->getAccount();
		if ($account)	$model->setSession($account);
			
		
	}
	
	function captcha(){
		import('ORG.Util.Image');
    	Image::buildImageVerify(4,1,'png',48,26);
	}
	
	/**
	 * 
	 * ajax 判断验证码
	 */
	function checkCaptcha(){
		
		$captcha = $_POST['captcha'];
		if($_SESSION['verify']== md5($captcha)){
			
			$this->ajaxReturn('','',1);
		}else{
			$this->ajaxReturn('','验证码错误',0);
		}
	}

// 	/**
// 	 * 网址截图
// 	 * @return json
// 	 */
// 	public function webShot(){
// 		//     	$url = $_POST['url'];
// 		$id = $_POST['id'];
// 		header("Content-type:text/html;charset=utf-8");
// 		//要截图的网址
// 		$url = 'http://www.weibo.com';//http://weibo.com
// 		//输出图片的位置与名称
// 		$dirname = dirname(dirname(dirname(dirname(__FILE__))));
		 
// 		$dir = $dirname.'\Public\uploads\webshot\\';
// 		$logo = time().'_webshot.png';
// 		$out = $dir.$logo;
// 		$webshot = dirname($dirname).'\webshot\url2bmp.exe';
// 		$cmd = "$webshot -url $url -format png -file $out -wx 1366 -wy 768 -bx 230 -by 130 -maximize -wait 1 -removesb -notinteractive";
// 		system($cmd);
		
// 		$model = D($this->getActionName());
// 		if ($model->saveWebshot($id, $logo)){
// 			$this->ajaxReturn($id,$logo,1);
// 		}else{
// 			$this->ajaxReturn('','保存失败',0);
// 		}
		 
// 	}
	
	
	function getHost(){
		$url = 'http://auth.gdufs.edu.cn';
// 		$pattern = "#((https?|ftp|news):\/\/)?([\w]+\.)?([\w-]+\.)(com|net|org|gov|cc|biz|info|cn|edu)(\.(cn|hk))*#";
// 		preg_match($pattern, $url, $match);
// 		var_dump($match);

		var_dump(getHost($url));
	}
	
	function test(){
		$model = D($this->getActionName());
		$url = getHost('http://qgzx.gdufs.edu.cn/main/');
// 		echo $url;die;
		$model->webShot($url);//http://auth.gdufs.edu.cn

	}
	
	
	/**
	 * ajax默认截图，通过id来进行更新
	 * @return ajax json 截图的名字
	 */
	function webShot(){
		$id = $_POST['id'];
		$url = $_POST['url'];
		$url = getHost($url);
		$model = D($this->getActionName());
		$logo = $model->webShot($url);
		if($model->where(array('id'=>$id))->data(array('logo'=>$logo))->save()){
			$this->ajaxReturn($logo,'',1);
		}else{
			$this->ajaxReturn('','',0);
		}	
		
	}
	
	/**
	 * ajax 截图
	 * @return json 截图的名字
	 */
	function ajaxWebshot(){
		$url = getHost($_REQUEST['url']);
		$model = D($this->getActionName());
		$url = $model->parseSite($url);//如果没有http://则自动加上
		$logo = $model->webShot($url);
		$this->ajaxReturn($logo);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
}