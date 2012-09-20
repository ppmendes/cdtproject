<?php

class Application_Model_EstadoSolicitacao
{
    /**
     * Busca a Solução e seus respectivos relacionamentos pelo ID da solução
     * Retorna um array com a Solução
     */
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_EstadoSolicitacao;
        $estado_solicitacao = $table->find($id)->current();
        return $estado_solicitacao;
    }

    public function insert($estado_solicitacao)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de soluções
    public function update($estado_solicitacao)
    {

    }
}
