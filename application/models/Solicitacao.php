<?php

class Application_Model_Solicitacao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Solicitacao;
        $solicitacao = $table->find($id)->current();
        return $solicitacao;
    }

    public function findAquisicao($id){

        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('b' => 'bens_servicos'))
                ->where('b.deletado = false and b.solicitacao_id = ' . $id);

            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }


    }

    public function findContratacao($id){

        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('s' => 'servicos'))
                ->where('s.deletado = false and s.solicitacao_id = ' . $id);

            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }

    }

    public function findPassagens($id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('d' => 'diarias_passagens'))
                ->where('d.solicitacao_id = ?', $id)
                ->joinLeft(array('td' => 'tipo_diarias_passagens'), 'd.tipo_diarias_passagens_id = td.tipo_diarias_passagens_id',
                array('td.nome_tipo' => 'td.nome_tipo'));

            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }


    public function selectAll()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('s' => 'solicitacao'))
                ->where('s.deletado = ?', false)
                ->joinLeft(array('p' => 'projeto'), 's.projeto_id = p.projeto_id',array('p.nome'=>'p.nome'))
                ->joinLeft(array('cp' => 'usuario'), 's.coordenador_projeto = cp.usuario_id',array('cp.usuario_id'=>'cp.usuario_id',
                'cp.nome'=>'cp.nome', 'cp.username' => 'cp.username'))
                ->joinLeft(array('ts' => 'tipo_solicitacao'), 's.tipo_solicitacao_id = ts.tipo_solicitacao_id',array('ts.nome_tipo'=>'ts.nome_tipo'))
                ->joinLeft(array('b' => 'beneficiario'), 's.beneficiario_id = b.beneficiario_id',array('b.nome'=>'b.nome'));;
            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectAllAquisicao()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('s' => 'solicitacao'))
                ->where('s.deletado = ?', false)
                ->where('s.tipo_solicitacao_id = ?', 1)
                ->orWhere('s.tipo_solicitacao_id = ?', 4)
                ->orWhere('s.tipo_solicitacao_id = ?', 5)
                ->orWhere('s.tipo_solicitacao_id = ?', 6)
                ->joinLeft(array('p' => 'projeto'), 's.projeto_id = p.projeto_id',array('p.nome'=>'p.nome'))
                ->joinLeft(array('cp' => 'usuario'), 's.coordenador_projeto = cp.usuario_id',array('cp.usuario_id'=>'cp.usuario_id',
                'cp.nome'=>'cp.nome', 'cp.username' => 'cp.username'))
                ->joinLeft(array('ts' => 'tipo_solicitacao'), 's.tipo_solicitacao_id = ts.tipo_solicitacao_id',array('ts.nome_tipo'=>'ts.nome_tipo'))
                ->joinLeft(array('b' => 'beneficiario'), 's.beneficiario_id = b.beneficiario_id',array('b.nome'=>'b.nome'));;
            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectAllContratacao()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('s' => 'solicitacao'))
                ->where('s.deletado = ?', false)
                ->where('s.tipo_solicitacao_id = ?', 2)
                ->orWhere('s.tipo_solicitacao_id = ?', 7)
                ->orWhere('s.tipo_solicitacao_id = ?', 8)
                ->joinLeft(array('p' => 'projeto'), 's.projeto_id = p.projeto_id',array('p.nome'=>'p.nome'))
                ->joinLeft(array('cp' => 'usuario'), 's.coordenador_projeto = cp.usuario_id',array('cp.usuario_id'=>'cp.usuario_id',
                'cp.nome'=>'cp.nome', 'cp.username' => 'cp.username'))
                ->joinLeft(array('ts' => 'tipo_solicitacao'), 's.tipo_solicitacao_id = ts.tipo_solicitacao_id',array('ts.nome_tipo'=>'ts.nome_tipo'))
                ->joinLeft(array('b' => 'beneficiario'), 's.beneficiario_id = b.beneficiario_id',array('b.nome'=>'b.nome'));;
            $stmt = $select->query();
            $result = $stmt->fetchAll();


            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function selectAllPassagens()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('s' => 'solicitacao'))
                ->where('s.deletado = ?', false)
                ->where('s.tipo_solicitacao_id = ?', 3)
                ->joinLeft(array('p' => 'projeto'), 's.projeto_id = p.projeto_id',array('p.nome'=>'p.nome'))
                ->joinLeft(array('cp' => 'usuario'), 's.coordenador_projeto = cp.usuario_id',array('cp.usuario_id'=>'cp.usuario_id',
                'cp.nome'=>'cp.nome', 'cp.username' => 'cp.username'))
                ->joinLeft(array('ts' => 'tipo_solicitacao'), 's.tipo_solicitacao_id = ts.tipo_solicitacao_id',array('ts.nome_tipo'=>'ts.nome_tipo'))
                ->joinLeft(array('b' => 'beneficiario'), 's.beneficiario_id = b.beneficiario_id',array('b.nome'=>'b.nome'));;
            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Projeto();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['solicitacao_id']] = $item['solicitacao_nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insertAquisicao($data, $quantidade, $nome, $valor_unitario)
    {
        $table_solicitacao = new Application_Model_DbTable_Solicitacao();
        $table_bensServicos = new Application_Model_DbTable_BensServicos();

        $data['bens_servicos']['quantidade'] = $data['solicitacoes']['quantidade'] . $quantidade;
        $data['bens_servicos']['nome'] = $data['solicitacoes']['nome'] . $nome;
        $data['bens_servicos']['valor_unitario'] = $data['solicitacoes']['valor_unitario'] . $valor_unitario;

        unset($data['solicitacoes']['quantidade']);
        unset($data['solicitacoes']['nome']);
        unset($data['solicitacoes']['valor_unitario']);

        $table_solicitacao->insert($data['solicitacoes']);

        $data['bens_servicos']['solicitacao_id'] = $this->getLastInsertedId('solicitacao');
        $table_bensServicos->insert($data['bens_servicos']);
    }


    public function insertContratacao($data, $descricao, $produto, $quantidade, $inicio_atividades,$fim_atividades)
    {
        $table_solicitacao = new Application_Model_DbTable_Solicitacao();
        $table_servicos = new Application_Model_DbTable_Servicos();
        $table_cronograma_atividades = new Application_Model_DbTable_CronogramaAtividades();

        $data['cronograma_atividades']['descricao'] .= $descricao;
        $data['cronograma_atividades']['produto'] .= $produto;
        $data['cronograma_atividades']['quantidade'] .= $quantidade;
        $data['cronograma_atividades']['inicio_atividades'] .= $inicio_atividades;
        $data['cronograma_atividades']['fim_atividades'] .= $fim_atividades;

        $data['servicos']['valor_real'] = $data['solicitacoes']['valor_real'];
        $data['servicos']['inicio_execucao'] = $data['solicitacoes']['inicio_execucao'];
        $data['servicos']['fim_execucao'] = $data['solicitacoes']['fim_execucao'];
        $data['servicos']['quantidade_parcelas'] = $data['solicitacoes']['quantidade_parcelas'];
        $data['servicos']['valor_parcelas'] = $data['solicitacoes']['valor_parcelas'];
        $data['servicos']['data_pagamento'] = $data['solicitacoes']['data_pagamento'];

        unset($data['solicitacoes']['descricao']);
        unset($data['solicitacoes']['produto']);
        unset($data['solicitacoes']['quantidade']);
        unset($data['solicitacoes']['inicio_atividades']);
        unset($data['solicitacoes']['fim_atividades']);
        unset($data['solicitacoes']['valor_real']);
        unset($data['solicitacoes']['inicio_execucao']);
        unset($data['solicitacoes']['fim_execucao']);
        unset($data['solicitacoes']['quantidade_parcelas']);
        unset($data['solicitacoes']['valor_parcelas']);
        unset($data['solicitacoes']['data_pagamento']);

        $table_solicitacao->insert($data['solicitacoes']);

        $data['servicos']['solicitacao_id'] = $this->getLastInsertedId('solicitacao');
        $table_servicos->insert($data['servicos']);

        $data['cronograma_atividades']['servicos_id'] = $this->getLastInsertedId('servicos');
        $table_cronograma_atividades->insert($data['cronograma_atividades']);
    }

    public function insertPassagens($data)
    {
        $table_solicitacao = new Application_Model_DbTable_Solicitacao();
        $table_diarias_passagens = new Application_Model_DbTable_DiariasPassagens();
        $table_viagem_detalhe = new Application_Model_DbTable_ViagemDetalhe();

        $data['solicitacoes']['tipo_solicitacao_id'] = 3;
        $data['solicitacoes']['coordenador_projeto'] = $data['solicitacoes']['coordenador_tecnico_id'];

        $data['diarias_passagens']['motivos'] = $data['solicitacoes']['motivos'];
        $data['diarias_passagens']['tipo_diarias_passagens_id'] = $data['solicitacoes']['tipo_diarias_passagens_id'];
        $data['diarias_passagens']['data_saida'] = $data['solicitacoes']['data_saida'];
        $data['diarias_passagens']['data_volta'] = $data['solicitacoes']['data_volta'];
        $data['diarias_passagens']['codigo_reservacao'] = $data['solicitacoes']['codigo_reservacao'];
        $data['diarias_passagens']['valor_passagens'] = $data['solicitacoes']['valor_passagens'];
        $data['diarias_passagens']['valor_voo'] = $data['solicitacoes']['valor_voo'];
        $data['diarias_passagens']['numero_dias'] = $data['solicitacoes']['numero_dias'];
        $data['diarias_passagens']['pais_origem_id'] = $data['solicitacoes']['pais_origem_id'];
        $data['diarias_passagens']['pais_destino_id'] = $data['solicitacoes']['pais_destino_id'];

        $data['viagem_detalhe']['hora_saida'] = $data['solicitacoes']['hora_saida'];
        $data['viagem_detalhe']['hora_chegada'] = $data['solicitacoes']['hora_chegada'];
        $data['viagem_detalhe']['cidade_origem'] = $data['solicitacoes']['cidade_origem'];
        $data['viagem_detalhe']['cidade_destino'] = $data['solicitacoes']['cidade_destino'];
        $data['viagem_detalhe']['tipo_detalhe'] = $data['solicitacoes']['tipo_detalhe'];
        $data['viagem_detalhe']['numero_voo'] = $data['solicitacoes']['numero_voo'];
        $data['viagem_detalhe']['data'] = $data['solicitacoes']['data'];

        unset($data['solicitacoes']['coordenador_tecnico_id']);
        unset($data['solicitacoes']['beneficiario']);
        unset($data['solicitacoes']['projeto']);
        unset($data['solicitacoes']['motivos']);
        unset($data['solicitacoes']['tipo_diarias_passagens_id']);
        unset($data['solicitacoes']['data_saida']);
        unset($data['solicitacoes']['data_volta']);
        unset($data['solicitacoes']['hora_saida']);
        unset($data['solicitacoes']['hora_chegada']);
        unset($data['solicitacoes']['pais_origem_id']);
        unset($data['solicitacoes']['pais_destino_id']);
        unset($data['solicitacoes']['cidade_origem']);
        unset($data['solicitacoes']['cidade_destino']);
        unset($data['solicitacoes']['tipo_detalhe']);
        unset($data['solicitacoes']['numero_voo']);
        unset($data['solicitacoes']['codigo_reservacao']);
        unset($data['solicitacoes']['valor_passagens']);
        unset($data['solicitacoes']['valor_voo']);
        unset($data['solicitacoes']['numero_dias']);
        unset($data['solicitacoes']['data']);

        $table_solicitacao->insert($data['solicitacoes']);

        $data['diarias_passagens']['solicitacao_id'] = $this->getLastInsertedId('solicitacao');
        $table_diarias_passagens->insert($data['diarias_passagens']);

        $data['viagem_detalhe']['diarias_passagens_id'] = $this->getLastInsertedId('diarias_passagens');
        $table_viagem_detalhe->insert($data['viagem_detalhe']);

    }

    public function updateaquisicao($data, $id, $quantidade, $nome, $valor_unitario)
    {
        $table_solicitacao = new Application_Model_DbTable_Solicitacao();
        $table_bensServicos = new Application_Model_DbTable_BensServicos();

        $data['bens_servicos']['quantidade'] = $data['solicitacoes']['quantidade'] . $quantidade;
        $data['bens_servicos']['nome'] = $data['solicitacoes']['nome'] . $nome;
        $data['bens_servicos']['valor_unitario'] = $data['solicitacoes']['valor_unitario'] . $valor_unitario;

        unset($data['solicitacoes']['quantidade']);
        unset($data['solicitacoes']['nome']);
        unset($data['solicitacoes']['valor_unitario']);

        $where_solicitacao = $table_solicitacao->getAdapter()->quoteInto('solicitacao_id = ?',$id);
        $where_bensServicos = $table_bensServicos->getAdapter()->quoteInto('solicitacao_id = ?',$id);

        $table_solicitacao->update($data['solicitacoes'], $where_solicitacao);
        $table_bensServicos->update($data['bens_servicos'], $where_bensServicos);
    }


    public function updateContratacao($data, $id, $descricao, $produto, $quantidade, $inicio_atividades, $fim_atividades)
    {
        $table_solicitacao = new Application_Model_DbTable_Solicitacao;
        $table_servicos = new Application_Model_DbTable_Servicos();
        $table_cronograma_atividades = new Application_Model_DbTable_CronogramaAtividades();

        $data['cronograma_atividades']['descricao'] .= $descricao;
        $data['cronograma_atividades']['produto'] .= $produto;
        $data['cronograma_atividades']['quantidade'] .= $quantidade;
        $data['cronograma_atividades']['inicio_atividades'] .= $inicio_atividades;
        $data['cronograma_atividades']['fim_atividades'] .= $fim_atividades;

        $data['servicos']['valor_real'] = $data['solicitacoes']['valor_real'];
        $data['servicos']['inicio_execucao'] = $data['solicitacoes']['inicio_execucao'];
        $data['servicos']['fim_execucao'] = $data['solicitacoes']['fim_execucao'];
        $data['servicos']['quantidade_parcelas'] = $data['solicitacoes']['quantidade_parcelas'];
        $data['servicos']['valor_parcelas'] = $data['solicitacoes']['valor_parcelas'];
        $data['servicos']['data_pagamento'] = $data['solicitacoes']['data_pagamento'];

        unset($data['solicitacoes']['descricao']);
        unset($data['solicitacoes']['produto']);
        unset($data['solicitacoes']['quantidade']);
        unset($data['solicitacoes']['inicio_atividades']);
        unset($data['solicitacoes']['fim_atividades']);
        unset($data['solicitacoes']['valor_real']);
        unset($data['solicitacoes']['inicio_execucao']);
        unset($data['solicitacoes']['fim_execucao']);
        unset($data['solicitacoes']['quantidade_parcelas']);
        unset($data['solicitacoes']['valor_parcelas']);
        unset($data['solicitacoes']['data_pagamento']);

        $where_solicitacao = $table_solicitacao->getAdapter()->quoteInto('solicitacao_id = ?',$id);
        $where_servicos = $table_servicos->getAdapter()->quoteInto('solicitacao_id = ?',$id);

        $sid = $this->getServicosId($id);
        $where_cronograma_atividades = $table_cronograma_atividades->getAdapter()->quoteInto('servicos_id = ?',$sid);

        $table_solicitacao->update($data['solicitacoes'],$where_solicitacao);
        $table_servicos->update($data['servicos'],$where_servicos);
        $table_cronograma_atividades->update($data['cronograma_atividades'],$where_cronograma_atividades);

    }

    public function updatePassagens($data, $id)
    {

        $table_solicitacao = new Application_Model_DbTable_Solicitacao();
        $table_diarias_passagens = new Application_Model_DbTable_DiariasPassagens();
        $table_viagem_detalhe = new Application_Model_DbTable_ViagemDetalhe();

        $data['solicitacoes']['tipo_solicitacao_id'] = 3;
        $data['solicitacoes']['coordenador_projeto'] = $data['solicitacoes']['coordenador_tecnico_id'];

        $data['diarias_passagens']['motivos'] = $data['solicitacoes']['motivos'];
        $data['diarias_passagens']['tipo_diarias_passagens_id'] = $data['solicitacoes']['tipo_diarias_passagens_id'];
        $data['diarias_passagens']['data_saida'] = $data['solicitacoes']['data_saida'];
        $data['diarias_passagens']['data_volta'] = $data['solicitacoes']['data_volta'];
        $data['diarias_passagens']['codigo_reservacao'] = $data['solicitacoes']['codigo_reservacao'];
        $data['diarias_passagens']['valor_passagens'] = $data['solicitacoes']['valor_passagens'];
        $data['diarias_passagens']['valor_voo'] = $data['solicitacoes']['valor_voo'];
        $data['diarias_passagens']['numero_dias'] = $data['solicitacoes']['numero_dias'];
        $data['diarias_passagens']['pais_origem_id'] = $data['solicitacoes']['pais_origem_id'];
        $data['diarias_passagens']['pais_destino_id'] = $data['solicitacoes']['pais_destino_id'];

        $data['viagem_detalhe']['hora_saida'] = $data['solicitacoes']['hora_saida'];
        $data['viagem_detalhe']['hora_chegada'] = $data['solicitacoes']['hora_chegada'];
        $data['viagem_detalhe']['cidade_origem'] = $data['solicitacoes']['cidade_origem'];
        $data['viagem_detalhe']['cidade_destino'] = $data['solicitacoes']['cidade_destino'];
        $data['viagem_detalhe']['tipo_detalhe'] = $data['solicitacoes']['tipo_detalhe'];
        $data['viagem_detalhe']['numero_voo'] = $data['solicitacoes']['numero_voo'];
        $data['viagem_detalhe']['data'] = $data['solicitacoes']['data'];

        unset($data['solicitacoes']['coordenador_tecnico_id']);
        unset($data['solicitacoes']['beneficiario']);
        unset($data['solicitacoes']['projeto']);
        unset($data['solicitacoes']['motivos']);
        unset($data['solicitacoes']['tipo_diarias_passagens_id']);
        unset($data['solicitacoes']['data_saida']);
        unset($data['solicitacoes']['data_volta']);
        unset($data['solicitacoes']['hora_saida']);
        unset($data['solicitacoes']['hora_chegada']);
        unset($data['solicitacoes']['pais_origem_id']);
        unset($data['solicitacoes']['pais_destino_id']);
        unset($data['solicitacoes']['cidade_origem']);
        unset($data['solicitacoes']['cidade_destino']);
        unset($data['solicitacoes']['tipo_detalhe']);
        unset($data['solicitacoes']['numero_voo']);
        unset($data['solicitacoes']['codigo_reservacao']);
        unset($data['solicitacoes']['valor_passagens']);
        unset($data['solicitacoes']['valor_voo']);
        unset($data['solicitacoes']['numero_dias']);
        unset($data['solicitacoes']['data']);

        $where_solicitacao = $table_solicitacao->getAdapter()->quoteInto('solicitacao_id = ?',$id);
        $where_diarias_passagens = $table_diarias_passagens->getAdapter()->quoteInto('solicitacao_id = ?',$id);

        $vid = $this->getDiariasPassagensId($id);
        $where_viagem_detalhe = $table_viagem_detalhe->getDefaultAdapter()->quoteInto('diarias_passagens = ?', $vid);

        $table_solicitacao->update($data['solicitacoes'],$where_solicitacao);
        $table_diarias_passagens->update($data['diarias_passagens'],$where_diarias_passagens);
        $table_viagem_detalhe->update($data['viagem_detalhe'], $where_viagem_detalhe);
    }

    public function deleteAquisicao($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table_solicitacao = "solicitacao";
        $table_bensServicos = 'bens_servicos';
        $deletado = true;
        $where = $db->quoteInto('solicitacao_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table_solicitacao, $data, $where);
        $db->update($table_bensServicos, $data, $where);

    }

    public function deleteContratacao($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table_solicitacao = "solicitacao";
        $table_servicos = 'servicos';
        $table_cronograma_atividades = 'cronograma_atividades';
        $deletado = true;

        $where = $db->quoteInto('solicitacao_id = ?', $id);
        $sid = $this->getServicosId($id);
        $where_cronograma_atividades = $db->quoteInto('servicos_id = ?', $sid);

        $data = array('deletado' => $deletado);

        $db->update($table_solicitacao, $data, $where);
        $db->update($table_servicos, $data, $where);
        $db->update($table_cronograma_atividades, $data, $where_cronograma_atividades);

    }

    public function deletePassagens($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table_solicitacao = "solicitacao";
        $table_diarias_passagens = 'diarias_passagens';
        $table_viagem_detalhe = 'viagem_detalhe';
        $deletado = true;

        $where = $db->quoteInto('solicitacao_id = ?', $id);
        $vid = $this->getDiariasPassagensId($id);
        $where_viagem_detalhe = $db->quoteInto('diarias_passagens_id = ?', $vid);

        $data = array('deletado' => $deletado);

        $db->update($table_solicitacao, $data, $where);
        $db->update($table_diarias_passagens, $data, $where);
        $db->update($table_viagem_detalhe, $data, $where_viagem_detalhe);

    }

    public function concatenaCampos($campo, $data)
    {
        $result = "";
        for ($index=2 ; $index<11 ; $index++)
        {
            if (array_key_exists($campo . $index, $data['solicitacoes']) == 1)
            {
                //Obter os 4 valores dos campos dinamicos em Aquisição de Bens
                $var = $data['solicitacoes'][$campo . $index];

                //Concatena as strings de forma a inserir as informacoes em apenas um campo no banco
                $result = $result . "|" . $var;
            }
        }
        return $result;
    }

    public function buscaProjetoNome($solicitacao_id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('s' => 'solicitacao'))
                ->where('s.solicitacao_id = ?', $solicitacao_id)
                ->joinLeft(array('p' => 'projeto'), 's.projeto_id = p.projeto_id',array('p.nome'=>'p.nome'))
                ->joinLeft(array('cp' => 'usuario'), 's.coordenador_projeto = cp.usuario_id',array('cp.usuario_id'=>'cp.usuario_id',
                'cp.username'=>'cp.username', 'cp.email' => 'cp.email', 'cp.telefone' => 'cp.telefone', 'cp.celular' => 'cp.celular'));
            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function buscaBeneficiario($solicitacao_id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('s' => 'solicitacao'))
                ->where('s.solicitacao_id = ?', $solicitacao_id)
                ->joinLeft(array('b' => 'beneficiario'), 's.beneficiario_id = b.beneficiario_id',array('b.beneficiario_id' => 'b.beneficiario_id',
                'b.nome'=>'b.nome', 'b.cpf_cnpj' => 'b.cpf_cnpj', 'b.rg_ie' => 'b.rg_ie', 'b.nit_pis' => 'b.nit_pis','b.endereco' => 'b.endereco',
                'b.telefone' => 'b.telefone', 'b.email' => 'b.email', 'b.banco_id' => 'b.banco_id', 'b.agencia_banco' => 'b.agencia_banco',
                'b.conta_bancaria' => 'b.conta_bancaria'))
                ->joinLeft(array('ba' => 'banco'), 'b.banco_id = ba.banco_id',array('ba.banco_id'=>'ba.banco_id','ba.nome_banco'=>'ba.nome_banco'));

            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }


    public function getLastInsertedId($table){

        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchOne("SELECT max(" . $table . "_id) FROM " . $table . "");
        return (int)$result;
    }

    public function getDiariasPassagensId($solicitacao_id){

         try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('d' => 'diarias_passagens'), array('d.diarias_passagens_id' => 'd.diarias_passagens_id'))
                ->where('d.solicitacao_id = ?', $solicitacao_id);

            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function getServicosId($solicitacao_id){

        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('s' => 'servicos'), array('s.servicos_id' => 's.servicos_id'))
                ->where('s.solicitacao_id = ?', $solicitacao_id);

            $stmt = $select->query();
            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}