<?php

class Application_Model_Servicos
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Servicos;
        $servicos = $table->find($id)->current();
        return $servicos;
    }

    public function insert($servicos)
    {

    }

    public function delete($id)
    {

    }

    public function update($servicos)
    {

    }
}