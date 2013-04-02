<?php

class Application_Model_PermissaoUsuario
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_PermissaoUsuario();
        $permissoes = $table->find($id)->current();
        return $permissoes;
    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_PermissaoUsuario();
        $table->insert($data);
    }

    public function delete($id_usuario)
    {
        $table = new Application_Model_DbTable_PermissaoUsuario();
        $where = $table->getAdapter()->quoteInto('usuario_id = ?',$id_usuario);
        $table->delete($where);
    }

    public function update()
    {
        //
    }
    public static function getOptions()
    {

    }

    public function getLastInsertedId()
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $result = $db->fetchOne("SELECT max(usuario_id) FROM usuario");
        return (int)$result;
    }
}