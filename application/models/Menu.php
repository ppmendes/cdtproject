<?php

class Application_Model_Menu
{
    /**
     * Busca a Solução e seus respectivos relacionamentos pelo ID da menu
     * Retorna um array com a menu
     */
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Menu;
        $menu = $table->find($id)->current();
        return $menu;
    }

    public function insert($menu)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de menu
    public function update($menu)
    {

    }
}
