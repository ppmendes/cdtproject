<?php

class Application_Model_ViagemDetalhe
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_ViagemDetalhe;
        $viagem_detalhe = $table->find($id)->current();
        return $viagem_detalhe;
    }

    public function insert($viagem_detalhe)
    {

    }

    public function delete($id)
    {

    }

    public function update($viagem_detalhe)
    {

    }
}