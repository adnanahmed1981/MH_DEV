<?php 
session_start();
require  Yii::app()->basePath . '/components/Facebook/autoload.php';
	
$fb = new Facebook\Facebook(Yii::app()->params['Facebook']);

$helper = $fb->getRedirectLoginHelper();
    	
$permissions = ['email', 'user_birthday', 'user_friends', 'public_profile', 'user_location']; // Optional permissions 
$url = 'http://'.$_SERVER['HTTP_HOST'].Yii::app()->baseUrl.'/index.php/site/fb_callback';
$loginUrl = $helper->getLoginUrl($url, $permissions);
echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
?>