<?php

class Application_Model_ProjetoUsuario
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_ProjetoUsuario;
        $projeto_usuario = $table->find($id)->current();
        return $projeto_usuario;
    }

    public function insert($projeto_usuario)
    {

    }

    public function delete($id)
    {

    }

    public function update($projeto_usuario)
    {

    }
}