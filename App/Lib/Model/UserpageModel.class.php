<?php
class UserpageModel extends Model{
	protected $_validate = array(
		array('uid','require','非法操作'),
		
	);
	
	protected $_auto = array(
		array('uid','getUid',1,'callback'),	
		
	);
	
	public function defaultWebSite(){
		
	}
	
	/**
	 * 得到用户的uid
	 * @return int
	 */
	public function getUid(){
		if(isLogged()){
			return $_SESSION['account']['uid'];
		}else{
			return '';
		}	
	}
	
	/**
	 * 用户添加网址时，得到网址的排序
	 * @return number
	 */
	public function getPageNum(){
		$num = $this->where(array('uid'=>$this->getUid()))->count();
		return ($num+1);
	}
	
	function checkFirstPageNum(){
		if ($this->where(array('uid'=>$this->getUid()))->count()<1){
			$data = array('uid'=>$this->getUid());
			$this->data($data)->add();
		}
	}
	
	
	
	
	
	
}