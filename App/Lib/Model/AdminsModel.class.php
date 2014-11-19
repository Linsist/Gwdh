<?php
class AdminsModel extends Model{
	/**
	 * 
	 * 检查权限
	 * @param string $action_name
	 * @param array $expected
	 */
	function checkPrivilege($action_name,$expected){
		if(!in_array($action_name, $expected) && !isAdminLogged()){
			header('location:' . U('Index/index'));
		}
	}
	
	function checkPassword($name,$password){
		$where = array(
		'name'=>$name,
		'password'=>md5($password)
		);
		$row = $this->where($where)->count();
		if ($row>0) {
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 
	 * 获取admin的信息
	 * @param int $id
	 * @return array
	 */
	function getAdmin($id){
		return $this->where(array('id'=>$id))->find();
	}
	
	/**
	 * 
	 * 判断管理员是否登录
	 * @return boolean
	 */
	function isAdminLogged(){
		if ($_SESSION['admin']['isLogged']==true){
			return true;
		}else{
			return false;
		}
	}
	
	function deleteAdmins($arr){
		foreach ($arr as $id){
			$this->where(array('id'=>$id))->delete();
		}
	}
	
	function isExistName($name){
		$count = $this->where(array('name'=>$name))->count();
		if ($count>0){
			return true;
		}else{
			return false;
		}		
	}
	
	function addAdmin($name,$password,$privilege,$ip){
		$data = array(
		'name'=>$name,
		'password'=>md5($password),
		'privilege'=>$privilege,
		'ip'=>$ip
		);
		$this->data($data)->add();		
	}
	
	
	
	
	
	
	
	
	
	
	
}