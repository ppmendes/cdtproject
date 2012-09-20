<?php

class Application_Model_Usuario
{

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

    public function update($usuario)
    {

    }
}

