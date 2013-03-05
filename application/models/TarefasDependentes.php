<?php
class Application_Model_TarefasDependentes
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TarefasDependentes();
        $tarefa_dependente = $table->find($id)->current();
        return $tarefa_dependente;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_TarefasDependentes();
        $table->insert($data);
    }

    public function delete($id)
    {

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
                $resultado = $db->fetchAll("select tarefa_id, nome from tarefa where tarefa_id in (select TD.tarefa_dependente from tarefa as T inner join tarefas_dependentes as TD on T.tarefa_id=TD.tarefa_id where T.tarefa_id=$id_tarefa_form)");
                foreach($resultado as $item){

                    $options[$item['tarefa_id']] = $item['nome'];
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