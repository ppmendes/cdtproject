<?php

class Application_Model_ModoContratacao
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_ModoContratacao;
        $modo_contratacao = $table->find($id)->current();
        return $modo_contratacao;
    }

    public function insert($modo_contratacao)
    {

    }

    public function delete($id)
    {

    }

    public function update($modo_contratacao)
    {

    }
}
