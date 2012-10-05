<?php

class Application_Model_TipoTarefa
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoTarefa;
        $tipo_tarefa = $table->find($id)->current();
        return $tipo_tarefa;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_TipoTarefa;
            $data = $table->fetchAll();
            foreach($data as $item){
                $options[$item['tipo_tarefa_id']] = $item['nome_tipo'];
            }
            return $options;
        } catch(Exception $e){

        }

    }


    public function insert($tipo_tarefa)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_tarefa)
    {

    }
}