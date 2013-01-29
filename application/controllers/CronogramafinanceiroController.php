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
        $form = new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro1();
        $model = new Application_Model_CronogramaFinanceiro();
        $id = $this->_getParam('cronograma_financeiro_id');
        $pid= $this->_getParam('projeto_id');


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
            $this->view->form = $form;
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                if($data['tipo']== 1){
                $form->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id . '/projeto_id/' .$pid);
                $form->populate(array("cronograma_financeiro" => $data));
                $this->view->form = $form;

                }
                else if($data['tipo']== 2){
                    $form2= new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro2();
                    $form2->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id . '/projeto_id/' .$pid);
                    $form2->populate(array("cronograma_financeiro" => $data));
                    $this->view->form = $form2;
                }
            }
        }
        else {
            echo "<script>alert('else')</script>";
            $this->view->form = $form;

        }

    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $detalhes = new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro1();
        $detalhes2= new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro2();
        $model = new Application_Model_CronogramaFinanceiro();
        $id = $this->_getParam('cronograma_financeiro_id');
        $pid= $this->_getParam('projeto_id');
        $this->view->id = $id;
        $this->view->pid= $pid;


        $data = $model->find($id)->toArray();


        if(is_array($data)){
            if($data['tipo']== 1){
                $detalhes->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id . '/projeto_id/' .$pid);
                $detalhes->populate(array("cronograma_financeiro" => $data));
                $this->view->detalhes = $detalhes;
            }
            else if($data['tipo']== 2){
                $detalhes2->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id . '/projeto_id/' .$pid);
                $detalhes2->populate(array("cronograma_financeiro" => $data));
                $this->view->detalhes = $detalhes2;
            }

        }

    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro1();
        $model = new Application_Model_CronogramaFinanceiro();
        $id = $this->_getParam('cronograma_financeiro_id');
        $pid = $this->_getParam('projeto_id');

        $model->delete($id);
        $this->_redirect('/cronogramafinanceiro/index/projeto_id/'.$pid);

        $this->view->excluir = $excluir;

    }


}

