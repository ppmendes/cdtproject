<?php

class Application_Model_Empenho
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_Empenho();
        $empenho = $table->find($id)->current();
        return $empenho;
    }

    public function insert($empenho)
    {

    }

    public function delete($id)
    {

    }

    public function update($empenho)
    {

    }
}

