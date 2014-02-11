<?php
class AdminsAction extends PublicAction{
	private $adminsModel;
	private $publicModel;
	function __construct(){
		parent::__construct();
		$this->adminsModel = new AdminsModel();
		$this->publicModel = new PublicModel();
		$noLogin = array('captcha','checkCaptcha','checkPassword','test');
		$this->adminsModel->checkPrivilege(ACTION_NAME, $noLogin);
		
	}
	
	/**
	 * 管理员信息的入口
	 * 
	 */
	function index(){
		import('ORG.Util.Page');
		$count = $this->adminsModel->count();
		$p=new Page($count,10);
    	$list=$this->adminsModel->limit($p->firstRow.','.$p->listRows)->order('loginTimes desc')->select();
    	
    	$p->setConfig('prev', '上一页');
    	$p->setConfig('next', '下一页');
    	$p->setConfig('first', '首页');
    	$p->setConfig('last', '尾页');
    	$page=$p->show();
    	$this->assign('page',$page);
    	$this->assign('list',$list);
		$this->display('Admins:adminManage');
	}
	/**
	 * 
	 * 添加管理员的入口
	 */
	function add(){
		if (isset($_POST['submitted'])){
			$name = $_POST['name'];
			$password = $_POST['password'];
			$ip = get_client_ip();
			$privilege = 0;
			$this->adminsModel->addAdmin($name, $password, $privilege, $ip);
			$this->success('管理员添加成功',U('Admins/index'));
		}else{
			$this->display('Admins:adminAdd');
		}
		
	}
	
	function test(){
		echo get_client_ip();
	}
	function checkPassword(){
		$name = $_POST['name'];
		$password = $_POST['password'];	
		if ($this->adminsModel->checkPassword($name, $password)){
			$this->ajaxReturn('','登陆成功',1);
		}else{
			$this->ajaxReturn('','用户名或密码错误',0);
		}
	}
	

	function checkName(){
		$name = $_POST['name'];
		if ($this->adminsModel->isExistName($name)) {
			$this->ajaxReturn('','此名字已被注册',1);
		}else{
			$this->ajaxReturn('','',0);
		}
	}
	
	/**
	 * 退出登录
	 * Enter description here ...
	 */
	function logout(){
		session_destroy();
		$this->redirect('Index/index');
	}
	
	function deleteMulty(){
		$allId = $_POST['all_id'];
		$arr = explode('|', $allId);
		$this->adminsModel->deleteAdmins($arr);
	}
	function deleteOne($id){
		$arr = array('id'=>$id);
		$this->adminsModel->deleteAdmins($arr);
	}
	
	
	
}