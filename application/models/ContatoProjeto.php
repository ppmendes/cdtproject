<?php

class Application_Model_ContatoProjeto
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_ContatoProjeto();
        $contato_projeto = $table->find($id)->current();
        return $contato_projeto;
    }

    public function insert($contato_projeto)
    {

    }

    public function delete($id)
    {

    }

    public function update($contato_projeto)
    {

    }
}

