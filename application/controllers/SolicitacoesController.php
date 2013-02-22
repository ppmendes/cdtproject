<?php

class SolicitacoesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $solicitacaoModel = new Application_Model_Solicitacao();
        $this->view->solicitacoes = $solicitacaoModel->selectAll();
        $this->view->solicitacoesAquisicao =  $solicitacaoModel->selectAllAquisicao();
        $this->view->solicitacoesContratacao = $solicitacaoModel->selectAllContratacao();
        $this->view->solicitacoesPassagens = $solicitacaoModel->selectAllPassagens();

    }

    public function adicionaraquisicaoAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Solicitacoes_AquisicaoBens();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        if($this->getRequest()->isPost()){
            $form->preValidation($_POST);

            if($form->isValid($request->getPost())){

                $data = $form->getValues();
                unset($data['solicitacoes']['data_solicitacao_view']);
                unset($data['solicitacoes']['local_entrega_solicitacao_view']);
                unset($data['solicitacoes']['local']);
                unset($data['solicitacoes']['hidden_teste']);
                $data['solicitacoes']['projeto_id'] = 1;

                $numero_itens = $model->concatenaCampos("numero_itens_", $data);
                $solicitacao_nome = $model->concatenaCampos("solicitacao_nome_", $data);
                $preco_unidade = $model->concatenaCampos("preco_unidade_", $data);
                $valor_estimado = $model->concatenaCampos("valor_estimado_", $data);

                for ($i=2 ; $i<11 ; $i++)
                {
                    if (array_key_exists("numero_itens_" . $i, $data['solicitacoes']) == 1)
                    {
                        unset($data['solicitacoes']['numero_itens_' . $i]);
                        unset($data['solicitacoes']['solicitacao_nome_' . $i]);
                        unset($data['solicitacoes']['preco_unidade_' . $i]);
                        unset($data['solicitacoes']['valor_estimado_' . $i]);
                    }
                }


                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insert($data, $numero_itens, $solicitacao_nome, $preco_unidade, $valor_estimado);
                }

                $this->_redirect('/solicitacoes/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/solicitacoes/detalhes/solicitacao_id/' . $id);
                $form->populate(array("solicitacoes" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function adicionarcontratacaoAction(){
        $request = $this->getRequest();
        $form = new Application_Form__Solicitacoes_ContratacaoServicos();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        if($this->getRequest()->isPost()){

            $form->preValidation($_POST);


            if($form->isValid($request->getPost())){

                $data = $form->getValues();

                if($id){
                    $model->update($data, $id);
                }else{

                    $model->insert($data);
                }

                $this->_redirect('/solicitacoes/');


            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/solicitacoes/detalhes/solicitacao_id/' . $id);
                $form->populate(array("solicitacoes" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function adicionarpassagensAction(){
        $request = $this->getRequest();
        $form = new Application_Form__Solicitacoes_PassagensDiarias();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){
                echo "<pre>";
                print_r($form->getValues());
                echo "</pre>";
                exit;
                $data = $form->getValues();
                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insert($data);
                }

                $this->_redirect('/solicitacoes/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){
                $form->setAction('/solicitacoes/detalhes/solicitacao_id/' . $id);
                $form->populate(array("solicitacoes" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');
        $this->view->id = $id;

        $data = $model->find($id)->toArray();

        if($data['tipo_solicitacao_id'] == 1 || $data['tipo_solicitacao_id'] == 4 || $data['tipo_solicitacao_id'] == 5)
        {
        $detalhes = new Application_Form_Solicitacoes_AquisicaoBens();
        }else if ($data['tipo_solicitacao_id'] == 2 || $data['tipo_solicitacao_id'] == 6 ||
                  $data['tipo_solicitacao_id'] == 7 || $data['tipo_solicitacao_id'] == 8)
        {
        $detalhes = new Application_Form__Solicitacoes_ContratacaoServicos();
        }else
        {
        $detalhes = new Application_Form__Solicitacoes_PassagensDiarias();
        }

        if(is_array($data)){
            $detalhes->setAction('/solicitacoes/detalhes/solicitacao_id/' . $id);
            $detalhes->populate(array("solicitacoes" => $data));
        }

        $this->view->detalhes = $detalhes;


    }

    public function excluirAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Solicitacoes();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        $model->delete($id);
        $this->_redirect('/solicitacoes/');

        $this->view->excluir = $excluir;

    }


}

