<?php

class Application_Model_TarefaUsuario
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TarefaUsuario;
        $tarefa_usuario = $table->find($id)->current();
        return $tarefa_usuario;
    }

    public function insert($tarefa_usuario)
    {

    }

    public function delete($id)
    {

    }

    public function update($tarefa_usuario)
    {

    }
}