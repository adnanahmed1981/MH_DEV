<?php 

/* CURRENT CRONS
 *
* php cron.php ResetDailyReleaseQty - RUN DAILY @ 12AM
* php cron.php ReleaseMatches LIVE - RUN DAILY @ 8AM
*
*/

// Define LIVE constant as true if 'localhost' is not present in the host name. Configure the detecting of environment as necessary of course.

if (isset($_SERVER['argv'])){
	if (isset($_SERVER['argv'][2]) && $_SERVER['argv'][2] == "LIVE" ){
		defined('LIVE') || define('LIVE', true);
	}else{
		defined('LIVE') || define('LIVE', false);
	}
}else{
	defined('LIVE') || define('LIVE', false);
}

if (strpos(dirname(__FILE__) ,'MH_DEV')===false ){
	defined('RLS_ENV') || define('RLS_ENV', true);
}else{
	defined('RLS_ENV') || define('RLS_ENV', false);
}


// change the following paths if necessary 
$yii=dirname(__FILE__).'/../yii/framework/yii.php'; 
$config=dirname(__FILE__).'/protected/config/cron.php'; 

// remove the following lines when in production mode 
defined('YII_DEBUG') or define('YII_DEBUG',true); 

// specify how many levels of call stack should be shown in each log message 
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3); 

require_once($yii); 

$custom=dirname(__FILE__).'/protected/includes/HelperMethods.php';
require_once($custom);

$app = Yii::createConsoleApplication($config)->run();

