<?php
class UsersiteModel extends PublicModel{
	protected $_validate = array(
		array('uid','require','非法操作'),
		array('title','require','网站名不能为空'),
		array('url','checkIsRightUrl','网址不合法','','callback'),
		
	);
	
	protected $_auto = array(
		array('uid','getUid',1,'callback'),	
		array('orders','getOrder',1,'callback'),
		array('url','parseSite',3,'callback'),
		array('host','getHost',3,'callback'),
	);
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * 得到用户的uid
	 * @return int
	 */
	public function getUid(){
		return $_SESSION['account']['uid'];
	}
	
	/**
	 * 用户添加网址时，得到网址的排序
	 * @return number
	 */
	public function getOrder(){
		$num = $this->where(array('uid'=>$this->getUid()))->count();
		return ($num+1);
	}
	
	public function getHost(){
		$url = $_POST['url'];
		return getSonHost($url);
	}
	
	
	public function defaultWebSite(){
		
	}
	
	/**
	 * 保存排序
	 * @param array $orders 用户网址id的顺序
	 */
	public function saveOrder($pageNum, $ordersArr){
		$orders = 1;
		foreach ($ordersArr as $id){
			$data = array('pageNum'=>$pageNum, 'orders' =>$orders);
			$this->where(array('id'=>$id))->data($data)->save();
			$orders++;
		}	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}