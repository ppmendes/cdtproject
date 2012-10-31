<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initFilter()
    {
        $dateFilter = new Zend_Filter_DateFilter();
        $filterChain = new Zend_Filter();
        $filterChain->addFilter($dateFilter);
    }

    protected function _initLog()
    {
        $logger = new Zend_Log();

        $writer = new Zend_Log_Writer_Firebug();

        $logger->addWriter($writer);

        Zend_Registry::set('Log', $logger);

    }

    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
        $view->headMeta()->setHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        set_include_path('../library/'.get_include_path());

        $view->getHelper('BaseUrl')->setBaseUrl('http://cdtproject.local');

        require_once 'Zend/Loader/Autoloader.php';

        $loader = Zend_Loader_Autoloader::getInstance();

        $loader->registerNamespace('Application_');

    }

    protected function _initJQuery()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $this->view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
        $view->jQuery()->enable()//enable jquery ; ->setCdnSsl(true) if need to load from ssl location
                       ->setVersion('1.8')//jQuery version, automatically 1.5 = 1.5.latest
                       ->setUiVersion('1.8')//jQuery UI version, automatically 1.8 = 1.8.latest
                       //->addStylesheet('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css')//add the css
                       ->uiEnable();//enable ui
        $view->jQuery()->enable()
            ->setLocalPath('/js/jquery-1.8.1.js')
            ->setUiLocalPath('/js/jquery-ui-1.8.1.js')
            ->uiEnable();
    }

}

