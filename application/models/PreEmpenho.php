<?php

class Application_Model_PreEmpenho
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_PreEmpenho;
        $pre_empenho = $table->find($id)->current();
        return $pre_empenho;
    }

    public function insert($pre_empenho)
    {

    }

    public function delete($id)
    {

    }

    public function update($pre_empenho)
    {

    }
}