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

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Beneficiarios_Beneficiariospf();
        $model = new Application_Model_Beneficiario();
        $id = $this->_getParam('beneficiario_id');
        $form->getElement("estados_id")->setRegisterInArrayValidator(FALSE);
        $form->getElement("cidade_id")->setRegisterInArrayValidator(FALSE);

        if (!$id)
        {
            $this->view->pais = 76;
            $this->view->tipo = 1;
        }
        else
        {
            $this->view->id = $id;
        }

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

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
            $this->view->pais = $data['pais_id'];
            $this->view->tipo = $data['tipo_beneficiario_id'];
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
        $this->view->pais = 76;
        $form->getElement("estados_id")->setRegisterInArrayValidator(FALSE);
        $form->getElement("cidade_id")->setRegisterInArrayValidator(FALSE);

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
            $this->view->pais = $data['pais_id'];

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

    public function selectestadosAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if ($this->_request->getParam('id', 0)) {
            $id = (int) $this->_request->getParam('id', 0);
            $filhos = new Application_Model_DbTable_Estados();
            $rows = $filhos->fetchAll('pais_id = ' . (int) $id);
            echo '<option value="">Selecione</option>';
            foreach ($rows as $row) {
                echo '<option value="' . $row->estados_id . '">' . $row->estados_nome . '</option>';
            }
        } else {
            echo '<option value="">Selecione</option>';
        }
    }

    public function selectcidadesAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if ($this->_request->getParam('id', 0)) {
            $id = (int) $this->_request->getParam('id', 0);
            $filhos = new Application_Model_DbTable_Cidade();
            $rows = $filhos->fetchAll('estados_id = ' . (int) $id);
            echo '<option value="">Selecione</option>';
            foreach ($rows as $row) {
                echo '<option value="' . $row->cidade_id . '">' . $row->cidade_nome . '</option>';
            }
        } else {
            echo '<option value="">Selecione</option>';
        }
    }


}

