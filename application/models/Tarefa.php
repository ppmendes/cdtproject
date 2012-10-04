<?php

class Application_Model_Tarefa
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Tarefa;
        $tarefa = $table->find($id)->current();
        return $tarefa;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Tarefa();
        $table->insert($data['tarefa']);
    }

    public function delete($id)
    {

    }

    public function update($tarefa)
    {

    }
}