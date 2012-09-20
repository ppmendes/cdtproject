<?php

class Application_Model_Desembolco
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_Desembolco();
        $desembolco = $table->find($id)->current();
        return $desembolco;
    }

    public function insert($desembolco)
    {

    }

    public function delete($id)
    {

    }

    public function update($desembolco)
    {

    }
}

