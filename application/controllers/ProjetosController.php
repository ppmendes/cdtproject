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
        $request = $this->getRequest();
        $form = new Application_Form_Projetos();

        echo "&nbsp;";
        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                echo "<pre>";
                print_r($form->getValues());
                echo "</pre>";
            }
        }

        $this->view->form = $form;


    }


}

