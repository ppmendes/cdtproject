<?php

class Application_Model_Pais
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Pais;
        $pais = $table->find($id)->current();
        return $pais;
    }

    public function insert($pais)
    {

    }

    public function delete($id)
    {

    }

    public function update($pais)
    {

    }
    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Pais();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['pais_id']] = $item['pais_nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}

