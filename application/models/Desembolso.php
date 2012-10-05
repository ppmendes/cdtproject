<?php

class Application_Model_Desembolso
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Desembolso;
        $desembolso = $table->find($id)->current();
        return $desembolso;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Desembolso;
        $table->insert($data['desembolso']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "desembolso";
        $extornado = true;
        $where = $db->quoteInto('desembolso_id = ?', $id);
        $data = array('extornado' => $extornado);

        $db->update($table, $data, $where);

    }

    public function update($data, $id)
    {

        $table = new Application_Model_DbTable_Desembolso;
        $where = $table->getAdapter()->quoteInto('desembolso_id = ?',$id);

        $table->update($data['desembolso'],$where);
    }

    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from(array('d' => 'desembolso')) ;
            //->where(' = ?', false);
            //->joinLeft(array('ga' => 'instituicao'), 'p.gerencia = ga.instituicao_id',array('ga.instituicao_id'=>'ga.instituicao_id','ga.nome'=>'ga.nome'));
        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }
}

