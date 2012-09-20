<?php

class Application_Model_TarefaSolicitacao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TarefaSolicitacao;
        $tarefa_solicitacao = $table->find($id)->current();
        return $tarefa_solicitacao;
    }

    public function insert($tarefa_solicitacao)
    {

    }

    public function delete($id)
    {

    }

    public function update($tarefa_solicitacao)
    {

    }
}