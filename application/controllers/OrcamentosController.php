<?php

class OrcamentosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $orcamentoModel = new Application_Model_Orcamento();
        $this->view->orcamentos = $orcamentoModel->selectAll();

    }

    public function adicionarAction(){


        //$request = $this->getRequest();

        $form = new Application_Form_Orcamentos();
        $this->view->form = $form;
        //$model = new Application_Model_Projeto;
        //$id = $this->_getParam('orcamento_id');

        /*if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                  //echo "<pre>";
                  //print_r($form->getValues());
                  //echo "</pre>";
                $data = $form->getValues();
                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }

                $this->_redirect('/orcamentos/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/orcamentos/detalhes/orcamento_id/' . $id);
                $form->populate(array("orcamentos" => $data));
            }
        }*/

       //$this->view->form = $form;
    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Orcamentos();
        $model = new Application_Model_Projeto;
        $id = $this->_getParam('orcamento_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        if(is_array($data)){
            $detalhes->setAction('/orcamentos/detalhes/orcamento_id/' . $id);
            $detalhes->populate(array("orcamentos" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Orcamentos();
        $model = new Application_Model_Projeto;
        $id = $this->_getParam('orcamento_id');

        $model->delete($id);
        $this->_redirect('/orcamentos/');

        $this->view->excluir = $excluir;

    }


}

