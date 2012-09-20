<?php

class Application_Model_CompanhiasSugeridas
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_CompanhiasSugeridas();
        $companhias_sugeridas = $table->find($id)->current();
        return $companhias_sugeridas;
    }

    public function insert($companhias_sugeridas)
    {

    }

    public function delete($id)
    {

    }

    public function update($companhias_sugeridas)
    {

    }
}

