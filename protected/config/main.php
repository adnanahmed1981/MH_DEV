<?php
// include_once("includes/HelperMethods.php");
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//include_once("includes/bfi/BFI_Thumb.php");
ini_set('memory_limit', '256M');
ini_set("gd.jpeg_ignore_warning", 1);
error_reporting(E_ALL & ~E_NOTICE);

// Defined in root/index.php
// LIVE == true if 'localhost' is not present in the host name.
if (LIVE) {
	//define('EMAIL_HOST','mail.muslimharmony.com'); 
	define('EMAIL_HOST', 'port80.smtpcorp.com');
	define('EMAIL_PORT', 80);
	define('EMAIL_USER', 'waqar@servemuslims.com');
	define('EMAIL_PASS', 'whocares4321');
	
	if (RLS_ENV){ 
		
		$db = array(
				'connectionString' => 'mysql:host=localhost;dbname=servem_prod',
				'emulatePrepare' => true,
				'username' => 'servem_adnan',
				'password' => 'dmx2pakiMH',
				'charset' => 'utf8',);
	}else{ 

		$db = array(
				'connectionString' => 'mysql:host=localhost;dbname=servem_prod',
				'emulatePrepare' => true,
				'username' => 'servem_adnan',
				'password' => 'dmx2pakiMH',
				'charset' => 'utf8',);	
	}
	 $sessionPath =  array ('savePath' => '/tmp',);
}else{

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

if (RLS_ENV){
	define('PAYPAL_SANDBOX',false);
	define('PAYPAL_HOST', 'ipnpb.paypal.com');
	define('PAYPAL_URL', 'https://ipnpb.paypal.com/cgi-bin/webscr');
	define('PAYPAL_EMAIL','payment@muslimharmony.com'); // live email of merchant
}else{
	define('PAYPAL_SANDBOX',true);
	define('PAYPAL_HOST', 'ssl://www.sandbox.paypal.com');
	define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
	define('PAYPAL_EMAIL', 'adnan.m.ahmed-facilitator@gmail.com'); // dev email of merchant
}


return array(
	'timeZone' => 'UTC',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	// AA: Added to change the default controller 'site' to:
	'defaultController' => 'site',
	'name'=>'Muslim Harmony',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
        'application.vendors.*',
        'application.vendors.bfi.*',
		'application.extensions.image.Image'   
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool 
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gii',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),
	// application components
	'components'=>array(
			'session' => $sessionPath,
		'image'=>array(
				'class'=>'application.extensions.image.CImageComponent',
				// GD or ImageMagick
				'driver'=>'GD',
				// ImageMagick setup path
				'params'=>array('directory'=>'/opt/local/bin'),
		),			
		'swiftMailer' => array(
				'class' => 'ext.swiftMailer.SwiftMailer',
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('site/index'),
									
		),
		// uncomment the following to enable URLs in path-format
		
        
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),

        ),
		//'db'=>array(
		//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		//),
		// uncomment the following to use a MySQL database

		
		'db'=>$db,
			
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning,trace',
					'logFile'=>'trace.log',	
					
				),
				// uncomment the following to show log messages on web pages
				array(
					'class'=>'CWebLogRoute',
						
				),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'admin@muslimharmony.com',
		'dbDateFormat'=>'Y-m-d h:i:s',
		'Facebook'=>array(  'app_id' => '636695619803595',
							'app_secret' => 'cb2f962913d047c1e88a51d43ab9f10c',
							'default_graph_version' => 'v2.5',
							'default_access_token' => '63669561980359|cb2f962913d047c1e88a51d43ab9f10c'
		),
		
	),
);