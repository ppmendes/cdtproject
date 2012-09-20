<?php

class Application_Model_Perfil
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Perfil;
        $perfil = $table->find($id)->current();
        return $perfil;
    }

    public function insert($perfil)
    {

    }

    public function delete($id)
    {

    }

    public function update($perfil)
    {

    }
}