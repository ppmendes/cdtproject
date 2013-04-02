<?php

class Application_Model_Perfil
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Perfil;
        $perfil_usuario = $table->find($id)->current();
        return $perfil_usuario;
    }

    public function insert($perfil_usuario)
    {

    }

    public function delete($id)
    {

    }

    public function update($perfil_usuario)
    {

    }
    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Perfil();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['perfil_id']] = $item['perfil_nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}