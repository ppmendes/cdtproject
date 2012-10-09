<?php

class Application_Model_Arquivo
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Arquivo;
        $arquivo = $table->find($id)->current();
        return $arquivo;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Arquivo;
        $table->insert($data['arquivo']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "arquivo";
        $deletado = true;
        $where = $db->quoteInto('arquivo_id = ?', $id);
        $data = array('deletado' => $deletado);
        $db->update($table, $data, $where);
    }

    public function update($data,$id)
    {
        $table = new Application_Model_DbTable_Arquivo;
        $where = $table->getAdapter()->quoteInto('arquivo_id = ?',$id);

        $table->update($data['arquivo'], $where);
    }

    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from(array('a' => 'arquivo'), array('a.arquivo_id'=>'a.arquivo_id', 'a.nome_arquivo'=>'a.nome_arquivo', 'a.arquivo_id'=>'a.arquivo_id', 'a.versao'=>'a.versao', 'a.tamanho'=>'a.tamanho', 'a.data_arquivo'=>'a.data_arquivo'))
            ->where('a.deletado = ?', false);

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }

}