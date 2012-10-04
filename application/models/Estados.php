<?php

class Application_Model_Estados
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Estados;
        $acesso = $table->find($id)->current();
        return $acesso;
    }



    public function insert($estados)
    {

    }

    public function delete($id)
    {

    }

    public function update($estados)
    {

    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Estados();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['estados_id']] = $item['estados_nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}

