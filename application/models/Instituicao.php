<?php

class Application_Model_Instituicao
{
   public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Instituicao;
        $instituicao = $table->find($id)->current();
        return $instituicao;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Instituicao;
        $table->insert($data['instituicao']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "instituicao";
        $deletado = true;
        $where = $db->quoteInto('instituicao_id = ?', $id);
        $data = array('deletado' => $deletado);
        $db->update($table, $data, $where);

    }

    //recebe o id e a data a ser atualizada
    public function update($data,$id)
    {
        $table = new Application_Model_DbTable_Instituicao;
        $where = $table->getAdapter()->quoteInto('instituicao_id = ?',$id);

        $table->update($data['instituicao'], $where);
    }

    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from('vw_instituicao_projeto_ativo_arquivado',array('instituicao_id','nome','ativo','arquivado','tipo','responsavel','deletado'))
            ->where('deletado = ?', false);

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }
/*
    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from(array('i' => 'instituicao'))
            ->joinInner(array('pi' => 'projeto_institucao'), 'i.instituicao_id = pi.instituicao_id');

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }*/
}
