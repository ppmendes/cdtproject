<?php

class Application_Model_TipoEstadoSolicitacao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoEstadoSolicitacao;
        $tipo_estado_solicitacao = $table->find($id)->current();
        return $tipo_estado_solicitacao;
    }

    public function insert($tipo_estado_solicitacao)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_estado_solicitacao)
    {

    }
}