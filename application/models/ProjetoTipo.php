<?php

class Application_Model_ProjetoTipo
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_ProjetoTipo;
        $projeto_tipo = $table->find($id)->current();
        return $projeto_tipo;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_ProjetoTipo();
            $projeto_tipo = $table->fetchAll();
            foreach($projeto_tipo as $item){
                $options[$item['projeto_tipo_id']] = $item['nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($projeto_tipo)
    {

    }

    public function delete($id)
    {

    }

    public function update($projeto_tipo)
    {

    }
}
