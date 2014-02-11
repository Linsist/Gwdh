<?php
class AccountsAction extends PublicAction{
	function __construct(){
		parent::__construct();
		
		$Account = new AccountsModel();
		$Account->checkPrivilege(ACTION_NAME, array('checkPassword','login'));
		
		
		
	}
	
	function index(){
		$Page = new UserpageModel();
		$Page->checkFirstPageNum();

		$vo = $Page->where(array('uid'=>$_SESSION['account']['uid']))->order('pageId asc')->select();
		$this->assign('vo',$vo);

		$this->display();
	}
	
	/**
	 * 登录方法
	 */
	function login1(){
		$field = array(
				'username'=>$_POST['username'],
				'password'=>$_POST['password'],
				'login-form-type'=>'pwd',
		);

		vendor('Gwtxz.Gwtxz');
		$user = new Gwtxz();
		$model = new AccountsModel();
	
		$referUrl = $user->getReferUrl($field['username'],4);
		if ($user->checkField($field)){
			if (!(uc_get_user($field['username']))){
				$user->saveContent($referUrl);
				$content = $user->getContent();
	
				$studentNumber = $user->getStudentNumber(2);
				$username = $user->getName(2);
				$campus = $user->getCampus(2);
				$academy = $user->getAcademy(2);
				$grade = $user->getGrade(2);
				$major = $user->getMajor(2);
				$block = $user->getBlock();
				$room = $user->getRoom();
				uc_user_register($studentNumber, $username, $campus, $academy, $grade, $major, $block, $room);
			}
				
			$data = uc_get_user($field['username']);
			$arr['uid'] = $data['uid'];
			$arr['studentNumber'] = $data['studentNumber'];
			$arr['username'] = $data['username'];
			$model->setSession($arr);
			if (isset($_POST['autoLogin'])){
				$ucsynclogin =uc_user_synlogin($data['uid']);
				echo $ucsynclogin;
			}
			echo '<script type="text/javascript">window.location.href="'.U('index').'";</script>';
				
				
		}else{
			$this->error('用户名或密码错误');
		}
	
	}
	
    function login(){
    	$nameoremail=$_POST['username'];
    	$password=$_POST['password'];
    	$pattern="#(\w+\.)*\w+@(\w+\.)+[A-Za-z]+#";//正则表达式匹配是否是邮箱登陆
    	if(preg_match($pattern, $nameoremail)){
    		list($uid,$username,$password,$email)=uc_user_login($nameoremail, $password,2);
    	}else{
    		list($uid,$username,$password,$email)=uc_user_login($nameoremail, $password, 3);
    	}
    	$arr = array(
    		'uid'=>$uid,
    		'username'=>$username,
    		'email'=>$email,		
    	);
    	$model = new AccountsModel();
    	$model->setSession($arr);
    	$usersylnlogin=uc_user_synlogin($uid);
    	echo $usersylnlogin;
    	echo '<script type="text/javascript">window.location.href="'.U('index').'";</script>';
    }
	
	/**
	 * ajax 检查密码是否正确
	 * @return ajax 
	 */
	function checkPassword1(){
		$field = array(
				'username'=>$_POST['username'],
				'password'=>$_POST['password'],
				'login-form-type'=>'pwd',
		);

		vendor('Gwtxz.Gwtxz');
		$user = new Gwtxz();
	
		$referUrl = $user->getReferUrl($field['username'],1);
	
		if($user->checkField($field)){
			$this->ajaxReturn('','',1);
		}else{
			$this->ajaxReturn('','用户名或密码错误',0);
		}
	
	}
	
	function checkPassword(){
		$nameoremail=$_POST['username'];
	    	$password=$_POST['password'];
	    	$pattern="#(\w+\.)*\w+@(\w+\.)+[A-Za-z]+#";//正则表达式匹配是否是邮箱登陆
	    	if(preg_match($pattern, $nameoremail)){
	    		list($uid,$username,$password,$email)=uc_user_login($nameoremail, $password,2);
	    	}else{
	    		list($uid,$username,$password,$email)=uc_user_login($nameoremail, $password, 3);
	    	}
	    	if ($uid>0){
	    		$this->ajaxReturn('','',1);
	    	}else{
	    		$this->ajaxReturn('','用户名或密码错误',0);
	    	}
	
	}
    
    /**
     * 
     * 退出
     */
	function logout(){
    	$ucsynclogout = uc_user_synlogout(); 	
    	echo $ucsynclogout;session_destroy();
    	echo '<script type="text/javascript">window.location.href="'.U("Index/index").'"</script>';
    }
    
    
    function test(){
    	var_dump($_SESSION['account']);
    }
    
    
    
    
    
    
    
	
}?>
