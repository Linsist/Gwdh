<?php
class UsersiteAction extends PublicAction{
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		
		header('location:'.U('Accounts/index'));
	}
	
	public function add(){
		$uid = $_SESSION['account']['uid'];
		$model = new UsersiteModel();
		if (!($data = $model->create())){
			$this->ajaxReturn('',$model->getError(),0);
		}
		if ($model->add()){
			$data['id'] = $model->getLastInsID();
			$this->ajaxReturn($data,'',1);
		}else{
			$this->ajaxReturn('','网址添加失败',0);
		}

	}
	
	public function  update(){
		$uid = $_SESSION['account']['uid'];
		$model = new UsersiteModel();
		if (!$model->create()){
			$this->ajaxReturn('','',0);
		}
		
		if (!$model->save()){
			$this->ajaxReturn('','',0);
		}else{
			$this->ajaxReturn('','',1);
		}
	}
    
	/**
	 * 获取供选网址框的列表
	 */
    public function getSelectWebSite(){
    	$typeId = $_POST['typeId'];
    	$model = D('Site');
    	$site = $model->where(array('typeId'=>$typeId))->select();
    	$this->ajaxReturn($site);
    	
    }
    
    /**
     * 保存顺序
     */
    public function saveOrder(){
    	$pageId = $_POST['pageId'];
    	$ordersArr = explode('|', $_POST['orders']);
    	$model = new UsersiteModel();
    	$model->saveOrder($pageId, $ordersArr);   	
    }
    
    public function del(){
    	$id = $_POST['id'];
    	$uid = $_SESSION['account']['uid'];
    	$model = new UsersiteModel();
    	if($model->where(array('id'=>$id, 'uid'=>$uid))->delete()){
    		$this->ajaxReturn('','',1);	
    	}else{
    		$this->ajaxReturn('','删除失败',0);
    	}
    }

    
    function test(){
    		$url = 'www.wecom/comment/inbox?topnav=1&wvr=5&mod=message&f=1';

		$pattern = "#((https?|ftp|news):\/\/)?([\w]+\.)?([\w-]+\.)(com|net|org|gov|cc|biz|info|cn|edu)(\.(cn|hk))*#";
		if(preg_match($pattern, $url, $match)){
			echo 1;
			return true;
		}else{
			echo 2;
			return false;
		}
	
    }
    
    /**
     * ajax检查数据是否合法
     */
    function ajaxCheck(){
    	$model = D($this->getActionName());
    	if (!$model){
    		$this->ajaxReturn('','非法操作',0);
    	}   	
    	if(!$model->create()){
    		$this->ajaxReturn('',$model->getError(),0);
    	}else{
    		$this->ajaxReturn('','',1);
    	}
    }
    
    /**
     * 通过url获取site的信息
     */
    function getSiteByUrl(){
    	$url = $_REQUEST['url'];
    	$url = getSonHost($url);
    	$model = new SiteModel();
    	if (empty($url)){
    		$this->ajaxReturn('','',0);
    	}
    	$where = array(
    		'site'=>array('like',array('%'.$url.'%')),
    	);
    	if(!($data = $model->where($where)->select())){
    		$this->ajaxReturn('','',0);
    	}else{
    		$this->ajaxReturn($data,'',1);
    	}
    }
    
    
    
    
    function searchSite(){
    	$name = $_REQUEST['name'];
    	$site = $_REQUEST['site'];
    	if (empty($name) && empty($site)){
    		$this->ajaxReturn('');
    	}
    	$model = new SiteModel();
		$map = array(
			'name'=>array('like', '%'.$name.'%'),	
			'site'=>array('like', '%'.$site.'%'),
// 			'_logic'=>'or',
		);
		$data = $model->distinct(true)->where($map)->select();
// 		echo '<pre>';
// 		var_dump($data);
// 		echo '</pre>';

		$this->ajaxReturn($data);
    	
    }
    
    
    /**
     * ajax 截图
     * @return json 截图的名字
     */
    function ajaxWebshot(){
    	$id = $_REQUEST['id'];
    	$url = getHost($_REQUEST['url']);
    	$model = new UsersiteModel();
    	$url = $model->parseSite($url);//如果没有http://则自动加上
    	$logo = $model->webShot($url);
    	if (!$model->create()){
    		$this->ajaxReturn(0);
    	}
    	if (!$model->where(array('id'=>$id))->data(array('logo'=>'webshot/'.$logo))->save()){
    		$this->ajaxReturn(1);
    	}
    	
    	$this->ajaxReturn($logo);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	
}?>
