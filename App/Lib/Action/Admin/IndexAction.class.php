<?php

class IndexAction extends PublicAction
{
	private $adminsModel;
	function __construct(){
		parent::__construct();
		$this->adminsModel = new AdminsModel();
	}
   	/**
   	 * 
   	 *admin 后台管理入口,到登陆界面
   	 */
    function index()
    {	
        $this->redirect("Index/adminLogin");
    } 
    
    function adminTop(){
    	$this->display();
    }
    
    function adminLeft(){
    	$admin = $this->adminsModel->getAdmin($_SESSION['admin']['id']);
    	$this->assign('admin',$admin);
    	$this->display();
    }
    
    function adminRight(){
    	$this->display();
    }
    
    function adminLogin(){
    	if (isset($_POST['submitted'])){
    		$name =strip_tags(trim($_POST['name']));
    		$password = $_POST['password'];
    		if ($this->adminsModel->checkPassword($name, $password)){
    			$row = $this->adminsModel->where(array('name'=>$name,'password'=>md5($password)))->find();
    			$_SESSION['admin'] = array(
    			'isLogged' => true,
    			'id' =>$row['id']
    			);
    			$data = array(
    			'ip'=>get_client_ip(),
    			'lastLogin'=>date('Y-m-d H:i:s',time()),
    			'loginTimes'=>$row['loginTimes']+1
    			);
    			$this->adminsModel->where(array('id'=>$row['id']))->data($data)->save();//更新登陆信息
    			$this->redirect("Index/adminIndex");
    		}else{
    			$this->error('密码错误');
    		}
    		
    	}else{
    		$this->display();
    	}
    }
    
    /**
     * 
     * 网站登陆后的界面
     */
    function adminIndex(){
    	$this->display();
    }
    

}
?>