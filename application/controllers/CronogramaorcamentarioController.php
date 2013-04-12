<?php

class CronogramaorcamentarioController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
	    $cronogramaOrcamentarioModel = new Application_Model_CronogramaOrcamentario();
        $id = $this->_getParam('projeto_id');
        $cronogramaOrcamentario = $cronogramaOrcamentarioModel->selectAll($id);
        $totalRubricas = $cronogramaOrcamentarioModel->selectTotalRubricas($id);



        $this->view->cronograma_orcamentario = $cronogramaOrcamentario;
        $this->view->total = $cronogramaOrcamentarioModel->selectAllTotal(($id));
        $this->view->id = $id;
        $this->view->totalRubricas = $totalRubricas;


    }

    public function adicionarAction(){

        $decimalfilter = new Zend_Filter_DecimalFilter();
        $id = $this->_getParam('cronograma_orcamentario_id');
        $pid= $this->_getParam('projeto_id');
        $request = $this->getRequest();
        $form = new Application_Form_Cronogramaorcamentario_Cronogramaorcamentario1();
        $model = new Application_Model_CronogramaOrcamentario();
        $cronogramaOrcamentario = $model->selectAll($pid);
       // $totalParcelas = $model->calculaTotal($cronogramaOrcamentario);
        //$form->setValorParcelas($totalParcelas);
        $form->setProjetoId($pid);
        $form->startform();


        if($this->getRequest()->isPost()){

            if($form->isValid($request->getPost())){

                $data = $form->getValues();

                    if($id){
                        $model->update($data, $id);
                    }else{
                        $model->insert($data);
                    }

                $this->_redirect('/cronogramaorcamentario/index/projeto_id/'.$data['cronograma_orcamentario']['projeto_id']);

            }
            $this->view->form = $form;
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                if($data['tipo'] == 1){
                $form->setAction('/cronogramaorcamentario/detalhes/cronograma_orcamentario_id/' . $id . '/projeto_id/' .$pid);
               // $form->setValorParcelas($totalParcelas);
                $form->setProjetoId($pid);
                $form->startform();
                $data['valor_a_receber'] = $decimalfilter->filter($data['valor_a_receber']);
                $data['valor_recebido'] = $decimalfilter->filter($data['valor_recebido']);
                $form->populate(array("cronograma_orcamentario" => $data));
                $this->view->form = $form;

                }
                else if($data['tipo']== 2){
                    $form2= new Application_Form_Cronogramaorcamentario_Cronogramaorcamentario2();
                    $form2->setAction('/cronogramaorcamentario/detalhes/cronograma_orcamentario_id/' . $id . '/projeto_id/' .$pid);
                  //  $form2->setValorParcelas($totalParcelas);
                    $form2->setProjetoId($pid);
                    $form2->startform();
                    $data['valor_a_receber'] = $decimalfilter->filter($data['valor_a_receber']);
                    $data['valor_recebido'] = $decimalfilter->filter($data['valor_recebido']);
                    $form2->populate(array("cronograma_orcamentario" => $data));
                    $this->view->form = $form2;
                }
            }
        }
        else {
            //$form->setValorParcelas($totalParcelas);
            $form->setProjetoId($pid);
            $form->startform();
            $this->view->form = $form;

        }

    }

    public function detalhesAction(){

        $decimalfilter = new Zend_Filter_DecimalFilter();
        $request = $this->getRequest();
        $id = $this->_getParam('cronograma_orcamentario_id');
        $pid= $this->_getParam('projeto_id');
        $detalhes = new Application_Form_Cronogramaorcamentario_Cronogramaorcamentario1();
        //$detalhes->startform();
        $detalhes2= new Application_Form_Cronogramaorcamentario_Cronogramaorcamentario2();
        //$detalhes2->startform();
        $model = new Application_Model_CronogramaOrcamentario();
        $cronogramaOrcamentario = $model->selectAll($pid);
        //$totalParcelas = $model->calculaTotal($cronogramaOrcamentario);
        $this->view->id = $id;
        $this->view->pid= $pid;


        $data = $model->find($id)->toArray();


        if(is_array($data)){
            if($data['tipo']== 1){
                $detalhes->setAction('/cronogramaorcamentario/detalhes/cronograma_orcamentario_id/' . $id . '/projeto_id/' .$pid);
                $detalhes->setProjetoId($pid);
                $detalhes->startform();
                $data['valor_a_receber'] = $decimalfilter->filter($data['valor_a_receber']);
                $data['valor_recebido'] = $decimalfilter->filter($data['valor_recebido']);
                $detalhes->populate(array("cronograma_orcamentario" => $data));
                $this->view->detalhes = $detalhes;
            }
            else if($data['tipo']== 2){
                $detalhes2->setAction('/cronogramaorcamentario/detalhes/cronograma_orcamentario_id/' . $id . '/projeto_id/' .$pid);
                $detalhes2->setProjetoId($pid);
                $detalhes2->startform();
                $data['valor_a_receber'] = $decimalfilter->filter($data['valor_a_receber']);
                $data['valor_recebido'] = $decimalfilter->filter($data['valor_recebido']);
                $detalhes2->populate(array("cronograma_orcamentario" => $data));
                $this->view->detalhes = $detalhes2;
            }

        }

    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Cronogramaorcamentario_Cronogramaorcamentario1();
        $excluir->startform();
        $model = new Application_Model_CronogramaOrcamentario();
        $id = $this->_getParam('cronograma_orcamentario_id');
        $pid = $this->_getParam('projeto_id');

        $model->delete($id);
        $this->_redirect('/cronogramaorcamentario/index/projeto_id/'.$pid);

        $this->view->excluir = $excluir;

    }


}

