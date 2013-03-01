<?php
class Application_Model_UsuariosAssociadosTarefa
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_UsuariosAssociadosTarefa();
        $usuario_associado_tarefa = $table->find($id)->current();
        return $usuario_associado_tarefa;
    }
    public function insert($data)
    {
        $table = new Application_Model_DbTable_UsuariosAssociadosTarefa();
        $table->insert($data);
    }

    public function delete($id)
    {

    }

    public function update($id)
    {

    }
}