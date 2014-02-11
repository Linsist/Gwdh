<?php
function isAdminLogged(){
	$Admins = new AdminsModel();
	if ($Admins->isAdminLogged()){
		return true;
	}else{
		return false;
	}
}

/**
 * 
 * 通过管理员id得到权限的中文名
 * @param int $id
 */
function getPrivilege($id){
	$Admins = new AdminsModel();
	$privilege = $Admins->where(array('id'=>$id))->getField('privilege');
	switch ($privilege){
		case 0:
			echo '普通管理员';
			break;
		case 1:
			echo '超级管理员';
			break;
	}		
}
