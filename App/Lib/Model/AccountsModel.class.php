<?php
class AccountsModel extends Model{
	
	public function __construct(){
		parent::__construct();
	}

	/**
	 * 
	 * @param string $action_name
	 * @param array $expected
	 */
	function checkPrivilege($action_name,$expected){
		if(!in_array($action_name, $expected) && !isLogged()){
			header('location:' . U('Index/index'));
			exit();
		}
	}
	
	/**
	 * 设置sesison
	 */
	function setSession($arr){	
		$_SESSION['account'] = $arr;
	}
	
	/**
	 * 通过cookie 获得账户信息
	 * @return mixed array or null
	 */
	function getAccount(){
		if (!empty($_COOKIE['gwdh_auth'])){
			list($uid,$username)=explode("\t", uc_authcode($_COOKIE['gwdh_auth'],'DECODE'));//不明白"\t"为什么一定要双引号
			$account=uc_get_user($uid,1);//1是通过uid来获取信息
			$arr['uid']=$account['uid'];
			$arr['username']=$account['username'];
			$arr['studentNumber']=$account['studentNumber'];
			return $arr;
		}else{
			return null;
		}
	}
    
	
    
    
    
    
    
    
    
}?>
