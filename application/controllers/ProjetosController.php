<?php

class ProjetosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	    $projetoModel = new Application_Model_Projeto();
        $projetoModel = $projetoModel->find(1);
        $prioridade = $projetoModel->findParentApplication_Model_DbTable_Prioridade();
        echo "<pre>";

        echo "</pre>";
    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Projetos();

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

