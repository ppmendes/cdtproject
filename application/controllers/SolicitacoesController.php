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

                //$data['solicitacoes']['valor_real'] = intval($data['solicitacoes']['valor_estimado']);

//                for ($i=2 ; $i<11 ; $i++)
//                {
//                    if (array_key_exists("quantidade_" . $i, $data['solicitacoes']) == 1)
//                    {
//                        $data['solicitacoes']['valor_real'] += intval($data['solicitacoes']['valor_estimado_' . $i]);
//                    }
//                }

                $quantidade = $model->concatenaCampos("quantidade_", $data);
                $nome = $model->concatenaCampos("nome_", $data);
                $valor_unitario = $model->concatenaCampos("valor_unitario_", $data);
               // $valor_estimado = $model->concatenaCampos("valor_estimado_", $data);


                for ($i=2 ; $i<11 ; $i++)
                {
                    if (array_key_exists("quantidade_" . $i, $data['solicitacoes']) == 1)
                    {
                        unset($data['solicitacoes']['quantidade_' . $i]);
                        unset($data['solicitacoes']['nome_' . $i]);
                        unset($data['solicitacoes']['valor_unitario_' . $i]);
                        unset($data['solicitacoes']['valor_estimado_' . $i]);
                    }
                }


                if($id){

                    $model->updateaquisicao($data, $id, $quantidade, $nome, $valor_unitario);
                }else{
                    $model->insertAquisicao($data, $quantidade, $nome, $valor_unitario);
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



                $data_bens_servicos = $model->findAquisicao($id);


                $array1 = explode("|", $data_bens_servicos[0]['quantidade']);
                $array2 = explode("|", $data_bens_servicos[0]['nome']);
                $array3 = explode("|", $data_bens_servicos[0]['valor_unitario']);

                $data['quantidade'] = $array1[0];
                $data['nome'] = $array2[0];
                $data['valor_unitario'] = $array3[0];

                $order = 18;

                for ($i=2 ; $i<11 ; $i++)
                {
                    if (array_key_exists($i - 1, $array1) == 1)
                    {
                        $name1 = "quantidade_" . $i;
                        $data[$name1] = $array1[$i - 1];

                        $name2 = "nome_" . $i;
                        $data[$name2] = $array2[$i - 1];

                        $name3 = "valor_unitario_" . $i;
                        $data[$name3] = $array3[$i - 1];

                        $name4 = "valor_estimado_" . $i;
                        $data[$name4] = intval(intval($array1[$i - 1]) * intval($array3[$i - 1]));

                        $form->addNewField($name1, $array1[$i - 1], $name2, $array2[$i - 1], $name3, $array3[$i - 1],
                            $name4, $data[$name4], $order, $i);

                        $order = $order + 4;

                    }
                }

                $data['valor_estimado'] = intval(intval($data['quantidade']) * intval($data['valor_unitario']));

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
                $tipo_servicos = $model->concatenaCampos("tipo_servicos_", $data);
                $produto = $model->concatenaCampos("produto_", $data);
                $numero_itens = $model->concatenaCampos("numero_itens_", $data);
                $data_servicos = $model->concatenaCampos("data_servicos_", $data);
                $data_servicos_fim = $model->concatenaCampos("data_servicos_fim_", $data);

                //Conta quantos campos existem no primeiro conjunto de campos que podem ser adicionados pelo botão "mais" no form
                for ($i=2 ; $i<11 ; $i++)
                {
                    //conta quantos são os campos descricao_i, 2<i<11, dentro do array data[solicitacoes] e dá unset
                    //todos estes campos já foram concatenados acima e serão salvos em apenas um campo na tabela do banco
                    if (array_key_exists("tipo_servicos_" . $i, $data['solicitacoes']) == 1)
                    {
                        unset($data['solicitacoes']['tipo_servicos_' . $i]);
                        unset($data['solicitacoes']['produto_' . $i]);
                        unset($data['solicitacoes']['numero_itens_' . $i]);
                        unset($data['solicitacoes']['data_servicos_' . $i]);
                        unset($data['solicitacoes']['data_servicos_fim_' . $i]);
                    }
                }

                if($id){
                    $model->update($data, $id);
                }else{

                    $model->insertContratacao($data, $tipo_servicos, $produto, $numero_itens, $data_servicos,$data_servicos_fim);
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

                $data_servicos = $model->findContratacao($id);

                $array1 = explode("|", $data_servicos[0]['tipo_servicos']);
                $array2 = explode("|", $data_servicos[0]['produto']);
                $array3 = explode("|", $data_servicos[0]['numero_itens']);
                $array4 = explode("|", $data_servicos[0]['data_servicos']);
                $array5 = explode("|", $data_servicos[0]['data_servicos_fim']);

                $data['tipo_servicos'] = $array1[0];
                $data['produto'] = $array2[0];
                $data['numero_itens'] = $array3[0];
                $data['data_servicos'] = $array4[0];
                $data['data_servicos_fim'] = $array5[0];

                $order = 29;

                for ($i=2 ; $i<11 ; $i++)
                {
                    if (array_key_exists($i - 1, $array1) == 1)
                    {
                        $name1 = "tipo_servicos_" . $i;
                        $data[$name1] = $array1[$i - 1];

                        $name2 = "produto_" . $i;
                        $data[$name2] = $array2[$i - 1];

                        $name3 = "numero_itens_" . $i;
                        $data[$name3] = $array3[$i - 1];

                        $name4 = "data_servicos_" . $i;
                        $data[$name4] = $array4[$i - 1];

                        $name5 = "data_servicos_fim_" . $i;
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
            $data['telefone_contratado'] = $dadosBeneficiario[0]['b.telefone'];
            $data['email_contratado'] = $dadosBeneficiario[0]['b.email'];
            $data['banco_id'] = $dadosBeneficiario[0]['ba.nome_banco'];
            $data['agencia_banco'] = $dadosBeneficiario[0]['b.agencia_banco'];
            $data['conta_bancaria'] = $dadosBeneficiario[0]['b.conta_bancaria'];

            $form = new Application_Form_Solicitacoes_PassagensDiarias();

            //Preencher os dados da passagem e diárias
            $dadosPassagens = $model->findPassagens($id);


            $data['motivos'] = $dadosPassagens[0]['motivos'];
            $data['tipo_diarias_passagens'] = $dadosPassagens[0]['td.nome_tipo'];
            $data['data_saida'] = $dadosPassagens[0]['data_saida'];
            $data['data_volta'] = $dadosPassagens[0]['data_volta'];
            $data['hora_saida'] = '';
            $data['hora_chegada'] = '';
            $data['tipo_detalhe'] = '';
            $data['valor_passagens'] = $dadosPassagens[0]['valor_passagens'];
            $data['local'] = '';
            $data['data'] = '';
            $data['valor'] = '';

        }


            if(is_array($data)){
                $form->setAction('/solicitacoes/detalhes/solicitacao_id/' . $id);
                $form->populate(array("solicitacoes" => $data));
            }

        $this->view->form = $form;


    }

    public function detalhesAction(){
        $request = $this->getRequest();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');
        $this->view->id = $id;


        $data = $model->find($id)->toArray();

        $this->view->tipo = intval($data['tipo_solicitacao_id']);

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
            $data['coordenador_tecnico_id'] = $dadosProjeto[0]['cp.usuario_id'];


            $detalhes = new Application_Form_Solicitacoes_AquisicaoBens();
            $detalhes->startform();

            $data_bens_servicos = $model->findAquisicao($id);


            $array1 = explode("|", $data_bens_servicos[0]['quantidade']);
            $array2 = explode("|", $data_bens_servicos[0]['nome']);
            $array3 = explode("|", $data_bens_servicos[0]['valor_unitario']);

            $data['quantidade'] = $array1[0];
            $data['nome'] = $array2[0];
            $data['valor_unitario'] = $array3[0];

            $order = 18;

            for ($i=2 ; $i<11 ; $i++)
            {
                if (array_key_exists($i - 1, $array1) == 1)
                {
                    $name1 = "quantidade_" . $i;
                    $data[$name1] = $array1[$i - 1];

                    $name2 = "nome_" . $i;
                    $data[$name2] = $array2[$i - 1];

                    $name3 = "valor_unitario_" . $i;
                    $data[$name3] = $array3[$i - 1];

                    $name4 = "valor_estimado_" . $i;
                    $data[$name4] = intval(intval($array1[$i - 1]) * intval($array3[$i - 1]));

                    $detalhes->addNewField($name1, $array1[$i - 1], $name2, $array2[$i - 1], $name3, $array3[$i - 1],
                        $name4, $data[$name4], $order, $i);

                    $order = $order + 4;

                }
            }

            $data['valor_estimado'] = intval(intval($data['quantidade']) * intval($data['valor_unitario']));


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

            $data_servicos = $model->findContratacao($id);

            $array1 = explode("|", $data_servicos[0]['tipo_servicos']);
            $array2 = explode("|", $data_servicos[0]['produto']);
            $array3 = explode("|", $data_servicos[0]['numero_itens']);
            $array4 = explode("|", $data_servicos[0]['data_servicos']);
            $array5 = explode("|", $data_servicos[0]['data_servicos_fim']);

            $data['tipo_servicos'] = $array1[0];
            $data['produto'] = $array2[0];
            $data['numero_itens'] = $array3[0];
            $data['data_servicos'] = $array4[0];
            $data['data_servicos_fim'] = $array5[0];

            $order = 29;

            for ($i=2 ; $i<11 ; $i++)
            {
                if (array_key_exists($i - 1, $array1) == 1)
                {
                    $name1 = "tipo_servicos_" . $i;
                    $data[$name1] = $array1[$i - 1];

                    $name2 = "produto_" . $i;
                    $data[$name2] = $array2[$i - 1];

                    $name3 = "numero_itens_" . $i;
                    $data[$name3] = $array3[$i - 1];

                    $name4 = "data_servicos_" . $i;
                    $data[$name4] = $array4[$i - 1];

                    $name5 = "data_servicos_fim_" . $i;
                    $data[$name5] = $array5[$i - 1];

                    $detalhes->addNewField($name1, $array1[$i - 1], $name2, $array2[$i - 1], $name3, $array3[$i - 1],
                        $name4, $array4[$i - 1], $name5, $array5[$i - 1], $order);

                    $order = $order + 5;

                }
            }
        }else
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
            $data['telefone_contratado'] = $dadosBeneficiario[0]['b.telefone'];
            $data['email_contratado'] = $dadosBeneficiario[0]['b.email'];
            $data['banco_id'] = $dadosBeneficiario[0]['ba.nome_banco'];
            $data['agencia_banco'] = $dadosBeneficiario[0]['b.agencia_banco'];
            $data['conta_bancaria'] = $dadosBeneficiario[0]['b.conta_bancaria'];

            $detalhes = new Application_Form_Solicitacoes_PassagensDiarias();

            //Preencher os dados da passagem e diárias
            $dadosPassagens = $model->findPassagens($id);


            $data['motivos'] = $dadosPassagens[0]['motivos'];
            $data['tipo_diarias_passagens'] = $dadosPassagens[0]['td.nome_tipo'];
            $data['data_saida'] = $dadosPassagens[0]['data_saida'];
            $data['data_volta'] = $dadosPassagens[0]['data_volta'];
            $data['hora_saida'] = '';
            $data['hora_chegada'] = '';
            $data['tipo_detalhe'] = '';
            $data['valor_passagens'] = $dadosPassagens[0]['valor_passagens'];
            $data['local'] = '';
            $data['data'] = '';
            $data['valor'] = '';

        }

        if(is_array($data)){
            $detalhes->setAction('/solicitacoes/detalhes/solicitacao_id/' . $id);
            $detalhes->populate(array("solicitacoes" => $data));
        }

        $this->view->detalhes = $detalhes;


    }


    public function excluiraquisicaoAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Solicitacoes_AquisicaoBens();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        $model->deleteAquisicao($id);
        $this->_redirect('/solicitacoes/');

        $this->view->excluir = $excluir;

    }

    public function excluircontratacaoAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Solicitacoes_ContratacaoServicos();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        $model->deleteContratacao($id);
        $this->_redirect('/solicitacoes/');

        $this->view->excluir = $excluir;

    }

    public function excluirpassagensAction(){
        //$request = $this->getRequest();
        $excluir = new Application_Form_Solicitacoes_PassagensDiarias();
        $model = new Application_Model_Solicitacao();
        $id = $this->_getParam('solicitacao_id');

        $model->deletePassagens($id);
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

