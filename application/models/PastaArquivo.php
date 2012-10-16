<?php

class Application_Model_PastaArquivo
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_PastaArquivo;
        $pasta_arquivo = $table->find($id)->current();
        return $pasta_arquivo;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_PastaArquivo();
        $table->insert($data['pasta_arquivo']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "pasta_arquivo";
        $deletado = true;
        $where = $db->quoteInto('pasta_arquivo_id = ?', $id);
        $data = array('deletado' => $deletado);

        $db->update($table, $data, $where);

    }

    public function update($data, $id)
    {

        $table = new Application_Model_DbTable_Projeto;
        $where = $table->getAdapter()->quoteInto('pasta_arquivo_id = ?',$id);

        $table->update($data['pasta_arquivo'],$where);
    }

    public function selectAll()
    {
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $select = $db->select()
                ->from(array('pa' => 'pasta_arquivo'), array('pa.pasta_arquivo_id'=>'pa.pasta_arquivo_id', 'pa.nome_pasta'=>'pa.nome_pasta'))
                //->where('a.deletado = ?', false)
                ->joinLeft(array('p' => 'projeto'), 'pa.projeto_id = p.projeto_id', array('p.nome'=>'p.nome'))
                ->joinLeft(array('t' => 'tarefa'), 'pa.tarefa_id = t.tarefa_id', array('t.nome'=>'t.nome'));


            $stmt = $select->query();

            $result = $stmt->fetchAll();

            return $result;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_PastaArquivo();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['pasta_arquivo_id']] = $item['nome_pasta'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}
