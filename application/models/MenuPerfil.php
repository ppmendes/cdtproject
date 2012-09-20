<?php

class Application_Model_MenuPerfil
{
    /**
     * Busca a Solução e seus respectivos relacionamentos pelo ID da menu
     * Retorna um array com a menu
     */
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_MenuPerfil;
        $menu_perfil = $table->find($id)->current();
        return $menu_perfil;
    }

    public function insert($menu_perfil)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de menu
    public function update($menu_perfil)
    {

    }
}
