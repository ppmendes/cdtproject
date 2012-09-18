<?php

class ProjetosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	
    }

    public function addAction(){
        $form = new Application_Form_Projetos();
        $this->view->form = $form;

        if($this->getRequest()->isPost()){
            echo "<pre>";
            print_r($form->getValues());
            echo "</pre>";
        }


    }


}

