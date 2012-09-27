<?php

class Application_Model_Estados
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Estadps;
        $acesso = $table->find($id)->current();
        return $estados;
    }

    public function insert($estados)
    {

    }

    public function delete($id)
    {

    }

    public function update($estados)
    {

    }
}

