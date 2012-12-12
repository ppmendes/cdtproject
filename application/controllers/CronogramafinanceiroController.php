<?php

class CronogramafinanceiroController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	    $cronogramaFinanceiroModel = new Application_Model_CronogramaFinanceiro();
        $id = $this->_getParam('projeto_id');
        $this->view->cronogramaFinanceiro = $cronogramaFinanceiroModel->selectAll($id);
        $this->view->id = $id;


    }

    public function adicionarAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Cronogramafinanceiro();
        $model = new Application_Model_CronogramaFinanceiro();
        $id = $this->_getParam('cronograma_id');


        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                unset($data['cronograma_financeiro']['nomeProjeto']);


                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }

                $this->_redirect('/cronogramafinanceiro/index/projeto_id/'.$data['cronograma_financeiro']['projeto_id']);
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id);
                $form->populate(array("cronograma_financeiro" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Cronogramafinanceiro();
        $model = new Application_Model_CronogramaFinanceiro();
        $id = $this->_getParam('cronograma_financeiro_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();


        if(is_array($data)){
            $detalhes->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id);
            $detalhes->populate(array("cronograma_financeiro" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Cronogramafinanceiro();
        $model = new Application_Model_CronogramaFinanceiro();
        $id = $this->_getParam('projeto_id');

        $model->delete($id);
        $this->_redirect('/cronogramafinanceiro/');

        $this->view->excluir = $excluir;

    }


}

