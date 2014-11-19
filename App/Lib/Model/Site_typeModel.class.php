<?php
class Site_typeModel extends Model{
	
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * 
	 * 得到所有的网址类型
	 * @return Array
	 */
	function getType(){
		$data = $this->order('typeId asc')->select();
		return $data;
	}
	
	/**
	 * 
	 * 通过id 得到一个类别
	 * @param array $where
	 * @return array
	 */
	function getOneType($where){
		$data = $this->where($where)->find();
		return $data;
	}
}