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
        $modoContratacao = $projetoModel->findParentApplication_Model_DbTable_ModoContratacao();
        $projetoTipo = $projetoModel->findParentApplication_Model_DbTable_ProjetoTipo();
        $instituicao = $projetoModel->findParentApplication_Model_DbTable_Instituicao();
        $estado_projeto = $projetoModel->findParentApplication_Model_DbTable_EstadoProjeto();
        $categoriaFinanciador = $projetoModel->findParentApplication_Model_DbTable_CategoriaFinanciador();
        echo "<pre>";

        echo "</pre>";
        $this->view->prioridade = $prioridade;
        $this->view->modoContratacao = $modoContratacao;
        $this->view->projetoTipo = $projetoTipo;
        $this->view->instituicao = $instituicao;
        $this->view->estado_projeto = $estado_projeto;
        $this->view->categoriaFinanciador = $categoriaFinanciador;

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

