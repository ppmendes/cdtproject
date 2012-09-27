<?php

class Application_Model_EstadoTarefa
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_EstadoTarefa;
        $estadoTarefa = $table->find($id)->current();
        return $estadoTarefa;
    }

    public function insert($estadoTarefa)
    {

    }

    public function delete($id)
    {

    }

    public function update($estadoTarefa)
    {

    }
}

