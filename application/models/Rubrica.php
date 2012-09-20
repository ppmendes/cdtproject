<?php

class Application_Model_Rubrica
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Rubrica;
        $rubrica = $table->find($id)->current();
        return $rubrica;
    }

    public function insert($rubrica)
    {

    }

    public function delete($id)
    {

    }

    public function update($rubrica)
    {

    }
}