<?php

class InstituicoesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $instituicaoModel = new Application_Model_Instituicao();
        $this->view->instituicao = $instituicaoModel->selectAll();
    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Instituicoes();

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                echo "<pre>";
                print_r($form->getValues());
                echo "</pre>";
            }
        }

        $this->view->form = $form;
    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Instituicoes();
        $model = new Application_Model_Instituicao;
        $id = $this->_getParam('instituicao_id');

        if($this->getRequest()->isPost()){
            if($detalhes->isValid($request->getPost())){
                echo "<pre>";
                print_r($detalhes->getValues());
                echo "</pre>";
            }
        }

        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/instituicao/detalhes/instituicao_id/' . $id);
            $detalhes->populate(array("instituicao" => $data));
        }

        $this->view->detalhes = $detalhes;
    }

}

