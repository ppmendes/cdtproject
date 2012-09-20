<?php

class Application_Model_Orcamento
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Orcamento;
        $orcamento = $table->find($id)->current();
        return $orcamento;
    }

    public function insert($orcamento)
    {

    }

    public function delete($id)
    {

    }

    public function update($orcamento)
    {

    }
}
