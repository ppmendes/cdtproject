<?php

class Application_Model_TipoArquivo
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoArquivo;
        $tipo_arquivo = $table->find($id)->current();
        return $tipo_arquivo;
    }

    public function insert($tipo_arquivo)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_arquivo)
    {

    }
}