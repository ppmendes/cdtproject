<?php

class Application_Model_Projeto_Tipo
{
    /**
     * Busca a Solução e seus respectivos relacionamentos pelo ID da solução
     * Retorna um array com a Solução
     */
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Projeto_Tipo;
        $projeto_tipo = $table->find($id)->current();
        return $projeto_tipo;
    }

    public function insert($solucoes)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de soluções
    public function update($solucoes)
    {

    }
}
