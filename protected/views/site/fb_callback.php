<?php 
session_start();
require  Yii::app()->basePath . '/components/Facebook/autoload.php';
	
$fb = new Facebook\Facebook(Yii::app()->params['Facebook']);
$helper = $fb->getRedirectLoginHelper();  
  
try {  
  $accessToken = $helper->getAccessToken();  
} catch(Facebook\Exceptions\FacebookResponseException $e) {  
  // When Graph returns an error  
  echo 'Graph returned an error: ' . $e->getMessage();  
  exit;  
} catch(Facebook\Exceptions\FacebookSDKException $e) {  
  // When validation fails or other local issues  
  echo 'Facebook SDK returned an error: ' . $e->getMessage();  
  exit;  
}  

if (! isset($accessToken)) {  
  if ($helper->getError()) {  
    header('HTTP/1.0 401 Unauthorized');  
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {  
    header('HTTP/1.0 400 Bad Request');  
    echo 'Bad request';  
  }  
  exit;  
}  

// Logged in  
echo '<h3>Access Token</h3>';  
var_dump($accessToken->getValue());  
  
// The OAuth 2.0 client handler helps us manage access tokens  
$oAuth2Client = $fb->getOAuth2Client();  

// Get the access token metadata from /debug_token  
$tokenMetadata = $oAuth2Client->debugToken($accessToken);  
echo '<h3>Metadata</h3>';  
var_dump($tokenMetadata);  
  
// Validation (these will throw FacebookSDKException's when they fail)  
$tokenMetadata->validateAppId(Yii::app()->params['Facebook']['app_id']);  
// If you know the user ID this access token belongs to, you can validate it here  
// $tokenMetadata->validateUserId('123');  
$tokenMetadata->validateExpiration();   
   
if (! $accessToken->isLongLived()) {  
  // Exchanges a short-lived access token for a long-lived one  
  try {  
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);  
  } catch (Facebook\Exceptions\FacebookSDKException $e) {  
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>";  
    exit;  
  } 
  echo '<h3>Long-lived</h3>';  
  var_dump($accessToken->getValue());  
}
 
$_SESSION['fb_access_token'] = (string) $accessToken;  

try {
	// Returns a `Facebook\FacebookResponse` object
	$response = $fb->get('/me?fields=picture.height(500),id,first_name,last_name,birthday,gender,email,location,locale,cover', $_SESSION['fb_access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) { 
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

$graphObject = $response->getGraphObject();
$user  = $response->getGraphUser();
$session = $response->getGraphSessionInfo();



var_dump($graphObject);

echo $graphObject['picture']['url'];
echo $graphObject['id'];
echo $graphObject['first_name'];
echo $graphObject['last_name'];
echo $graphObject['birthday'];
echo $graphObject['gender'];
echo $graphObject['email'];
echo $graphObject['location']['id'];


try {
	// Returns a `Facebook\FacebookResponse` object
	$response = $fb->get('/'.$graphObject['location']['id'].'?fields=location', $_SESSION['fb_access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

$graphLocation = $response->getGraphObject();

var_dump($graphLocation);
echo $graphLocation['location']['city'];
echo $graphLocation['location']['country'];
echo $graphLocation['location']['state'];
echo $graphLocation['location']['latitude'];
echo $graphLocation['location']['longitude'];


/*
try {
	// Returns a `Facebook\FacebookResponse` object
	$response2 = $fb->get('...?fields=city', $_SESSION['fb_access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}
var_dump($response2);
*/
/*
try {
	// Returns a `Facebook\FacebookResponse` object
	$response2 = $fb->get('/me/friends', $_SESSION['fb_access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

var_dump($response2);
*/

//file_put_contents("Tmpfile.zip", fopen("http://someurl/file.zip", 'r'));


/*
$request = new FacebookRequest(
		$session,
		'GET',
		'/me',
		array(
				'fields' => 'id,first_name,last_name,birthday,gender,email,hometown,interested_in,languages,locale,cover'
		)
		);

$response = $request->execute();
$graphObject = $response->getGraphObject();
*/

/* handle the result */

// User is logged in with a long-lived access token.  
// You can redirect them to a members-only page.  
// header('Location: https://example.com/members.php');