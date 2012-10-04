<?php

class BeneficiariosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $beneficiariosModel = new Application_Model_Beneficiario();
        $this->view->beneficiarios = $beneficiariosModel->selectAll();

    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Beneficiarios();
        $model = new Application_Model_Beneficiario();
        $id = $this->_getParam('beneficiario_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
//                echo "<pre>";
//                print_r($form->getValues());
//                echo "</pre>";
                $data = $form->getValues();
                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }

                $this->_redirect('/beneficiarios/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/beneficiarios/detalhes/beneficiario_id/' . $id);
                $form->populate(array("beneficiario" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Beneficiarios();
        $model = new Application_Model_Beneficiario();
        $id = $this->_getParam('beneficiario_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/beneficiarios/detalhes/beneficiario_id/' . $id);
            $detalhes->populate(array("beneficiario" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Beneficiarios();
        $model = new Application_Model_Beneficiario();
        $id = $this->_getParam('beneficiario_id');

        $model->delete($id);
        $this->_redirect('/beneficiarios/');

        $this->view->excluir = $excluir;

    }


}

