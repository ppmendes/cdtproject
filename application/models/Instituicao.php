<?php

class Application_Model_Instituicao
{
   public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Instituicao;
        $instituicao = $table->find($id)->current();
        return $instituicao;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Instituicao;
            $instituicao = $table->fetchAll();
            foreach($instituicao as $item){
                $options[$item['instituicao_id']] = $item['nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($data)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "instituicao";
        $db->insert($table, $data);
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

    //recebe o id dentro de soluções
    public function update($data,$id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "instituicao";
        $where = $db->quoteInto('instituicao_id = ?', $id);

        $db->update($table, $data, $where);
        print_r($data);
    }

    /*public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from('vw_instituicao_projeto_ativo_arquivado',array('instituicao_id','nome','ativo','arquivado','tipo','responsavel'))
            ->where('deletado = ?', false);
        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }*/

    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();

        $select = $db->select()
            ->from(array('i' => 'instituicao'))
            ->joinInner(array('pi' => 'projeto_institucao'), 'i.instituicao_id = pi.instituicao_id');

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        return $result;
    }
}
