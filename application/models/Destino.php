<?php

class Application_Model_Destino
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_Destino();
        $destino = $table->find($id)->current();
        return $destino;
    }

    public function insert($destino)
    {

    }

    public function delete($id)
    {

    }

    public function update($destino)
    {

    }
}

