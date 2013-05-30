<?php

class Application_Model_Destinatario
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_Destinatario();
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
            $table = new Application_Model_DbTable_Destinatario();
            $resultado = $table->fetchAll();

            foreach($resultado as $item){
                $options[$item['destinatario_id']] = $item['nome_destinatario'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}

