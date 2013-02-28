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
}