<?php

class Application_Model_Tarefa
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Tarefa;
        $tarefa = $table->find($id)->current();
        return $tarefa;
    }

    public function insert($tarefa)
    {

    }

    public function delete($id)
    {

    }

    public function update($tarefa)
    {

    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Tarefa();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['tarefa_id']] = $item['nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}