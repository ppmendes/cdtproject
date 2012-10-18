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
        $table->insert($data['arquivos']);
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
       try{
           $db = Zend_Db_Table::getDefaultAdapter();

           $select = $db->select()
               ->from(array('a' => 'arquivo'), array('a.arquivo_id'=>'a.arquivo_id', 'a.nome_arquivo'=>'a.nome_arquivo', 'a.versao'=>'a.versao', 'a.tamanho'=>'a.tamanho', 'a.data_arquivo'=>'a.data_arquivo', 'a.descricao_arquivo'=>'a.descricao_arquivo'))
               ->where('a.deletado = ?', false)
               ->joinLeft(array('p' => 'pasta_arquivo'), 'a.pasta_arquivo_id = p.pasta_arquivo_id')
               ->joinLeft(array('t' => 'tarefa'), 'a.tarefa_id = t.tarefa_id', array('t.nome'=>'t.nome'))
               ->joinLeft(array('ta' => 'tipo_arquivo'), 'a.tipo_arquivo_id = ta.tipo_arquivo_id', array('ta.nome_tipo'=>'ta.nome_tipo'))
               ->joinLeft(array('u' => 'usuario'), 'a.dono_arquivo = u.usuario_id', array('u.nome'=>'u.nome'));

           $stmt = $select->query();
           $result = $stmt->fetchAll();
           return $result;

       }catch(Exception $e){
           echo $e->getMessage();
       }
    }

}