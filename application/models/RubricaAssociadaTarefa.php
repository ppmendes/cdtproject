<?php
class Application_Model_RubricaAssociadaTarefa
{

    public function find($id){
        $table = new Application_Model_DbTable_RubricaAssociadaTarefa();
        $rubrica_associado_tarefa = $table->find($id)->current();
        return $rubrica_associado_tarefa;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_RubricaAssociadaTarefa();
        $table->insert($data);
    }

    public function delete($id)
    {
        $table = new Application_Model_DbTable_RubricaAssociadaTarefa();
        $where = $table->getAdapter()->quoteInto('tarefa_id = ?',$id);
        $table->delete($where);
    }

    public function update($id)
    {

    }

    public static function getOptions($id_tarefa_form = null){

        try{
            if($id_tarefa_form != null)
            {
                $options =array();
                $db = Zend_Db_Table::getDefaultAdapter();
                $resultado = $db->fetchAll("select R.rubrica_id, R.descricao, RAT.porcentagem from rubrica as R inner join rubrica_associada_tarefa as RAT on R.rubrica_id=RAT.rubrica_id where RAT.tarefa_id=$id_tarefa_form");
                foreach($resultado as $item){
                    $options[$item['rubrica_id'].'|'.$item['porcentagem']] = $item['descricao'].' ['.$item['porcentagem'].'%]';
                }
                return $options;
            }
            else
            {
                $options = array();
                return $options;
            }
        } catch(Exception $e){

        }

    }
}