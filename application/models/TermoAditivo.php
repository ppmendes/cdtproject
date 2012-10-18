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
        $data['termo_aditivo']['data_modificacao'] = date('Y-m-d h:i:s', time());
        $table = new Application_Model_DbTable_TermoAditivo;
        $table->insert($data['termo_aditivo']);
    }

        public function selectAll()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('t' => 'termo_aditivo'))
                ->joinLeft(array('u' => 'usuario'), 't.usuario_id = u.usuario_id', array('u.username'=>'u.username'));
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

