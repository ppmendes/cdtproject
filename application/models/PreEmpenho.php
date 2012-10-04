<?php

class Application_Model_PreEmpenho
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_PreEmpenho;
        $pre_empenho = $table->find($id)->current();
        return $pre_empenho;
    }

    public function insert($pre_empenho)
    {

    }

    public function delete($id)
    {

    }

    public function update($pre_empenho)
    {

    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_PreEmpenho();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['pre_empenho_id']] = $item['pre_empenho_historico'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}