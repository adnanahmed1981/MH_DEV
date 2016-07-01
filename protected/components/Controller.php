<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	// filterAccessControl()
	//
	//  This replicates the access control module in the base controller and lets us
	//  do our own special rules that insure we fail closed.
	
	public function filterAccessControl($filterChain)
	{
		$rules = $this->accessRules();
	
		// default deny
		$rules[] = array('deny');
	
		$filter = new CAccessControlFilter;
		$filter->setRules( $rules );
		$filter->filter($filterChain);
	}

}