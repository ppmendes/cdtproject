<?php

class Application_Model_EstadoTarefa
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_EstadoTarefa;
        $estadoTarefa = $table->find($id)->current();
        return $estadoTarefa;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_EstadoTarefa;
            $data = $table->fetchAll();
            foreach($data as $item){
                $options[$item['estado_tarefa_id']] = $item['nome_estado'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($estadoTarefa)
    {

    }

    public function delete($id)
    {

    }

    public function update($estadoTarefa)
    {

    }
}

