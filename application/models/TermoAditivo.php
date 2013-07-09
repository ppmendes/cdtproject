<?php

class Application_Model_TermoAditivo
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_TermoAditivo();
		$termoAditivo = $table->find($id)->current();
		return $termoAditivo;
	}

    public function insertAlterar($data)
    {
        $table_termo_aditivo = new Application_Model_DbTable_TermoAditivo;
        $table_orcamentos = new Application_Model_DbTable_Orcamento;

        $orcamento = $data['termo_aditivo']['orcamento_destino'];
        $orcamentodata = $table_orcamentos->find($orcamento)->current();

        $rubrica_id = $orcamentodata['rubrica_id'];

        $str = $data['termo_aditivo']['valor_termino_aditivo'];
        $var = str_replace(".", "", $str);
        $var2 = str_replace(",", ".",$var);
        $data['termo_aditivo']['valor_termino_aditivo'] = $var2;
        $data['termo_aditivo']['data_termo_aditivo'] = date('Y-m-d H:i:s', time());

        //Pegar o ID da rubrica para checar se é do tipo .36 e deve alterar também uma .47 correspondente
        $arrayCodigoRubrica = $this->getCodigoRubrica($rubrica_id);
        $codigoRubrica = $arrayCodigoRubrica[0]['r.codigo_rubrica'];
        $rubrica = explode(".", $codigoRubrica);
        $valor_imposto = 0.2 * $data['termo_aditivo']['valor_termino_aditivo'];

        $table_termo_aditivo->insert($data['termo_aditivo']);
        $table_orcamentos->update(array('valor_orcamento' => $data['termo_aditivo']['valor_termino_aditivo']), 'orcamento_id = ' . $data['termo_aditivo']['orcamento_destino']);

        if ($rubrica[1] == '36')
        {
            if ($rubrica[2] != '02' && $rubrica[2] != '03' && $rubrica[2] != '07' && $rubrica[2] != '46' && $rubrica[2] != '80')
            {
                $table_orcamentos->update(array('valor_orcamento'=>$valor_imposto), 'orcamento_rel = ' . $data['termo_aditivo']['orcamento_destino']);
            }

        }

    }

    public function insertRemanejar($data)
    {
        $table_termo_aditivo = new Application_Model_DbTable_TermoAditivo;
        $table_orcamentos = new Application_Model_DbTable_Orcamento;

        $orcamento_origem = $data['termo_aditivo']['orcamento_origem'];
        $orcamento_destino = $data['termo_aditivo']['orcamento_destino'];
        $orcamentodata_origem = $table_orcamentos->find($orcamento_origem)->current();
        $orcamentodata_destino = $table_orcamentos->find($orcamento_destino)->current();

        $rubrica_id_origem = $orcamentodata_origem['rubrica_id'];
        $rubrica_id_destino = $orcamentodata_destino['rubrica_id'];


        $valor_orcamento_origem = $data['termo_aditivo']['valor_orcamento_origem'];
        $valor_orcamento_destino = $data['termo_aditivo']['valor_orcamento_destino'];
        unset($data['termo_aditivo']['valor_orcamento_origem']);
        unset($data['termo_aditivo']['valor_orcamento_destino']);


        $arrayCodigoRubrica_origem = $this->getCodigoRubrica($rubrica_id_origem);
        $arrayCodigoRubrica_destino = $this->getCodigoRubrica($rubrica_id_destino);
        $codigoRubrica_origem = $arrayCodigoRubrica_origem[0]['r.codigo_rubrica'];
        $codigoRubrica_destino = $arrayCodigoRubrica_destino[0]['r.codigo_rubrica'];
        $rubrica_origem = explode(".", $codigoRubrica_origem);
        $rubrica_destino = explode(".", $codigoRubrica_destino);

        $str = $data['termo_aditivo']['valor_termino_aditivo'];
        $var = str_replace(".", "", $str);
        $var2 = str_replace(",", ".",$var);
        $data['termo_aditivo']['valor_termino_aditivo'] = $var2;
        $data['termo_aditivo']['data_termo_aditivo'] = date('Y-m-d H:i:s', time());

        $valor_orcamento_origem_atualizado = $valor_orcamento_origem - $data['termo_aditivo']['valor_termino_aditivo'];
        $valor_orcamento_destino_atualizado = $valor_orcamento_destino + $data['termo_aditivo']['valor_termino_aditivo'];
        $valor_imposto_origem = 0.2 * $valor_orcamento_origem_atualizado;
        $valor_imposto_destino = 0.2 * $valor_orcamento_destino_atualizado;

        $table_termo_aditivo->insert($data['termo_aditivo']);


        $table_orcamentos->update(array('valor_orcamento' => $valor_orcamento_origem_atualizado),
                                        'orcamento_id = ' . $data['termo_aditivo']['orcamento_origem']);

        $table_orcamentos->update(array('valor_orcamento' => $valor_orcamento_destino_atualizado),
            'orcamento_id = ' . $data['termo_aditivo']['orcamento_destino']);


        if ($rubrica_origem[1] == '36')
        {
            if ($rubrica_origem[2] != '02' && $rubrica_origem[2] != '03' && $rubrica_origem[2] != '07' && $rubrica_origem[2] != '46' && $rubrica_origem[2] != '80')
            {
                $table_orcamentos->update(array('valor_orcamento'=>$valor_imposto_origem), 'orcamento_rel = ' . $data['termo_aditivo']['orcamento_origem']);
            }
        }

        if ($rubrica_destino[1] == '36')
        {
            if ($rubrica_destino[2] != '02' && $rubrica_destino[2] != '03' && $rubrica_destino[2] != '07' && $rubrica_destino[2] != '46' && $rubrica_destino[2] != '80')
            {
                $table_orcamentos->update(array('valor_orcamento'=>$valor_imposto_destino), 'orcamento_rel = ' . $data['termo_aditivo']['orcamento_destino']);
            }
        }
    }

    public function atualizaData($nova_data, $id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $table = "projeto";
            $where = $db->quoteInto('projeto_id = ?', $id);
            $coluna = array('data_final' => $nova_data);
            $db->update($table, $coluna, $where);
        }catch(Exception $e){
            echo $e->getMessage();
        }

    }

        public function selectAll($id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('t' => 'termo_aditivo'))
                ->where('p.projeto_id = ?', $id)
                ->joinLeft(array('u' => 'usuario'), 't.usuario_id = u.usuario_id', array('u.username'=>'u.username'))
                ->joinLeft(array('tp' => 'tipo_termo_aditivo'), 't.tipo_termo_aditivo_id = tp.tipo_termo_aditivo',
                           array('tp.nome_tipo'=>'tp.nome_tipo'))
                ->joinLeft(array('o' => 'orcamento'), 't.orcamento_origem = o.orcamento_id')
                ->joinLeft(array('oc' => 'orcamento'), 't.orcamento_destino = oc.orcamento_id')
                ->joinLeft(array('r' => 'rubrica'), 'o.rubrica_id = r.rubrica_id', array('r.descricao'=>'r.descricao',
                                                    'r.codigo_rubrica'=> 'r.codigo_rubrica'))
                ->joinLeft(array('rr'=> 'rubrica'), 'oc.rubrica_id=rr.rubrica_id', array('rr.descricao'=>'rr.descricao',
                                                    'rr.codigo_rubrica'=> 'rr.codigo_rubrica'))
                ->joinLeft(array('p' => 'projeto'), 't.projeto_id = p.projeto_id', array('p.projeto_id'=>'p.projeto_id',
                                                    'p.nome'=>'p.nome'));

            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function getOptions(){
    }

    public function banco($str)
    {
        $var = str_replace(".", "", $str);
        $var2= str_replace(",", ".",$var);

        return $var2;

    }

    public function getCodigoRubrica ($rid)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('r' => 'rubrica'), array('r.codigo_rubrica' => 'r.codigo_rubrica'))
                ->where('r.rubrica_id = ?', $rid);

            $stmt = $select->query();
            $resultado = $stmt->fetchAll();

            return $resultado;

        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
}

