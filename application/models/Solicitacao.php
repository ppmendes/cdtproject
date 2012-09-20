<?php

class Application_Model_Solicitacao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Solicitacao;
        $solicitacao = $table->find($id)->current();
        return $solicitacao;
    }

    public function insert($solicitacao)
    {

    }

    public function delete($id)
    {

    }

    public function update($solicitacao)
    {

    }
}