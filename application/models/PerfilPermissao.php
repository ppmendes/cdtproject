<?php

class Application_Model_PerfilPermissao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_PerfilPermissao();
        $perfil_usuario_permissoes = $table->find($id)->current();
        return $perfil_usuario_permissoes;
    }

    public function insert($data)
    {

    }

    public function delete($id)
    {

    }

    public function update()
    {

    }
    public static function getOptions()
    {

    }
}