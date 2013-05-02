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
        $pid = $this->_getParam('projeto_id');
        $cronogramaFinanceiro = $cronogramaFinanceiroModel->selectAll($pid);
        $this->view->cronogramaFinanceiro = $cronogramaFinanceiro;
        //$this->form->array = $cronogramaFinanceiro;
        $this->view->pid = $pid;


    }

    public function adicionarAction(){

        $id = $this->_getParam('cronograma_financeiro_id');
        $pid= $this->_getParam('projeto_id');
        $request = $this->getRequest();
        $form = new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro1();
        $form2 = new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro2();
        $model = new Application_Model_CronogramaFinanceiro();
        $cronogramaFinanceiro = $model->selectAll($pid);


        $totalParcelas = $model->calculaTotal($cronogramaFinanceiro);

        $form->setValorParcelas($totalParcelas);
        $form->setProjetoId($pid);
        $form->startform();

        $form2->setValorParcelas($totalParcelas);
        $form2->setProjetoId($pid);
        $form2->startform();


        if($this->getRequest()->isPost()){
            $tipo_form_aux = $request->getPost();
            $tipo_form = $tipo_form_aux['cronograma_financeiro']['tipo_form'];

            if ($tipo_form == 1)
            {
            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                unset($data['cronograma_financeiro']['tipo_form']);

                    if($id){
                        $model->update($data, $id);
                    }else{
                        $model->insert($data);
                    }

                $this->_redirect('/cronogramafinanceiro/index/projeto_id/'.$data['cronograma_financeiro']['projeto_id']);

            }
            $this->view->form = $form;
            }
            else
            {
                if($form2->isValid($request->getPost())){

                $data = $form2->getValues();
                unset($data['cronograma_financeiro']['tipo_form']);

                    if($id){
                        $model->update($data, $id);
                    }else{
                        $model->insert($data);
                    }

                $this->_redirect('/cronogramafinanceiro/index/projeto_id/'.$data['cronograma_financeiro']['projeto_id']);

            }
                $this->view->form = $form2;
            }
        }elseif ($id){
            $form2= new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro2();
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $tipo = $data['tipo'];

                 $this->view->tipo = $tipo;


                $form2->setTipo($tipo);
                $form2->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id . '/projeto_id/' .$pid);
                $form2->setValorParcelas($totalParcelas);
                $form2->setProjetoId($pid);
                $form2->startform();
                $form2->populate(array("cronograma_financeiro" => $data));
                $this->view->form = $form2;

//                }
//                else if($tipo == 2){
//                    $form2= new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro2();
//                    $form2->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id . '/projeto_id/' .$pid);
//                    $form2->setValorParcelas($totalParcelas);
//                    $form2->setProjetoId($pid);
//                    $form2->startform();
//                    $form2->populate(array("cronograma_financeiro" => $data));
//                    $this->view->form = $form2;
//                }
            }
        }
        else {
            $form->setValorParcelas($totalParcelas);
            $form->setProjetoId($pid);
            $form->startform();
            $this->view->form = $form;

        }

    }

    public function detalhesAction(){

        $request = $this->getRequest();
        $id = $this->_getParam('cronograma_financeiro_id');
        $pid= $this->_getParam('projeto_id');
        $detalhes = new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro1();
        //$detalhes->startform();
        $detalhes2= new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro2();
        //$detalhes2->startform();
        $model = new Application_Model_CronogramaFinanceiro();
        $cronogramaFinanceiro = $model->selectAll($pid);
        $totalParcelas = $model->calculaTotal($cronogramaFinanceiro);
        $this->view->id = $id;
        $this->view->pid= $pid;


        $data = $model->find($id)->toArray();


        if(is_array($data)){
            if($data['tipo']== 1){
                $detalhes->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id . '/projeto_id/' .$pid);
                $detalhes->setValorParcelas($totalParcelas);
                $detalhes->setProjetoId($pid);
                $detalhes->startform();
                $detalhes->populate(array("cronograma_financeiro" => $data));
                $this->view->detalhes = $detalhes;
            }
            else if($data['tipo']== 2){
                $detalhes2->setAction('/cronogramafinanceiro/detalhes/cronograma_financeiro_id/' . $id . '/projeto_id/' .$pid);
                $detalhes2->setValorParcelas($totalParcelas);
                $detalhes2->setProjetoId($pid);
                $detalhes2->startform();
                $detalhes2->populate(array("cronograma_financeiro" => $data));
                $this->view->detalhes = $detalhes2;
            }

        }

    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Cronogramafinanceiro_Cronogramafinanceiro1();
        $excluir->startform();
        $model = new Application_Model_CronogramaFinanceiro();
        $id = $this->_getParam('cronograma_financeiro_id');
        $pid = $this->_getParam('projeto_id');

        $model->delete($id);
        $this->_redirect('/cronogramafinanceiro/index/projeto_id/'.$pid);

        $this->view->excluir = $excluir;

    }
    
    public function receberAction() {
        $id = $this->_getParam('cronograma_financeiro_id');
        $pid = $this->_getParam('projeto_id');
        $model = new Application_Model_CronogramaFinanceiro();
        $model->receber($id);
        $this->_redirect('/cronogramafinanceiro/index/projeto_id/'.$pid);
    }


}

