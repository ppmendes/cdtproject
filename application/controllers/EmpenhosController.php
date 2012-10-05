<?php

class EmpenhosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	    $model = new Application_Model_Empenho();
        $this->view->resultado = $model->selectAll();

    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Empenhos();
        $model = new Application_Model_Empenho;
        $id = $this->_getParam('id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                if($id){
                    $model->update($data['empenhos'], $id);
                }else{
                    $model->insert($data['empenhos']);
                }

                $this->_redirect('/empenhos/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->populate(array("empenhos" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Empenhos();
        $model = new Application_Model_Empenho;
        $id = $this->_getParam('id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->populate(array("empenhos" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function excluirAction(){
        $excluir = new Application_Form_Empenhos();
        $model = new Application_Model_Empenho;
        $id = $this->_getParam('id');

        $model->delete($id);
        $this->_redirect('/empenhos/');

        $this->view->excluir = $excluir;

    }


}

