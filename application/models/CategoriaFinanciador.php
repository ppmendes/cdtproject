<?php

class Application_Model_CategoriaFinaciador
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_CategoriaFinanciador;
        $categoria_financiador = $table->find($id)->current();
        return $categoria_financiador;
    }

    public function insert($categoria_financiador)
    {

    }

    public function delete($id)
    {

    }

    public function update($categoria_financiador)
    {

    }
}
