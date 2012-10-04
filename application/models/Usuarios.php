<?php

class Application_Model_Usuario
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Usuario();
        $usuario = $table->find($id)->current();
        return $usuario;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Usuario;
            $usuario = $table->fetchAll();
            foreach($usuario as $item){
                $options[$item['usuario_id']] = $item['nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($data)
    {
        $table = new Application_Model_DbTable_Usuario;
        $table->insert($data['usuarios']);
    }

    public function delete($id)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $table = "usuarios";
        $deletado = true;
        $where = $db->quoteInto('usuario_id = ?', $id);
        $data = array('deletado' => $deletado);
        $db->update($table, $data, $where);
    }

    public function update($data,$id)
    {
        $table = new Application_Model_DbTable_Usuario;
        $where = $table->getAdapter()->quoteInto('usuario_id = ?',$id);

        $table->update($data['usuarios'], $where);
    }

    public function selectAll()
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        // ainda resta apresentar historico de login do usuarios
        $select = $db->select()
            ->from(array('u'=>'usuarios'))
            ->where('u.deletado=?',false)
            ->joinLeft(array('i'=>'instituicao'),'u.instituicao_id = i.instituicao_id',array('u.usuario_id'=>'u.usuario_id','u.sobrenome'=>'u.sobrenome','u.nome'=>'u.nome','i.nome'=>'i.nome'));

        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result;
    }
}

