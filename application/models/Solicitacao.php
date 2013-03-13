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
                ->joinLeft(array('cp' => 'usuario'), 's.coordenador_projeto = cp.usuario_id',array('cp.usuario_id'=>'cp.usuario_id','cp.nome'=>'cp.nome'))
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
                ->joinLeft(array('cp' => 'usuario'), 's.coordenador_projeto = cp.usuario_id',array('cp.usuario_id'=>'cp.usuario_id','cp.nome'=>'cp.nome'))
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
                ->joinLeft(array('cp' => 'usuario'), 's.coordenador_projeto = cp.usuario_id',array('cp.usuario_id'=>'cp.usuario_id','cp.nome'=>'cp.nome'))
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
                ->joinLeft(array('cp' => 'usuario'), 's.coordenador_projeto = cp.usuario_id',array('cp.usuario_id'=>'cp.usuario_id','cp.nome'=>'cp.nome'))
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

    public function insertContratacao($data, $descricao, $produto, $qtde, $cronograma_inicio,$cronograma_termino, $valor_total,
                $execucao_inicio, $execucao_termino, $qtd_parcelas, $valor_parcelas, $data_pagamento)
    {
        $table = new Application_Model_DbTable_Solicitacao();

        $data['solicitacoes']['$descricao'] = $data['solicitacoes']['numero_itens'] . $descricao;
        $data['solicitacoes']['$produto'] = $data['solicitacoes']['descricao'] . $produto;
        $data['solicitacoes']['$qtde'] = $data['solicitacoes']['preco_unidade'] . $qtde;
        $data['solicitacoes']['$cronograma_inicio'] = $data['solicitacoes']['valor_estimado'] . $cronograma_inicio;
        $data['solicitacoes']['$cronograma_termino'] = $data['solicitacoes']['numero_itens'] . $cronograma_termino;
        $data['solicitacoes']['$valor_total'] = $data['solicitacoes']['numero_itens'] . $valor_total;
        $data['solicitacoes']['$execucao_inicio'] = $data['solicitacoes']['numero_itens'] . $execucao_inicio;
        $data['solicitacoes']['$execucao_termino'] = $data['solicitacoes']['numero_itens'] . $execucao_termino;
        $data['solicitacoes']['$qtd_parcelas'] = $data['solicitacoes']['numero_itens'] . $qtd_parcelas;
        $data['solicitacoes']['$valor_parcelas'] = $data['solicitacoes']['numero_itens'] . $valor_parcelas;
        $data['solicitacoes']['$data_pagamento'] = $data['solicitacoes']['numero_itens'] . $data_pagamento;



        $table->insert($data['solicitacoes']);
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
}