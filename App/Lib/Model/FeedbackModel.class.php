<?php
class FeedbackModel extends Model{
	protected $_validate = array(
		array('content','require','内容不能为空',0),
	);
	
	/**
	 * 
	 * 删除留言
	 * @param array $arr
	 * @return void
	 */
	function deleteFeedback($arr){
		foreach ($arr as $id){
			$this->where(array('id'=>$id))->delete();
		}
	}
	
	function getFeedback(){
		return $this->order('feedbackTime desc')->select();
	}
	
}