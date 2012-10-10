<?php

class Application_Model_Destino
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_Destino();
        $destino = $table->find($id)->current();
        return $destino;
    }

    public function insert($destino)
    {

    }

    public function delete($id)
    {

    }

    public function update($destino)
    {

    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Destino();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['destino_id']] = $item['nome_destino'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}

