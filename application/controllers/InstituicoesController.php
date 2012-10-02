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
        $detalhes = new Application_Form_Instituicoes();
        $model = new Application_Model_Instituicao;
        $id = $this->_getParam('instituicao_id');

        if($this->getRequest()->isPost()){
            if($detalhes->isValid($request->getPost())){

                $data=$detalhes->getValues();
                if($id)
                {
                    $where = $model->getAdapter()->quoteInto('id = ?',$id);
                    $model->update($data,$where);
                }else{
                    $model->insert($data);
                }
                $this->_redirect('/instituicao');
            }
        }elseif($id){
            $data = $model->find($id)->toArray();
            if(is_array($data)){
                $detalhes->setAction('/instituicao/detalhes/instituicao_id/' . $id);
                $detalhes->populate(array("instituicao" => $data));
            }
        }
        $this->view->detalhes = $detalhes;
    }

    public function atualizar()
    {
        //$request = $this->getRequest();
        $atualizar = new Application_Form_Instituicoes();
        $model = new Application_Model_Instituicao();
        $id = $this->_getParam('instituicao_id');
        $data= $atualizar->getValues();

        $model->atualizar($id,$data);
        $this->_redirect('/instituicao/');

        $this->view->atualizar = $atualizar;
    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Instituicoes();
        $model = new Application_Model_Instituicao;
        $id = $this->_getParam('instituicao_id');

        $model->delete($id);
        $this->_redirect('/instituicao/');

        $this->view->excluir = $excluir;

    }
}

