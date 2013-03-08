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
        $form->startform();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        if($this->getRequest()->isPost()){
            $form->startform();
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
                    $model->insertAquisicao($data, $numero_itens, $solicitacao_nome, $preco_unidade, $valor_estimado);
                }

                $this->_redirect('/solicitacoes/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){

                $form->setAction('/solicitacoes/detalhes/solicitacao_id/' . $id);
                $form->startform();


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


                //Unset nos campos de beneficário, pois só armazena em solicitações o ID
                unset($data['solicitacoes']['cpf_cnpj']);
                unset($data['solicitacoes']['rg_ie']);
                unset($data['solicitacoes']['pis_inss']);
                unset($data['solicitacoes']['endereco_contratado']);
                unset($data['solicitacoes']['telefone_contratado']);
                unset($data['solicitacoes']['email_ccontratado']);
                unset($data['solicitacoes']['banco_id']);
                unset($data['solicitacoes']['agencia_banco']);
                unset($data['solicitacoes']['conta_bancaria']);

                $data['solicitacoes']['projeto_id'] = 1;

                //Concatenação de todos os campos que podem ser múltiplos, para salvar em apenas um campo no banco
                $descricao = $model->concatenaCampos("descricao_", $data);
                $produto = $model->concatenaCampos("produto_", $data);
                $qtde = $model->concatenaCampos("qtde_", $data);
                $cronograma_inicio = $model->concatenaCampos("cronograma_inicio_", $data);
                $cronograma_termino = $model->concatenaCampos("cronograma_termino_", $data);
                $valor_total = $model->concatenaCampos("valor_total_", $data);
                $execucao_inicio = $model->concatenaCampos("execucao_inicio_", $data);
                $execucao_termino = $model->concatenaCampos("execucao_termino_", $data);
                $qtd_parcelas = $model->concatenaCampos("qtd_parcelas_", $data);
                $valor_parcelas = $model->concatenaCampos("valor_parcelas_", $data);
                $data_pagamento = $model->concatenaCampos("data_pagamento_", $data);


                //Conta quantos campos existem no primeiro conjunto de campos que podem ser adicionados pelo botão "mais" no form
                for ($i=2 ; $i<11 ; $i++)
                {
                    //conta quantos são os campos descricao_i, 2<i<11, dentro do array data[solicitacoes] e dá unset
                    //todos estes campos já foram concatenados acima e serão salvos em apenas um campo na tabela do banco
                    if (array_key_exists("descricao_" . $i, $data['solicitacoes']) == 1)
                    {
                        unset($data['solicitacoes']['descricao_' . $i]);
                        unset($data['solicitacoes']['produto_' . $i]);
                        unset($data['solicitacoes']['qtde_' . $i]);
                        unset($data['solicitacoes']['cronograma_inicio_' . $i]);
                        unset($data['solicitacoes']['cronograma_termino_' . $i]);
                    }
                }

                //Conta quantos campos existem no segundo conjunto de campos que podem ser adicionados pelo botão "mais" no form
                for ($i=2 ; $i<11 ; $i++)
                {
                    //conta quantos são os campos valor_total_i, 2<i<11, dentro do array data[solicitacoes] e dá unset
                    //todos estes campos já foram concatenados acima e serão salvos em apenas um campo na tabela do banco
                    if (array_key_exists("valor_total" . $i, $data['solicitacoes']) == 1)
                    {
                        unset($data['solicitacoes']['valor_total_' . $i]);
                        unset($data['solicitacoes']['execucao_inicio_' . $i]);
                        unset($data['solicitacoes']['execucao_termino_' . $i]);
                        unset($data['solicitacoes']['qtd_parcelas_' . $i]);
                        unset($data['solicitacoes']['valor_parcelas_' . $i]);
                        unset($data['solicitacoes']['data_pagamento_' . $i]);
                    }
                }

                if($id){
                    $model->update($data, $id);
                }else{

                    $model->insertContratacao($data, $descricao, $produto, $qtde, $cronograma_inicio,$cronograma_termino,
                        $valor_total, $execucao_inicio, $execucao_termino, $qtd_parcelas, $valor_parcelas, $data_pagamento);
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
            $detalhes->startform();

            $array1 = explode("|", $data['numero_itens']);
            $array2 = explode("|", $data['solicitacao_nome']);
            $array3 = explode("|", $data['preco_unidade']);
            $array4 = explode("|", $data['valor_estimado']);

            $data['numero_itens'] = $array1[0];
            $data['solicitacao_nome'] = $array2[0];
            $data['preco_unidade'] = $array3[0];
            $data['valor_estimado'] = $array4[0];

            $order = 18;

            for ($i=2 ; $i<11 ; $i++)
            {
                if (array_key_exists($i - 1, $array1) == 1)
                {
                    $name1 = "numero_itens_" . $i;
                    $data[$name1] = $array1[$i - 1];

                    $name2 = "solicitacao_nome_" . $i;
                    $data[$name2] = $array2[$i - 1];

                    $name3 = "preco_unidade_" . $i;
                    $data[$name3] = $array3[$i - 1];

                    $name4 = "valor_estimado_" . $i;
                    $data[$name4] = $array4[$i - 1];

                    $detalhes->addNewField($name1, $array1[$i - 1], $name2, $array2[$i - 1], $name3, $array3[$i - 1],
                                           $name4, $array4[$i - 1], $order, $i);

                    $order = $order + 4;

                }
            }


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


    public function combogridprojetoAction()
    {
        $page = $this->_getParam('page');
        $limit = $this->_getParam('rows');
        $sidx = $this->_getParam('sidx');
        $sord = $this->_getParam('sord');

        $searchTerm = $this->_getParam('searchTerm');

        if(!$sidx){
            $sidx = 'projeto_id';
            $sord = 'ASC';
        }
        if ($searchTerm=="") {
            $searchTerm="%";
        } else {
            $searchTerm = "%" . $searchTerm . "%";
        }

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $where = 'nome like ? or apelido like ?';

        $select = $dbAdapter->select()->from('projeto',array('count(*) as count'))->where($where,$searchTerm);

        $qtdRubrica = $dbAdapter->fetchAll($select);
        $count = $qtdRubrica[0]['count'];

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        if($total_pages!=0)
        {
            $select = $dbAdapter->select()->from('projeto',array('projeto_id','nome','apelido'))->where($where,$searchTerm)
                ->order(array("$sidx $sord"))->limit($limit,$start);
        }
        else{
            $select = $dbAdapter->select()->from('projeto',array('projeto_id','nome','apelido'))->where($where,$searchTerm)
                ->order(array("$sidx $sord"));
        }

        try{
            $rows = $dbAdapter->fetchAll($select);


            $response->page = $page;
            $response->total = $total_pages;
            $response->records = $count;
            $response->rows = $rows;

            echo json_encode($response);
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }


        exit;
    }

    public function combogridbeneficiarioAction()
    {
        $page = $this->_getParam('page');
        $limit = $this->_getParam('rows');
        $sidx = $this->_getParam('sidx');
        $sord = $this->_getParam('sord');

        $searchTerm = $this->_getParam('searchTerm');

        if(!$sidx){
            $sidx = 'beneficario_id';
            $sord = 'ASC';
        }
        if ($searchTerm=="") {
            $searchTerm="%";
        } else {
            $searchTerm = "%" . $searchTerm . "%";
        }

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $where = 'nome like ? or cpf_cnpj like ?';

        $select = $dbAdapter->select()->from('beneficiario',array('count(*) as count'))->where($where,$searchTerm);

        $qtdRubrica = $dbAdapter->fetchAll($select);
        $count = $qtdRubrica[0]['count'];

        if( $count >0 ) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) $page=$total_pages;
        $start = $limit*$page - $limit;

        if($total_pages!=0)
        {
            $select = $dbAdapter->select()->from('beneficiario',array('beneficiario_id','nome','cpf_cnpj'))->where($where,$searchTerm)
                ->order(array("$sidx $sord"))->limit($limit,$start);
        }
        else{
            $select = $dbAdapter->select()->from('beneficiario',array('beneficiario_id','nome','cpf_cnpj'))->where($where,$searchTerm)
                ->order(array("$sidx $sord"));
        }

        try{
            $rows = $dbAdapter->fetchAll($select);


            $response->page = $page;
            $response->total = $total_pages;
            $response->records = $count;
            $response->rows = $rows;

            echo json_encode($response);
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }


        exit;
    }

    public function preenchecoordenadorAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if ($this->_request->getParam('id', 0))
        {
            $id = (int) $this->_request->getParam('id', 0);
            $campos = new Application_Model_DbTable_Usuario();
            $row = $campos->fetchAll('usuario_id = ' . (int) $id)->toArray();
        }
        else
        {
            $row = '';
        }

        echo json_encode($row[0]);
    }


    public function preenchebeneficiarioAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();

        if ($this->_request->getParam('id', 0))
        {
            $id = (int) $this->_request->getParam('id', 0);
            $campos = new Application_Model_DbTable_Beneficiario();
            $row = $campos->fetchAll('beneficiario_id = ' . (int) $id)->toArray();
        }
        else
        {
            $row = '';
        }

        echo json_encode($row[0]);
    }


}

