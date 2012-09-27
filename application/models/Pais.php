<?php

class Application_Model_Pais
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Pais;
        $pais = $table->find($id)->current();
        return $pais;
    }

    public function insert($pais)
    {

    }

    public function delete($id)
    {

    }

    public function update($pais)
    {

    }
}

