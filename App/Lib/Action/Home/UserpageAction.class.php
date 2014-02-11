<?php
class UserpageAction extends PublicAction{
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		
		header('location:'.U('Accounts/index'));
	}
	
	public function add(){
		$uid = $_SESSION['account']['uid'];
		$model = new UserpageModel();
		if (!($model->create())){
			$this->ajaxReturn('',$model->getError(),0);
		}
		if ($model->add()){
			$data = $model->where(array('pageId'=>$model->getLastInsID()))->find();
			$this->ajaxReturn($data,'',1);
		}else{
			$this->ajaxReturn('','添加失败',0);
		}

	}
    
	public function delete(){
		$uid = $_SESSION['account']['uid'];
		$pageId = $_REQUEST['pageId'];
		$model = new UserpageModel();
		
		if ($model->where(array('pageId'=>$pageId))->delete()){
			$this->ajaxReturn('','',1);
		}else{
			$this->ajaxReturn('','删除失败',0);
		}
	}
	
	public function update(){
		$pageId = $_POST['pageId'];
		$title = $_POST['title'];
		$model = new UserpageModel();
		if ($model->where(array('pageId'=>$pageId))->data(array('title'=>$title))->save()){
			$this->ajaxReturn('','',1);
		}else{
			$this->ajaxReturn('','保存失败',0);
		}
	}
	
	
	/**
	 * 检查当前页面的网址是不是满了
	 */
	public function checkIsFullPage(){
		$pageId = $_POST['pageId'];
		$uid = $_SESSION['account']['uid'];
		$model = D('Usersite');
		$where = array(
			'uid' => $uid,
			'pageId' => $pageId,		
		);
		if ($model->where($where)->count()>=8){
			$this->ajaxReturn('','本页已满，请新建一页',0);
		}else{
			$this->ajaxReturn('','',1);
		}
	}
	
	/**
	 * 检查当前总共有多少页
	 */
	public function checkPageNum(){
		$uid = $_SESSION['account']['uid'];
		$model = new UserpageModel();
		
		if ($model->where(array('uid'=>$uid))->count()>10){
			$this->ajaxReturn('','最多允许新建10页',0);
		}else{
			$this->ajaxReturn('','',1);
		}
		
	}
	
	/**
	 * 清空当前页的网址
	 */
	public function emptyPage(){
		$pageId = $_POST['pageId'];
		$model = new UsersiteModel();
		
		$where = array('pageId'=>$pageId);
		if ($model->where($where)->delete()){
			$this->ajaxReturn('','',1);
		}else{
			$this->ajaxReturn('','删除失败',0);
		}
		
	}
    

    
    
    
    
	
}?>
