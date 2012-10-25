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
        $this->view->beneficiariospf = $beneficiariosModel->selectAllpf();
        $this->view->beneficiariospj = $beneficiariosModel->selectAllpj();

    }

    public function adicionarpfAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Beneficiarios_Beneficiariospf();
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
                $form->setAction('/beneficiarios/detalhespf/beneficiario_id/' . $id);
                $form->populate(array("beneficiario" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function adicionarpjAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Beneficiarios_Beneficiariospj();
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
                $form->setAction('/beneficiarios/detalhespj/beneficiario_id/' . $id);
                $form->populate(array("beneficiario" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function detalhespfAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Beneficiarios_Beneficiariospf();
        $model = new Application_Model_Beneficiario();
        $id = $this->_getParam('beneficiario_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/beneficiarios/detalhespf/beneficiario_id/' . $id);
            $detalhes->populate(array("beneficiario" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function detalhespjAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Beneficiarios_Beneficiariospj();
        $model = new Application_Model_Beneficiario();
        $id = $this->_getParam('beneficiario_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/beneficiarios/detalhespj/beneficiario_id/' . $id);
            $detalhes->populate(array("beneficiario" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function excluirpfAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Beneficiarios_Beneficiariospf();
        $model = new Application_Model_Beneficiario();
        $id = $this->_getParam('beneficiario_id');

        $model->delete($id);
        $this->_redirect('/beneficiarios/');

        $this->view->excluir = $excluir;

    }

    public function excluirpjAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Beneficiarios_Beneficiariospj();
        $model = new Application_Model_Beneficiario();
        $id = $this->_getParam('beneficiario_id');

        $model->delete($id);
        $this->_redirect('/beneficiarios/');

        $this->view->excluir = $excluir;

    }


}

