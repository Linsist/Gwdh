<?php
class SiteAction extends PublicAction{
	private $SiteTypeModel;
	private $SiteModel;
	private $adminsModel;
	
	function __construct(){
		parent::__construct();
		$this->SiteTypeModel = new Site_typeModel();//实例化模型
		$this->SiteModel = new SiteModel();
		$this->adminsModel = new AdminsModel();
		$noLogin = array();
		$this->adminsModel->checkPrivilege(ACTION_NAME, $noLogin);
	}
	
	function index(){
		$this->redirect("Site/adminSite");
	}
	
	/**
	 * 
	 * 网址管理界面的入口
	 */
 	function adminSite(){
 		$siteType = $this->SiteTypeModel->getType();
 		$this->assign('siteType',$siteType);
    	$this->display();
    }
    
    /**
     * 
     * 添加网址的类型
     */
    function addSiteType(){
    	$siteType = htmlspecialchars($_POST['siteType']);
    	$data = array(
    	'siteType'=>$siteType
    	);
    	$returnId = $this->SiteTypeModel->data($data)->add();
    	if ($returnId>0){
    		$this->ajaxReturn($returnId,'类别增加成功',1);
    	}else{
    		$this->ajaxReturn('','类别添加失败',0);
    	}
		
    }
    
    /**
     * 
     * 更新网址类型
     */
    function updateSiteType(){
    	$siteType = htmlspecialchars($_POST['siteType']);
    	$typeId = $_POST['typeId'];
    	$data = array(
    		'siteType'=>$siteType,
    	);
    	$where = array(
    		'typeId'=>$typeId
    	);
    	$return = $this->SiteTypeModel->where($where)->data($data)->save();
    	if ($return>=0){
    		$this->ajaxReturn($typeId,'类别修改成功',1);
    	}else{
    		$this->ajaxReturn('','类别修改失败',0);
    	}
    }
    
    /**
     * 
     * 删除网址类型
     */
    function deleteSiteType(){
    	$where = array(
    	'typeId'=>$_POST['typeId']
    	);
    	$delTypeId = $this->SiteTypeModel->where($where)->delete();
    	$delSiteId = $this->SiteModel->where($where)->delete();
    	if ($delTypeId>0){
    		$this->ajaxReturn('','删除成功',1);
    	}else{
    		$this->ajaxReturn('','删除失败',0);
    	}
    }
    
    /**
     * 
     * 添加网址
     */
    function addSite(){
//     	$typeId = $_POST['typeId'];
//     	$name = $_POST['name'];
// 		$site = $_POST['site'];
// 		$blog = $_POST['blog'];
// 		$weibo = $_POST['weibo'];
		
// 		$reg = "#^((https?|ftp|news):\/\/){1}#";
// 		if(!preg_match($reg,$site)){//自动加http头
// 			$site = 'http://'.$site;
// 		}
// 		$orders = $this->SiteModel->where(array('typeId'=>$typeId))->count('id')+1;
// 		$data['typeId']=$typeId;
// 		$data['name']=$name;
// 		$data['site']=$site;
// 		$data['blog']=$blog;
// 		$data['weibo']=$weibo;
// 		$data['orders']=$orders;
// 		$returnId = $this->SiteModel->data($data)->add();
//     	if ($returnId>=0){
//     		$this->ajaxReturn($returnId,'网址添加成功',1);
//     	}else{
//     		$this->ajaxReturn('','网址添加失败',0);
//     	}
		$model = D('Site');
    	if (!($data=$model->create())){
    		$this->ajaxReturn('',$model->getError(),0);
    	}
		if (!$model->add()){
			$this->ajaxReturn('','添加失败',0);
		}else{
			$data['id'] = $model->getLastInsID();
			$this->ajaxReturn($data,'',1);
		}
    }
    
    /**
     * 
     * 更新网址
     */
    function updateSite(){
//     	$id=$_POST['id'];
// 		$data['name']=$_POST['name'];
// 		$data['site']=$_POST['site'];
// 		$data['blog']=$_POST['blog'];
// 		$data['weibo']=$_POST['weibo'];
// 		$where = array(
// 			'id'=>$id
// 		);

    	if (!($data=$this->SiteModel->create())){
    		$this->ajaxReturn('',$this->SiteModel->getError(),0);
    	}
// 		$return = $this->SiteModel->where($where)->data($data)->save();
//     	if ($return==true){
//     		$this->ajaxReturn($id,'网址修改成功',1);
//     	}else{
//     		$this->ajaxReturn('','网址修改失败',0);
//     	}

    	if ($this->SiteModel->save($data)){
    		$this->ajaxReturn($data,'网址修改成功',1);
    	}else{
    		$this->ajaxReturn($data,'网址修改失败',0);
    	}
    }
	
    /**
     * 
     * 删除网址
     */
    function deleteSite(){
    	$where = array(
    		'id'=>$_POST['id']
    	);
    	$return = $this->SiteModel->where($where)->delete();
    	if ($return){
    		$this->ajaxReturn('','删除成功',1);
    	}else{
    		$this->ajaxReturn('','删除失败',0);
    	}
    }
	
    /**
     * 
     * 得到一个网址的信息
     */
	function showSiteInfo(){
		$where = array(
			'id'=>$_POST['id']
		);	
		$data = $this->SiteModel->getOneSite($where);
		$this->ajaxReturn($data);
	}
	
	/**
	 * 
	 * 修改排序
	 */
	function resetOrder(){
		$oldOrder = $_POST['orders'];
		$order=explode('|',$oldOrder);
		$this->SiteModel->resetSiteOrder($order);
	}
	
	
	function ajaxUpload(){
		import('ORG.Net.UploadFile');
    	$upload = new UploadFile();
    	$upload->maxSize = 1024000;
    	$upload->uploadReplace = true;
    	$upload->allowExts = array('png','jpg','jpeg');//,'doc','docx','ppt','xls','xlsx'
    	$upload->savePath = C('UPLOADS_ADDR').'webshot/';
    	$data = array();
    	if (!$upload->upload()){
    		$this->ajaxReturn('',$upload->getErrorMsg() ,0);
    		
    	}else{
    	
    		$arr = $upload->getUploadFileInfo();
    		$this->ajaxReturn($arr,'',1);
    	}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}