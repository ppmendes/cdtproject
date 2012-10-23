<?php

class Application_Model_TermoAditivo
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_TermoAditivo();
		$termoAditivo = $table->find($id)->current();
		return $termoAditivo;
	}

    public function insert($data)
    {
        $data['termo_aditivo']['data_modificacao'] = date('Y-m-d H:i:s', time());
        $table = new Application_Model_DbTable_TermoAditivo;
        $table->insert($data['termo_aditivo']);
    }

        public function selectAll($id)
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('t' => 'termo_aditivo'))
                ->where('p.projeto_id = ?', $id)
                ->joinLeft(array('u' => 'usuario'), 't.usuario_id = u.usuario_id', array('u.username'=>'u.username'))
                ->joinLeft(array('tp' => 'tipo_termo_aditivo'), 't.tipo_termo_aditivo_id = tp.tipo_termo_aditivo_id',
                           array('tp.nome_modificacao'=>'tp.nome_modificacao'))
                ->joinLeft(array('o' => 'orcamento'), 't.orcamento_id_fonte = o.orcamento_id')
                ->joinLeft(array('oc' => 'orcamento'), 't.orcamento_id_destino = oc.orcamento_id')
                ->joinLeft(array('r' => 'rubrica'), 'o.orcamento_id = r.rubrica_id', array('r.descricao'=>'r.descricao',
                                                    'r.codigo_rubrica'=> 'r.codigo_rubrica'))
                ->joinLeft(array('rr'=> 'rubrica'), 'oc.orcamento_id=rr.rubrica_id', array('rr.descricao'=>'rr.descricao',
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
}

