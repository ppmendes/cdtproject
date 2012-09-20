<?php

class Application_Model_EstadoProjeto
{
    /**
     * Busca a Solução e seus respectivos relacionamentos pelo ID da solução
     * Retorna um array com a Solução
     */
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_EstadoProjeto;
        $estado_projeto = $table->find($id)->current();
        return $estado_projeto;
    }

    public function insert($estado_projeto)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de soluções
    public function update($estado_projeto)
    {

    }
}
