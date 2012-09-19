<?php

class DesembolsoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Desembolso();

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

