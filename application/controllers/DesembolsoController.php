<?php

class DesembolsoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $desembolsoModel = new Application_Model_Desembolso();
        $this->view->desembolsos = $desembolsoModel->selectAll();

    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Desembolso();
        $model = new Application_Model_Desembolso;
        $id = $this->_getParam('desembolso_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
//                echo "<pre>";
//                print_r($form->getValues());
//                echo "</pre>";
                $data = $form->getValues();

                $model->insert($data);

                $this->_redirect('/desembolso/');
            }
        }

        $this->view->form = $form;


    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Desembolso();
        $model = new Application_Model_Desembolso;
        $id = $this->_getParam('desembolso_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/desembolso/detalhes/desembolso_id/' . $id);
            $detalhes->populate(array("desembolso" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Desembolso();
        $model = new Application_Model_Desembolso;
        $id = $this->_getParam('desembolso_id');

        $model->delete($id);
        $this->_redirect('/desembolso/');

        $this->view->excluir = $excluir;

    }


}

