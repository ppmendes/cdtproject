<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
	//$resource = $this->getPluginResource('db');
	//$db = $resource->getDbAdapter();
	//$sql = "SHOW tables";
	//echo "<pre>";
	//print_r($db->fetchAll($sql));
	//echo "</pre>";
    }

}

