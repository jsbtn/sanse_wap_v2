<?php


define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
$act = $_REQUIEST['act'] ? $_REQUIEST['act'] : '' ;

if($act == 'weixin_authorize'){
	
	$wx_login_openid = $_COOKIE['WeChat']['openid'];
	if($wx_login_openid){
		$wx_user_info = getWxExistUser($wx_login_openid);
		if(!$wx_user_info['openid']){
			$req = "act=weixin_authorize_done&is_authorize=1";
			weixin_authorize(true,$req);
		}else{
			$weixin_src = "AUTH";
			$user_id = createWxUser($wx_user_info,$weixin_src,true);
			echo $user_id;
		}
	}else{
		$req = "act=weixin_authorize_get_openid&is_authorize=1";
		weixin_authorize(false,$req);
	}
	exit;
}elseif($act == 'weixin_authorize_get_openid'){
	
	$open_info = getOpenInfo();
	$wx_user_info = getWxAuthorizeUser($open_info);
	if(!$wx_user_info['openid']){
		$req = "act=weixin_authorize_done&is_authorize=1";
		weixin_authorize(true,$req);
	}
	$weixin_src = "AUTH";
	$user_id = createWxUser($wx_user_info,$weixin_src,true);
	echo $user_id;
}elseif($act == 'weixin_authorize_done'){
	$open_info = getOpenInfo();
	$wx_user_info = getWxAuthorizeUser($open_info);
	$weixin_src = "AUTH";
	$user_id = createWxUser($wx_user_info,$weixin_src,true);
	echo $user_id;
}elseif($act == 'auto_weixin_login'){
	include_once('./includes/cls_weixin_login.php');//微信登录盘dua
	$cls_weixin_login = new cls_weixin_login();
	$res = $cls_weixin_login->login();
	if($res > 0){
		echo $res;
	}else{
		echo '异常';
	}
}