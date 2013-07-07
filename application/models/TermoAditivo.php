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
        $str = $data['termo_aditivo']['valor_termino_aditivo'];
        $var = str_replace(".", "", $str);
        $var2 = str_replace(",", ".",$var);
        $data['termo_aditivo']['valor_termino_aditivo'] = $var2;
        $data['termo_aditivo']['data_termo_aditivo'] = date('Y-m-d H:i:s', time());


        $table_termo_aditivo = new Application_Model_DbTable_TermoAditivo;
        $table_orcamentos = new Application_Model_DbTable_Orcamento;

        $table_termo_aditivo->insert($data['termo_aditivo']);
        $table_orcamentos->update(array('valor_orcamento' => $data['termo_aditivo']['valor_termino_aditivo']), 'orcamento_id = ' . $data['termo_aditivo']['orcamento_destino']);
    }

    public function insertRemanejar($data)
    {
        $valor_orcamento_origem = $data['termo_aditivo']['valor_orcamento_origem'];
        $valor_orcamento_destino = $data['termo_aditivo']['valor_orcamento_destino'];
        unset($data['termo_aditivo']['valor_orcamento_origem']);
        unset($data['termo_aditivo']['valor_orcamento_destino']);


        $str = $data['termo_aditivo']['valor_termino_aditivo'];
        $var = str_replace(".", "", $str);
        $var2 = str_replace(",", ".",$var);
        $data['termo_aditivo']['valor_termino_aditivo'] = $var2;
        $data['termo_aditivo']['data_termo_aditivo'] = date('Y-m-d H:i:s', time());


        $table_termo_aditivo = new Application_Model_DbTable_TermoAditivo;
        $table_orcamentos = new Application_Model_DbTable_Orcamento;

        $table_termo_aditivo->insert($data['termo_aditivo']);


        $table_orcamentos->update(array('valor_orcamento' => $valor_orcamento_origem - $data['termo_aditivo']['valor_termino_aditivo']),
                                        'orcamento_id = ' . $data['termo_aditivo']['orcamento_origem']);

        $table_orcamentos->update(array('valor_orcamento' => $valor_orcamento_destino + $data['termo_aditivo']['valor_termino_aditivo']),
            'orcamento_id = ' . $data['termo_aditivo']['orcamento_destino']);
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
}

