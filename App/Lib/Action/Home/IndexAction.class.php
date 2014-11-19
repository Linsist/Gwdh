<?php

class IndexAction extends PublicAction
{
   	public function __construct(){
   		parent::__construct();
   	}
	
    public function index()
    {	
    	if (isLogged()){
    		header('location:'.U('Accounts/index'));
    	}else{
    		header('location:'.U('home'));
    	}
       
    } 
    
    public function home(){
    	
    	$Site=new SiteModel();
    	$arr=$Site->getAllSite();//一个三维数组，包含了所有网址
    	$this->assign('arr',$arr);
    	$this->display('Index:index');
    }
    
    
    public function test(){
//     	var_dump(uc_get_user('32',1));

    	var_dump($_SESSION['account']);
    }

}
?>