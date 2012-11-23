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
            ->from(array('d' => 'desembolso'))
            ->where('desembolso_id = ?', 10)
            ->orWhere('desembolso_id = ?', 11)
            ->orWhere('desembolso_id = ?', 12)
            ->orWhere('desembolso_id = ?', 13)
            ->orWhere('desembolso_id = ?', 14)
            ->orWhere('desembolso_id = ?', 15)
            ->orWhere('desembolso_id = ?', 16)
            ->orWhere('desembolso_id = ?', 17)
            ->orWhere('desembolso_id = ?', 18)
            ->joinLeft(array('e' => 'empenho'), 'd.empenho_id = e.empenho_id',array('e.descricao_historico'=>'e.descricao_historico'));
        $stmt = $select->query();

        $result = $stmt->fetchAll(Zend_Db::FETCH_NUM);

        return $result;
    }
}

