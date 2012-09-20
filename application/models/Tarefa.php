<?php

class Application_Model_Tarefa
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Tarefa;
        $tarefa = $table->find($id)->current();
        return $tarefa;
    }

    public function insert($tarefa)
    {

    }

    public function delete($id)
    {

    }

    public function update($tarefa)
    {

    }
}