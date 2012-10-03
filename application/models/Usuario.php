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

    public function insert($usuario)
    {

    }

    public function delete($id)
    {

    }

    public function update($usuario)
    {

    }
}

