<?php

class Application_Model_ProjetoInstituicao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_ProjetoInstituicao;
        $projeto_instituicao = $table->find($id)->current();
        return $projeto_instituicao;
    }

    public function insert($projeto_instituicao)
    {

    }

    public function delete($id)
    {

    }

    public function update($projeto_instituicao)
    {

    }
}