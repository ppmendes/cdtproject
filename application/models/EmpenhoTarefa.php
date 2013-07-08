<?php

class Application_Model_EmpenhoTarefa
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_EmpenhoTarefa();
        $empenho = $table->find($id)->current();
        return $empenho;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_EmpenhoTarefa();
        $table->insert($data);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "empenho_tarefa";
        $deletado = true;
        $where = $db->quoteInto('empenho_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);
    }

    public function update($data, $id)
    {
        $table = new Application_Model_DbTable_Empenho;
        $where = $table->getAdapter()->quoteInto('empenho_id = ?',$id);

        $table->update($data['empenhos'],$where);
    }

    public static function getOptions(){

    }

    public function selectAll($id)
    {

    }

    public function selectAllPreEmpenhos($id)
    {

    }

    public function selectAllSoma($id)
    {

    }
    
    public function getCodigoRubrica ($rid)
    {

    }
    
    public function getLastInsertedId($table){

        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchOne("SELECT max(" . $table . "_id) FROM " . $table . "");
        return (int)$result;
    }
}

