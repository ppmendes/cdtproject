<?php

class Application_Model_TipoSolicitacao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoSolicitacao;
        $tipo_solicitacao = $table->find($id)->current();
        return $tipo_solicitacao;
    }

    public function insert($tipo_solicitacao)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_solicitacao)
    {

    }
}