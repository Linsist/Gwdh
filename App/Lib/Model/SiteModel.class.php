<?php
class SiteModel extends PublicModel{
	protected $_validate = array(
		array('name','require','网址名字不能为空'),
	);
	
	protected $_auto = array(
		array('orders','getOrders',1,'callback'),
		array('site','parseSite',3,'callback'),
		array('weibo','parseSite',3,'callback'),
		array('blog','parseSite',3,'callback'),
		array('host','getHost',3,'callback'),
	);
	
	public function getOrders(){
		$typeId = $_POST['typeId'];
		return $this->where(array('typeId'=>$typeId))->count('id')+1;
	}
	
	public function getHost(){
		$url = $_POST['site'];
		return getSonHost($url);
	}
	
// 	public function parseSite($site){
// 		if (empty($site)){
// 			return '';
// 		}else{
// 			$reg = "#^((https?|ftp|news):\/\/){1}#";
// 			if(!preg_match($reg,$site)){//自动加http头
// 				$site = 'http://'.$site;
// 			}
// 			return $site;
// 		}
// 	}
	
	/**
	 * 通过类型的type的id 得到site
	 * @param int $typeId
	 * @return string site
	 */
	function getSiteByTypeId($typeId){
		$data=array(
		'typeId'=>$typeId
		);
		return $this->where($data)->order('orders asc')->select();
		
	}
	
	/**
	 * 通过类别的名字返回id
	 * @param string $siteType
	 * @return int $typeid
	 */
	function getTypeBySiteName($siteType){
		$data=array(
		'siteType'=>$siteType
		);
		return M('siteType')->where($data)->getField('typeId');//在site_type表里面
	}

	
	/**
	 *得到所有的网址，返回一个二维数组，以type的id作为键值 
	 *@return ArrayObject
	 */
	function getAllSite(){
		$arr=M('site_type')->select();
		$key=array();
		foreach($arr as $row){
			$key[$row['typeId']]= $this->getSiteByTypeId($row['typeId']);
		}
		return $key;
	}
	
	/**
	 * 
	 * 获取一个网址的所有信息
	 * @param array $where
	 * @return mixed 如果成功则是数组，否则是false;
	 */
	function getOneSite($where){
		$row = $this->where($where)->find();
		return $row;
	}
	
	/**
	 * 
	 * 修改排序
	 * @param array $order
	 * @return void
	 */
	function resetSiteOrder($order){
		$i=1;
		foreach ($order as $temp){
			$where = array('id'=>$temp);
			$data = array('orders'=>$i);
			$flag = $this->where($where)->data($data)->save();
			$i++;
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}?>