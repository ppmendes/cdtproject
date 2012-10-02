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
        /*$projetoModel = $projetoModel->fetchAll();
        $prioridade = $projetoModel->findParentApplication_Model_DbTable_Prioridade();
        $modoContratacao = $projetoModel->findParentApplication_Model_DbTable_ModoContratacao();
        $projetoTipo = $projetoModel->findParentApplication_Model_DbTable_ProjetoTipo();
        $instituicao = $projetoModel->findParentApplication_Model_DbTable_Instituicao();
        $estado_projeto = $projetoModel->findParentApplication_Model_DbTable_EstadoProjeto();
        $categoriaFinanciador = $projetoModel->findParentApplication_Model_DbTable_CategoriaFinanciador();
        $coordenador = $projetoModel->findParentApplication_Model_DbTable_UsuarioByCoordenador();
        $gerente = $projetoModel->findParentApplication_Model_DbTable_UsuarioByGerente();
        $criador = $projetoModel->findParentApplication_Model_DbTable_UsuarioByCriador();

        $this->view->prioridade = $prioridade;
        $this->view->modoContratacao = $modoContratacao;
        $this->view->projetoTipo = $projetoTipo;
        $this->view->instituicao = $instituicao;
        $this->view->estado_projeto = $estado_projeto;
        $this->view->categoriaFinanciador = $categoriaFinanciador;
        $this->view->coordenador = $coordenador;
        $this->view->gerente = $gerente;
        $this->view->criador = $criador;    */
        $this->view->projetos = $projetoModel->selectAll();

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

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Projetos();
        $model = new Application_Model_Projeto;
        $id = $this->_getParam('projeto_id');

        if($this->getRequest()->isPost()){
            if($detalhes->isValid($request->getPost())){
                echo "<pre>";
                print_r($detalhes->getValues());
                echo "</pre>";
            }
        }

        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/projetos/detalhes/projeto_id/' . $id);
            $detalhes->populate(array("projetos" => $data));
        }

        $this->view->detalhes = $detalhes;


    }


}

