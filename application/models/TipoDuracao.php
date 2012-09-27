<?php

class Application_Model_TipoDuracao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoDuracao;
        $tipo_duracao = $table->find($id)->current();
        return $tipo_duracao;
    }

    public function insert($tipo_duracao)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_duracao)
    {

    }
}