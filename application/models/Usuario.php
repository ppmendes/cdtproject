<?php

class Application_Model_Usuario
{
    /**
     * Busca a Solução e seus respectivos relacionamentos pelo ID da solução
     * Retorna um array com a Solução
     */
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Usuario();
        $usuario = $table->find($id)->current();
        return $usuario;
    }

    public function insert($usuario)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de soluções
    public function update($usuario)
    {

    }
}

