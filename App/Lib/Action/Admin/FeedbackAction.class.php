<?php
class FeedbackAction extends PublicAction{
	private $feedbackModel;
	private $adminsModel;
	function __construct(){
		parent::__construct();
		$this->feedbackModel = new FeedbackModel();
		$this->adminsModel = new AdminsModel();
		$noLogin = array();
		$this->adminsModel->checkPrivilege(ACTION_NAME, $noLogin);
	}
	function index(){
		import('ORG.Util.Page');
		$count = $this->feedbackModel->count();
		$p=new Page($count,10);
    	$list=$this->feedbackModel->limit($p->firstRow.','.$p->listRows)->order('feedbackTime desc')->select();
    	
    	$p->setConfig('prev', '上一页');
    	$p->setConfig('next', '下一页');
    	$p->setConfig('first', '首页');
    	$p->setConfig('last', '尾页');
    	$page=$p->show();
    	$this->assign('page',$page);
    	$this->assign('list',$list);
		$this->display('Feedback:adminFeedback');
		
	}
	
	function deleteMulty(){
		$allId = trim($_POST['all_id']);
		$id=explode('|', $allId);
		$this->feedbackModel->deleteFeedback($id);		
	}
	
	function deleteOne($id){
		$arr = array('0'=>$id);
		$this->feedbackModel->deleteFeedback($arr);
		$this->redirect('Feedback/index');
	}
	
	
	
	
	
	
	
	
	
	
}