<?php

class Application_Model_PerfilUsuario
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_PerfilUsuario;
        $perfil_usuario = $table->find($id)->current();
        return $perfil_usuario;
    }

    public function insert($perfil_usuario)
    {

    }

    public function delete($id)
    {

    }

    public function update($perfil_usuario)
    {

    }
}