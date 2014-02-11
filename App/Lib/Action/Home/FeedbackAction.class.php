<?php
class FeedbackAction extends Action{
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * 
	 * ajax 提交留言
	 */
	function submitFeedback(){
		$Feedback = new FeedbackModel();
    	$content= strip_tags($_POST['content']);
    	if(!$Feedback->create()){
    		$this->ajaxReturn('','留言失败',0);
    		//exit($Feedback->getError());
    	}
    	$data=array(
    		'content'=>$content,
    		'feedbackTime'=>date('y-m-d H:i:s',time())
    	);
    	$q = $Feedback->add($data);
    	if($q)
    		$this->ajaxReturn('','留言成功',1);
    	else
    		$this->ajaxReturn('','留言失败',0);
    }		
	
}?>