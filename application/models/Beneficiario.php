<?php

class Application_Model_Beneficiario
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Beneficiario;
		$beneficiario = $table->find($id)->current();
		return $beneficiario;
	}

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Beneficiario;
        $table->insert($data['beneficiario']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "beneficiario";
        $deletado = true;
        $where = $db->quoteInto('beneficiario_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);

    }

    public function update($data, $id)
    {

        $table = new Application_Model_DbTable_Beneficiario;
        $where = $table->getAdapter()->quoteInto('beneficiario_id = ?',$id);

        $table->update($data['beneficiario'],$where);
    }

    public function selectAllpf()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from(array('b' => 'beneficiario'))
            ->where('b.deletado = ?', false)
            ->where('b.tipo_beneficiario_id = ?', 1)
            ->joinLeft(array('ba' => 'banco'), 'b.banco_id = ba.banco_id',array('ba.banco_id'=>'ba.banco_id','ba.nome_banco'=>'ba.nome_banco'))
            ->joinLeft(array('es' => 'escolaridade'), 'b.escolaridade_id = es.escolaridade_id',array('es.escolaridade_id'=>'es.escolaridade_id','es.nome_escolaridade'=>'es.nome_escolaridade'));

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }

    public function selectAllpj()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from(array('b' => 'beneficiario'))
            ->where('b.deletado = ?', false)
            ->where('b.tipo_beneficiario_id = ?', 2)
            ->joinLeft(array('ba' => 'banco'), 'b.banco_id = ba.banco_id',array('ba.banco_id'=>'ba.banco_id','ba.nome_banco'=>'ba.nome_banco'))
            ->joinLeft(array('es' => 'escolaridade'), 'b.escolaridade_id = es.escolaridade_id',array('es.escolaridade_id'=>'es.escolaridade_id','es.nome_escolaridade'=>'es.nome_escolaridade'));

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Beneficiario();
            $resultado = $table->fetchAll('tipo_beneficiario_id = 1 && deletado = 0');
            foreach($resultado as $item){
                $options[] = array('label' => $item['nome'], 'id' => $item['beneficiario_id']);
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public static function getOptionsPj(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Beneficiario();
            $resultado = $table->fetchAll('tipo_beneficiario_id = 2');
            foreach($resultado as $item){
                $options[] = array('label' => $item['nome'], 'id' => $item['beneficiario_id']);
            }
            return $options;
        } catch(Exception $e){

        }

    }
    
    public function getNome($id)
    {
            $db = Zend_Db_Table::getDefaultAdapter();

            $select = $db->select()
                ->from(array('b' => 'beneficiario'),
                        array('b.nome'))
                ->where('b.beneficiario_id = ?', $id);
            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;
    }

}

