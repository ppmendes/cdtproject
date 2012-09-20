<?php

class Application_Model_Desembolso
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_Desembolso();
        $desembolso = $table->find($id)->current();
        return $desembolso;
    }

    public function insert($desembolso)
    {

    }

    public function delete($id)
    {

    }

    public function update($desembolso)
    {

    }
}

