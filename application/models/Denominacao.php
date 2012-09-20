<?php

class Application_Model_Denominacao
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_Denominacao;
        $denominacao = $table->find($id)->current();
        return $denominacao;
    }

    public function insert($denominacao)
    {

    }

    public function delete($id)
    {

    }

    public function update($denominacao)
    {

    }
}

