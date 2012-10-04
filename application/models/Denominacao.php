<?php

class Application_Model_Denominacao
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_Denominacao;
        $denominacao = $table->find($id)->current();
        return $denominacao;
    }

    public function insert($denominacao)
    {

    }

    public function delete($id)
    {

    }

    public function update($denominacao)
    {

    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Denominacao();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['denominacao_id']] = $item['denominacao_nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}

