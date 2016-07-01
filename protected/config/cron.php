<?php

$request = array();

// Defined in root/cron.php 
// LIVE == true if 'localhost' is not present in the host name. 
if (LIVE) {

	$request['hostinfo'] = 'http://www.muslimharmony.com';
	
	define('EMAIL_HOST', 'port80.smtpcorp.com');
	define('EMAIL_PORT', 80);
	define('EMAIL_USER', 'waqar@servemuslims.com');
	define('EMAIL_PASS', 'whocares4321');

	if (RLS_ENV){
		
		$request['baseUrl'] = '';
		
		$db = array(
				'connectionString' => 'mysql:host=localhost;dbname=servem_prod',
				'emulatePrepare' => true,
				'username' => 'servem_adnan',
				'password' => 'dmx2pakiMH',
				'charset' => 'utf8',);
	}else{
		
		$request['baseUrl'] = '/MH_DEV';
		
		$db = array(
				'connectionString' => 'mysql:host=localhost;dbname=servem_dev',
				'emulatePrepare' => true,
				'username' => 'servem_adnan',
				'password' => 'dmx2pakiMH',
				'charset' => 'utf8',);	
	}
	$sessionPath =  array ('savePath' => '/tmp',);
}else{
	
	$request['hostinfo'] = 'http://localhost';
	$request['baseUrl'] = '/MH_DEV';
	
	define('EMAIL_HOST','localhost');
	define('EMAIL_PORT', 25);
	define('EMAIL_USER', '');
	define('EMAIL_PASS', '');
	
	$db = array(
			'connectionString' => 'mysql:host=localhost;dbname=servem_dev',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',);
	$sessionPath = array();
}

return array(  
		'timeZone' => 'UTC',
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',         
		'name'=>'Cron',         
		'preload'=>array('log'),          
		'import'=>array(                 
				'application.components.*',                 
				'application.models.*',         
				),         
		// application components         
		'components'=>array(   
				'request' => $request,
				'swiftMailer' => array(
						'class' => 'ext.swiftMailer.SwiftMailer',
				),
				'db'=>$db,
				'log'=>array(                         
						'class'=>'CLogRouter',                         
						'routes'=>array(                                 
								array(                                         
										'class'=>'CFileLogRoute',                                         
										'logFile'=>'cron.log',                                         
										'levels'=>'error, warning',                                 
										),                                 
								array(                                         
										'class'=>'CFileLogRoute',                                         
										'logFile'=>'cron_trace.log',                                         
										'levels'=>'trace',                                 
										),                         
								),                 
						),                 
				'functions'=>array(                         
						'class'=>'application.extensions.functions.Functions',                 
						),         
				), 
				// application-level parameters that can be accessed
				// using Yii::app()->params['paramName']
				'params'=>array(
						// this is used in contact page
						'adminEmail'=>'admin@muslimharmony.com',
						'dbDateFormat'=>'Y-m-d h:i:s',
				),
		);

