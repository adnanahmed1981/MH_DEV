<?php 
$member = Yii::app()->user->member;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<title><?php echo CHtml::encode($this->page_title); ?></title>
<?php include('_baseIncludes.php'); ?>
</head>
<body>
	
		<?php echo $content; ?>

</body>
</html>
