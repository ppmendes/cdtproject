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
        $model = new Application_Model_Instituicao;
        $id = $this->_getParam('instituicao_id');
        $this->view->pais = 76;
        $form->getElement("estados_id")->setRegisterInArrayValidator(FALSE);
        $form->getElement("cidade_id")->setRegisterInArrayValidator(FALSE);

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                //remover campo ac (auto complete) do array de dados
                unset($data['instituicao']['ac']);
                if($id){
                    //$this->view->pais =
                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }
                $this->_redirect('/instituicoes/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();
            $this->view->pais = $data['pais_id'];
            if(is_array($data)){
                $form->setAction('/instituicoes/detalhes/instituicao_id/' . $id);
                $form->populate(array("instituicao" => $data));
            }
        }

        $this->view->form = $form;
    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Instituicoes();
        $model = new Application_Model_Instituicao;
        $id = $this->_getParam('instituicao_id');
        $this->view->id = $id;

        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/instiuicoes/detalhes/instituicao_id/' . $id);
            $detalhes->populate(array("instituicao" => $data));
        }

        $this->view->detalhes = $detalhes;
    }

    /*public function atualizar(){
        //$request = $this->getRequest();
        $atualizar = new Application_Form_Instituicoes();
        $model = new Application_Model_Instituicao();
        $id = $this->_getParam('instituicao_id');
        $data= $atualizar->getValues();

        $model->atualizar($id,$data);
        $this->_redirect('/instituicao/');

        $this->view->atualizar = $atualizar;
    }*/

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Instituicoes();
        $model = new Application_Model_Instituicao;
        $id = $this->_getParam('instituicao_id');

        $model->delete($id);

        $this->_redirect('/instituicoes/');

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

    public function treeviewAction()
    {
        $layout = $this->_helper->layout();
        $layout->setLayout('iframe');
        $model = new Application_Model_Instituicao();
        $id = $this->_getParam('instituicao_id');
        if($id==null)
        {
            $id=32;
        }
        $this->view->tree = $model->retornaPais();

        // parte do treeview do lado direito
        $result=$model->paeFilhos($id);
        print_r($result);
        $model->criarTreeview($result);

        $this->view->treeview;
    }
}

