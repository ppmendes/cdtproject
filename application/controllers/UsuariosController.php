<?php

class UsuarioController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $usuarioModel = new Application_Model_Usuario();
        $this->view->usuario = $usuarioModel->selectAll();
    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Usuarios();
        $model = new Application_Model_Usuario;
        $id = $this->_getParam('usuario_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                if($id){

                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }
                $this->_redirect('/usuarios/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/usuarios/detalhes/usuario_id/' . $id);
                $form->populate(array("usuarios" => $data));
            }
        }

        $this->view->form = $form;
    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Usuarios();
        $model = new Application_Model_Usuario;
        $id = $this->_getParam('usuario_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/usuarios/detalhes/usuario_id/' . $id);
            $detalhes->populate(array("usuarios" => $data));
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
        $excluir = new Application_Form_Usuarios();
        $model = new Application_Model_Usuario;
        $id = $this->_getParam('usuario_id');

        $model->delete($id);

        $this->_redirect('/usuarios/');

        $this->view->excluir = $excluir;
    }
}

