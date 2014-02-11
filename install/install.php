<?php
$dbfile="../database/gwdh.sql";
header("Content-type:text/html;charset=utf-8");

mysql_connect("127.0.0.1","root","") or die("connect error");

var_dump(mysql_query("set names gb2312"));

$createDB = mysql_query("CREATE DATABASE IF NOT EXISTS gwdh default charset gb2312");//COLLATE utf8_unicode_ci
// $createDB = mysql_query("CREATE DATABASE IF NOT EXISTS gwdh2");
// $content=iconv("UTF-8","GB2312",file_get_contents($dbfile));
$content=iconv("utf-8","gbk",file_get_contents($dbfile));
//获取创建的数据
//去掉注释
$content=preg_replace("/--.*\n/iU","",$content);
//替换前缀
// $content=str_replace("ct_",TABLE_PRE,$content);

mysql_select_db("gwdh") or die("select error");


$carr=array();
$iarr=array();
//提取create
preg_match_all("/Create table .*\(.*\).*\;/iUs",$content,$carr);
$carr=$carr[0];
foreach($carr as $c)
{
	mysql_query("set names gb2312");
	mysql_query($c);
}

//提取insert
preg_match_all("/INSERT INTO .*\(.*\)\;/iUs",$content,$iarr);
$iarr=$iarr[0];
//插入数据
foreach($iarr as $c)
{
	mysql_query("set names gb2312");
	mysql_query($c);
}

?>