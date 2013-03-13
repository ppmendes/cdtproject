<?php

class Application_Model_Solicitacao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Solicitacao;
        $solicitacao = $table->find($id)->current();
        return $solicitacao;
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
                ->orWhere('s.tipo_solicitacao_id = ?', 6)
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

    public function insertAquisicao($data, $numero_itens, $descricao, $preco_unidade, $valor_estimado)
    {
        $table = new Application_Model_DbTable_Solicitacao();

        $data['solicitacoes']['numero_itens'] = $data['solicitacoes']['numero_itens'] . $numero_itens;
        $data['solicitacoes']['descricao'] = $data['solicitacoes']['descricao'] . $descricao;
        $data['solicitacoes']['preco_unidade'] = $data['solicitacoes']['preco_unidade'] . $preco_unidade;
        $data['solicitacoes']['valor_estimado'] = $data['solicitacoes']['valor_estimado'] . $valor_estimado;


        $table->insert($data['solicitacoes']);
    }

    public function insertContratacao($data, $descricao, $produto, $numero_itens, $cronograma_inicio,$cronograma_termino, $preco_total,
                $execucao_inicio, $execucao_termino, $qtd_parcelas, $valor_parcelas, $data_pagamento)
    {
        $table = new Application_Model_DbTable_Solicitacao();

        $data['solicitacoes']['descricao'] = $data['solicitacoes']['descricao'] . $descricao;
        $data['solicitacoes']['produto'] = $data['solicitacoes']['produto'] . $produto;
        $data['solicitacoes']['numero_itens'] = $data['solicitacoes']['numero_itens'] . $numero_itens;
        $data['solicitacoes']['cronograma_inicio'] = $data['solicitacoes']['cronograma_inicio'] . $cronograma_inicio;
        $data['solicitacoes']['cronograma_termino'] = $data['solicitacoes']['cronograma_termino'] . $cronograma_termino;
        $data['solicitacoes']['preco_total'] = $data['solicitacoes']['preco_total'] . $preco_total;
        $data['solicitacoes']['execucao_inicio'] = $data['solicitacoes']['execucao_inicio'] . $execucao_inicio;
        $data['solicitacoes']['execucao_termino'] = $data['solicitacoes']['execucao_termino'] . $execucao_termino;
        $data['solicitacoes']['qtd_parcelas'] = $data['solicitacoes']['qtd_parcelas'] . $qtd_parcelas;
        $data['solicitacoes']['valor_parcelas'] = $data['solicitacoes']['valor_parcelas'] . $valor_parcelas;
        $data['solicitacoes']['data_pagamento'] = $data['solicitacoes']['data_pagamento'] . $data_pagamento;

        $table->insert($data['solicitacoes']);
    }

    public function insertPassagens($data)
    {
        $table_solicitacao = new Application_Model_DbTable_Solicitacao();
        $table_diarias = new Application_Model_DbTable_DiariasPassagens();

        $data['diarias_passagens']['motivos'] = $data['solicitacoes']['motivos'];
        unset($data['solicitacoes']['motivos']);
        $data['diarias_passagens']['tipo_diarias_passagens_id'] = $data['solicitacoes']['tipo_diarias_passagens'];
        unset($data['solicitacoes']['tipo_diarias_passagens']);
        $data['diarias_passagens']['data_saida'] = $data['solicitacoes']['data_saida'];
        unset($data['solicitacoes']['data_saida']);
        $data['diarias_passagens']['data_volta'] = $data['solicitacoes']['data_volta'];
        unset($data['solicitacoes']['data_volta']);
        $data['diarias_passagens']['hora_saida'] = $data['solicitacoes']['hora_saida'];
        unset($data['solicitacoes']['hora_saida']);
        $data['diarias_passagens']['hora_chegada'] = $data['solicitacoes']['hora_chegada'];
        unset($data['solicitacoes']['hora_chegada']);
        $data['diarias_passagens']['tipo_detalhe'] = $data['solicitacoes']['tipo_detalhe'];
        unset($data['solicitacoes']['tipo_detalhe']);
        $data['diarias_passagens']['valor_passagens'] = $data['solicitacoes']['valor_passagens'];
        unset($data['solicitacoes']['valor_passagens']);
        $data['diarias_passagens']['local'] = $data['solicitacoes']['local'];
        unset($data['solicitacoes']['local']);
        $data['diarias_passagens']['data'] = $data['solicitacoes']['data'];
        unset($data['solicitacoes']['data']);
        $data['diarias_passagens']['valor'] = $data['solicitacoes']['valor'];
        unset($data['solicitacoes']['valor']);

        $data['solicitacoes']['tipo_solicitacao_id'] = 3;

        $data['diarias_passagens']['pais_origem_id'] = 76;
        $data['diarias_passagens']['pais_destino_id'] = 76;
        unset($data['diarias_passagens']['hora_saida']);
        unset($data['diarias_passagens']['hora_chegada']);
        unset($data['diarias_passagens']['tipo_detalhe']);
        unset($data['diarias_passagens']['valor']);
        unset($data['diarias_passagens']['data']);
        unset($data['diarias_passagens']['local']);


//        echo "<pre>";
//        print_r($data['diarias_passagens']);
//        print_r('aaaaaaaaaaaaaa </br></br>');
//        print_r($data['solicitacoes']);
//        exit;
//        echo "</pre>";

        $table_solicitacao->insert($data['solicitacoes']);

        $data['diarias_passagens']['solicitacao_id'] = $this->getLastInsertedId('solicitacao');

        $table_diarias->insert($data['diarias_passagens']);

    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "solicitacao";
        $deletado = true;
        $where = $db->quoteInto('solicitacao_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);

    }

    public function updateaquisicao($data, $id, $numero_itens, $descricao, $preco_unidade, $valor_estimado)
    {
        $table = new Application_Model_DbTable_Solicitacao;

        $data['solicitacoes']['numero_itens'] = $data['solicitacoes']['numero_itens'] . $numero_itens;
        $data['solicitacoes']['descricao'] = $data['solicitacoes']['descricao'] . $descricao;
        $data['solicitacoes']['preco_unidade'] = $data['solicitacoes']['preco_unidade'] . $preco_unidade;
        $data['solicitacoes']['valor_estimado'] = $data['solicitacoes']['valor_estimado'] . $valor_estimado;

        $where = $table->getAdapter()->quoteInto('solicitacao_id = ?',$id);

        $table->update($data['solicitacoes'],$where);
    }

    public function update($data, $id)
    {
        $table = new Application_Model_DbTable_Solicitacao;
        $where = $table->getAdapter()->quoteInto('solicitacao_id = ?',$id);

        $table->update($data['solicitacoes'],$where);
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
}