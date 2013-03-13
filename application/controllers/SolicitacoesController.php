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
                unset($data['solicitacoes']['projeto']);
                $data['solicitacoes']['coordenador_projeto'] = $data['solicitacoes']['coordenador_tecnico_id'];
                unset($data['solicitacoes']['coordenador_tecnico_id']);

                $data['solicitacoes']['preco_total'] = intval($data['solicitacoes']['valor_estimado']);

                for ($i=2 ; $i<11 ; $i++)
                {
                    if (array_key_exists("numero_itens_" . $i, $data['solicitacoes']) == 1)
                    {
                        $data['solicitacoes']['preco_total'] += intval($data['solicitacoes']['valor_estimado_' . $i]);
                    }
                }

                $numero_itens = $model->concatenaCampos("numero_itens_", $data);
                $descricao = $model->concatenaCampos("descricao_", $data);
                $preco_unidade = $model->concatenaCampos("preco_unidade_", $data);
                $valor_estimado = $model->concatenaCampos("valor_estimado_", $data);


                for ($i=2 ; $i<11 ; $i++)
                {
                    if (array_key_exists("numero_itens_" . $i, $data['solicitacoes']) == 1)
                    {
                        unset($data['solicitacoes']['numero_itens_' . $i]);
                        unset($data['solicitacoes']['descricao_' . $i]);
                        unset($data['solicitacoes']['preco_unidade_' . $i]);
                        unset($data['solicitacoes']['valor_estimado_' . $i]);
                    }
                }


                if($id){

                    $model->updateaquisicao($data, $id, $numero_itens, $descricao, $preco_unidade, $valor_estimado);
                }else{
                    $model->insertAquisicao($data, $numero_itens, $descricao, $preco_unidade, $valor_estimado);
                }

                $this->_redirect('/solicitacoes/');
            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){

                $dadosProjeto = $model->buscaProjetoNome($id);

                $data['coordenador_projeto_id'] = $data['coordenador_projeto'];
                $data['email'] = $dadosProjeto[0]['cp.email'];
                $data['telefone_coordenador'] = $dadosProjeto[0]['cp.telefone'];
                $data['fax_coordenador'] = $dadosProjeto[0]['cp.celular'];
                $data['projeto'] = $dadosProjeto[0]['p.nome'];
                $data['coordenador_projeto'] = $dadosProjeto[0]['cp.username'];
                $data['projeto'] = $dadosProjeto[0]['p.nome'];
                $data['coordenador_tecnico_id'] = $dadosProjeto[0]['cp.usuario_id'];

                $form = new Application_Form_Solicitacoes_AquisicaoBens();
                $form->startform();

                $array1 = explode("|", $data['numero_itens']);
                $array2 = explode("|", $data['descricao']);
                $array3 = explode("|", $data['preco_unidade']);
                $array4 = explode("|", $data['valor_estimado']);

                $data['numero_itens'] = $array1[0];
                $data['descricao'] = $array2[0];
                $data['preco_unidade'] = $array3[0];
                $data['valor_estimado'] = $array4[0];

                $order = 18;

                for ($i=2 ; $i<11 ; $i++)
                {
                    if (array_key_exists($i - 1, $array1) == 1)
                    {
                        $name1 = "numero_itens_" . $i;
                        $data[$name1] = $array1[$i - 1];

                        $name2 = "descricao_" . $i;
                        $data[$name2] = $array2[$i - 1];

                        $name3 = "preco_unidade_" . $i;
                        $data[$name3] = $array3[$i - 1];

                        $name4 = "valor_estimado_" . $i;
                        $data[$name4] = $array4[$i - 1];

                        $form->addNewField($name1, $array1[$i - 1], $name2, $array2[$i - 1], $name3, $array3[$i - 1],
                            $name4, $array4[$i - 1], $order, $i);

                        $order = $order + 4;

                    }
                }

                $form->setAction('/solicitacoes/detalhes/solicitacao_id/' . $id);


                $form->populate(array("solicitacoes" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function adicionarcontratacaoAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Solicitacoes_ContratacaoServicos();
        $form->startform();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        if($this->getRequest()->isPost()){

            $form->preValidation($_POST);


            if($form->isValid($request->getPost())){

                $data = $form->getValues();

               // unset($data['solicitacoes']['data_solicitacao_view']);

                //Unset nos campos de beneficário, pois só armazena em solicitações o ID
//                unset($data['solicitacoes']['cpf_cnpj']);
//                unset($data['solicitacoes']['rg_ie']);
//                unset($data['solicitacoes']['pis_inss']);
//                unset($data['solicitacoes']['endereco_contratado']);
//                unset($data['solicitacoes']['telefone_contratado']);
//                unset($data['solicitacoes']['email_ccontratado']);
//                unset($data['solicitacoes']['banco_id']);
//                unset($data['solicitacoes']['agencia_banco']);
//                unset($data['solicitacoes']['conta_bancaria']);
                unset($data['solicitacoes']['hidden_teste']);
                unset($data['solicitacoes']['hidden_teste2']);

               // unset($data['solicitacoes']['projeto']);
                $data['solicitacoes']['coordenador_projeto'] = $data['solicitacoes']['coordenador_tecnico_id'];
                unset($data['solicitacoes']['coordenador_tecnico_id']);
               // unset($data['solicitacoes']['beneficiario']);

                $data['solicitacoes']['tipo_solicitacao_id'] = 2;


                //Concatenação de todos os campos que podem ser múltiplos, para salvar em apenas um campo no banco
                $descricao = $model->concatenaCampos("descricao_", $data);
                $produto = $model->concatenaCampos("produto_", $data);
                $numero_itens = $model->concatenaCampos("numero_itens_", $data);
                $cronograma_inicio = $model->concatenaCampos("cronograma_inicio_", $data);
                $cronograma_termino = $model->concatenaCampos("cronograma_termino_", $data);
                $preco_total = $model->concatenaCampos("preco_total_", $data);
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
                        unset($data['solicitacoes']['numero_itens_' . $i]);
                        unset($data['solicitacoes']['cronograma_inicio_' . $i]);
                        unset($data['solicitacoes']['cronograma_termino_' . $i]);
                    }
                }

                //Conta quantos campos existem no segundo conjunto de campos que podem ser adicionados pelo botão "mais" no form
                for ($i=2 ; $i<11 ; $i++)
                {
                    //conta quantos são os campos preco_total_i, 2<i<11, dentro do array data[solicitacoes] e dá unset
                    //todos estes campos já foram concatenados acima e serão salvos em apenas um campo na tabela do banco
                    if (array_key_exists("preco_total_" . $i, $data['solicitacoes']) == 1)
                    {
                        unset($data['solicitacoes']['preco_total_' . $i]);
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

                    $model->insertContratacao($data, $descricao, $produto, $numero_itens, $cronograma_inicio,$cronograma_termino,
                        $preco_total, $execucao_inicio, $execucao_termino, $qtd_parcelas, $valor_parcelas, $data_pagamento);
                }

                $this->_redirect('/solicitacoes/');


            }
        }elseif ($id){
            $data = $model->find($id)->toArray();

            if(is_array($data)){

                //Preencher dados de projeto e coordenador
                $dadosProjeto = $model->buscaProjetoNome($id);

                $data['coordenador_projeto_id'] = $data['coordenador_projeto'];
                $data['email'] = $dadosProjeto[0]['cp.email'];
                $data['telefone_coordenador'] = $dadosProjeto[0]['cp.telefone'];
                $data['fax_coordenador'] = $dadosProjeto[0]['cp.celular'];
                $data['projeto'] = $dadosProjeto[0]['p.nome'];
                $data['coordenador_projeto'] = $dadosProjeto[0]['cp.username'];
                $data['projeto'] = $dadosProjeto[0]['p.nome'];
                $data['coordenador_tecnico_id'] = $dadosProjeto[0]['cp.usuario_id'];

                //Preencher dados do beneficiário
                $dadosBeneficiario = $model->buscaBeneficiario($id);

                $data['beneficiario_id'] = $dadosBeneficiario[0]['b.beneficiario_id'];
                $data['beneficiario'] = $dadosBeneficiario[0]['b.nome'];
                $data['cpf_cnpj'] = $dadosBeneficiario[0]['b.cpf_cnpj'];
                $data['rg_ie'] = $dadosBeneficiario[0]['b.rg_ie'];
                $data['pis_inss'] = $dadosBeneficiario[0]['b.nit_pis'];
                $data['endereco_contratado'] = $dadosBeneficiario[0]['b.endereco'];
                $data['telefone_contratado'] = $dadosBeneficiario[0]['b.telefone'];
                $data['email_contratado'] = $dadosBeneficiario[0]['b.email'];
                $data['banco_id'] = $dadosBeneficiario[0]['ba.nome_banco'];
                $data['agencia_banco'] = $dadosBeneficiario[0]['b.agencia_banco'];
                $data['conta_bancaria'] = $dadosBeneficiario[0]['b.conta_bancaria'];


                $form = new Application_Form_Solicitacoes_ContratacaoServicos();
                $form->startform();

                $array1 = explode("|", $data['descricao']);
                $array2 = explode("|", $data['produto']);
                $array3 = explode("|", $data['numero_itens']);
                $array4 = explode("|", $data['cronograma_inicio']);
                $array5 = explode("|", $data['cronograma_termino']);
                $array6 = explode("|", $data['preco_total']);
                $array7 = explode("|", $data['execucao_inicio']);
                $array8 = explode("|", $data['execucao_termino']);
                $array9 = explode("|", $data['qtd_parcelas']);
                $array10 = explode("|", $data['valor_parcelas']);
                $array11 = explode("|", $data['data_pagamento']);

                $data['descricao'] = $array1[0];
                $data['produto'] = $array2[0];
                $data['numero_itens'] = $array3[0];
                $data['cronograma_inicio'] = $array4[0];
                $data['cronograma_termino'] = $array5[0];
                $data['preco_total'] = $array6[0];
                $data['execucao_inicio'] = $array7[0];
                $data['execucao_termino'] = $array8[0];
                $data['qtd_parcelas'] = $array9[0];
                $data['valor_parcelas'] = $array10[0];
                $data['data_pagamento'] = $array11[0];

                $order = 29;

                for ($i=2 ; $i<11 ; $i++)
                {
                    if (array_key_exists($i - 1, $array1) == 1)
                    {
                        $name1 = "descricao_" . $i;
                        $data[$name1] = $array1[$i - 1];

                        $name2 = "produto_" . $i;
                        $data[$name2] = $array2[$i - 1];

                        $name3 = "numero_itens_" . $i;
                        $data[$name3] = $array3[$i - 1];

                        $name4 = "cronograma_inicio_" . $i;
                        $data[$name4] = $array4[$i - 1];

                        $name5 = "cronograma_termino_" . $i;
                        $data[$name5] = $array5[$i - 1];

                        $form->addNewField($name1, $array1[$i - 1], $name2, $array2[$i - 1], $name3, $array3[$i - 1],
                            $name4, $array4[$i - 1], $name5, $array5[$i - 1], $order);

                        $order = $order + 5;

                    }
                }

                $form->setAction('/solicitacoes/detalhes/solicitacao_id/' . $id);
                $form->populate(array("solicitacoes" => $data));
            }
        }

        $this->view->form = $form;


    }

    public function adicionarpassagensAction(){
        $request = $this->getRequest();
        $form = new Application_Form_Solicitacoes_PassagensDiarias();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        if($this->getRequest()->isPost()){
            if($form->isValid($request->getPost())){

                $data = $form->getValues();

                unset($data['solicitacoes']['projeto']);
                $data['solicitacoes']['coordenador_projeto'] = $data['solicitacoes']['coordenador_tecnico_id'];
                unset($data['solicitacoes']['coordenador_tecnico_id']);

                if($id){
                    $model->update($data, $id);
                }else{
                    $model->insertPassagens($data);
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

            $dadosProjeto = $model->buscaProjetoNome($id);

            $data['coordenador_projeto_id'] = $data['coordenador_projeto'];
            $data['email'] = $dadosProjeto[0]['cp.email'];
            $data['telefone_coordenador'] = $dadosProjeto[0]['cp.telefone'];
            $data['fax_coordenador'] = $dadosProjeto[0]['cp.celular'];
            $data['projeto'] = $dadosProjeto[0]['p.nome'];
            $data['coordenador_projeto'] = $dadosProjeto[0]['cp.username'];
            $data['projeto'] = $dadosProjeto[0]['p.nome'];
            $data['coordenador_tecnico_id'] = $dadosProjeto[0]['cp_usuario_id'];


            $detalhes = new Application_Form_Solicitacoes_AquisicaoBens();
            $detalhes->startform();

            $array1 = explode("|", $data['numero_itens']);
            $array2 = explode("|", $data['descricao']);
            $array3 = explode("|", $data['preco_unidade']);
            $array4 = explode("|", $data['valor_estimado']);

            $data['numero_itens'] = $array1[0];
            $data['descricao'] = $array2[0];
            $data['preco_unidade'] = $array3[0];
            $data['valor_estimado'] = $array4[0];

            $order = 18;

            for ($i=2 ; $i<11 ; $i++)
            {
                if (array_key_exists($i - 1, $array1) == 1)
                {
                    $name1 = "numero_itens_" . $i;
                    $data[$name1] = $array1[$i - 1];

                    $name2 = "descricao_" . $i;
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

            //Preencher dados de projeto e coordenador
            $dadosProjeto = $model->buscaProjetoNome($id);

            $data['coordenador_projeto_id'] = $data['coordenador_projeto'];
            $data['email'] = $dadosProjeto[0]['cp.email'];
            $data['telefone_coordenador'] = $dadosProjeto[0]['cp.telefone'];
            $data['fax_coordenador'] = $dadosProjeto[0]['cp.celular'];
            $data['projeto'] = $dadosProjeto[0]['p.nome'];
            $data['coordenador_projeto'] = $dadosProjeto[0]['cp.username'];
            $data['projeto'] = $dadosProjeto[0]['p.nome'];
            $data['coordenador_tecnico_id'] = $dadosProjeto[0]['cp.usuario_id'];

            //Preencher dados do beneficiário
            $dadosBeneficiario = $model->buscaBeneficiario($id);

            $data['beneficiario_id'] = $dadosBeneficiario[0]['b.beneficiario_id'];
            $data['beneficiario'] = $dadosBeneficiario[0]['b.nome'];
            $data['cpf_cnpj'] = $dadosBeneficiario[0]['b.cpf_cnpj'];
            $data['rg_ie'] = $dadosBeneficiario[0]['b.rg_ie'];
            $data['pis_inss'] = $dadosBeneficiario[0]['b.nit_pis'];
            $data['endereco_contratado'] = $dadosBeneficiario[0]['b.endereco'];
            $data['telefone_contratado'] = $dadosBeneficiario[0]['b.telefone'];
            $data['email_contratado'] = $dadosBeneficiario[0]['b.email'];
            $data['banco_id'] = $dadosBeneficiario[0]['ba.nome_banco'];
            $data['agencia_banco'] = $dadosBeneficiario[0]['b.agencia_banco'];
            $data['conta_bancaria'] = $dadosBeneficiario[0]['b.conta_bancaria'];


            $detalhes = new Application_Form_Solicitacoes_ContratacaoServicos();
            $detalhes->startform();

            $array1 = explode("|", $data['descricao']);
            $array2 = explode("|", $data['produto']);
            $array3 = explode("|", $data['numero_itens']);
            $array4 = explode("|", $data['cronograma_inicio']);
            $array5 = explode("|", $data['cronograma_termino']);
            $array6 = explode("|", $data['preco_total']);
            $array7 = explode("|", $data['execucao_inicio']);
            $array8 = explode("|", $data['execucao_termino']);
            $array9 = explode("|", $data['qtd_parcelas']);
            $array10 = explode("|", $data['valor_parcelas']);
            $array11 = explode("|", $data['data_pagamento']);

            $data['descricao'] = $array1[0];
            $data['produto'] = $array2[0];
            $data['numero_itens'] = $array3[0];
            $data['cronograma_inicio'] = $array4[0];
            $data['cronograma_termino'] = $array5[0];
            $data['preco_total'] = $array6[0];
            $data['execucao_inicio'] = $array7[0];
            $data['execucao_termino'] = $array8[0];
            $data['qtd_parcelas'] = $array9[0];
            $data['valor_parcelas'] = $array10[0];
            $data['data_pagamento'] = $array11[0];

            $order = 29;

            for ($i=2 ; $i<11 ; $i++)
            {
                if (array_key_exists($i - 1, $array1) == 1)
                {
                    $name1 = "descricao_" . $i;
                    $data[$name1] = $array1[$i - 1];

                    $name2 = "produto_" . $i;
                    $data[$name2] = $array2[$i - 1];

                    $name3 = "numero_itens_" . $i;
                    $data[$name3] = $array3[$i - 1];

                    $name4 = "cronograma_inicio_" . $i;
                    $data[$name4] = $array4[$i - 1];

                    $name5 = "cronograma_termino_" . $i;
                    $data[$name5] = $array5[$i - 1];

                    $detalhes->addNewField($name1, $array1[$i - 1], $name2, $array2[$i - 1], $name3, $array3[$i - 1],
                        $name4, $array4[$i - 1], $name5, $array5[$i - 1], $order);

                    $order = $order + 5;

                }
            }

            $order = 110;

            for ($i=2 ; $i<11 ; $i++)
            {
                if (array_key_exists($i - 1, $array6) == 1)
                {
                    $name6 = "preco_total_" . $i;
                    $data[$name6] = $array6[$i - 1];

                    $name7 = "execucao_inicio_" . $i;
                    $data[$name7] = $array7[$i - 1];

                    $name8 = "execucao_termino_" . $i;
                    $data[$name8] = $array8[$i - 1];

                    $name9 = "qtd_parcelas_" . $i;
                    $data[$name9] = $array9[$i - 1];

                    $name10 = "valor_parcelas_" . $i;
                    $data[$name10] = $array10[$i - 1];

                    $name11 = "data_pagamento_" . $i;
                    $data[$name11] = $array11[$i - 1];

                    $detalhes->addNewField2($name6, $array6[$i - 1], $name7, $array7[$i - 1], $name8, $array8[$i - 1],
                        $name9, $array9[$i - 1], $name10, $array10[$i - 1], $name11, $array11[$i - 1], $order);

                    $order = $order + 6;

                }
            }


        }else
        {
            $detalhes = new Application_Form_Solicitacoes_PassagensDiarias();
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
            $select = $dbAdapter->select()->from('projeto',array('projeto_id','nome','apelido', 'coordenador_tecnico'))->where($where,$searchTerm)
                ->order(array("$sidx $sord"))->limit($limit,$start);
        }
        else{
            $select = $dbAdapter->select()->from('projeto',array('projeto_id','nome','apelido', 'coordenador_tecnico'))->where($where,$searchTerm)
                ->order(array("$sidx $sord"));
        }

        try{
            $rows = $dbAdapter->fetchAll($select);

            $response = (object) array();
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
            $sidx = 'beneficiario_id';
            $sord = 'ASC';
        }
        if ($searchTerm=="") {
            $searchTerm="%";
        } else {
            $searchTerm = "%" . $searchTerm . "%";
        }

        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $where = 'nome like ? or cpf_cnpj like ?';

        $select = $dbAdapter->select()->from('beneficiario',array('count(*) as count'))->where($where,$searchTerm)
        ->where('tipo_beneficiario_id = ?', 1);


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
                ->where('tipo_beneficiario_id = ?', 1)
                ->order(array("$sidx $sord"))->limit($limit,$start);
        }
        else{
            $select = $dbAdapter->select()->from('beneficiario',array('beneficiario_id','nome','cpf_cnpj'))->where($where,$searchTerm)
                ->where('tipo_beneficiario_id = ?', 1)
                ->order(array("$sidx $sord"));
        }

        try{
            $rows = $dbAdapter->fetchAll($select);

            $response = (object) array();
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

