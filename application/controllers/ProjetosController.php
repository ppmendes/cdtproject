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
        $this->view->projetos = $projetoModel->selectAll();

    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Projetos();
        $model = new Application_Model_Projeto;
        $id = $this->_getParam('projeto_id');


        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                $usuario_logado = Zend_Auth::getInstance()->getStorage()->read();
                $data['projetos']['criador']=$usuario_logado->usuario_id;

                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }

                $this->_redirect('/projetos/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/projetos/detalhes/projeto_id/' . $id);
                $form->populate(array("projetos" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Projetos();
        $model = new Application_Model_Projeto;
        $id = $this->_getParam('projeto_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/projetos/detalhes/projeto_id/' . $id);
            $detalhes->populate(array("projetos" => $data));
        }

        $this->view->detalhes = $detalhes;
    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Projetos();
        $model = new Application_Model_Projeto;
        $id = $this->_getParam('projeto_id');

        $model->delete($id);
        $this->_redirect('/projetos/');

        $this->view->excluir = $excluir;

    }


}

