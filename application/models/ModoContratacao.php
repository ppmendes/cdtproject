<?php

class Application_Model_ModoContratacao
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_ModoContratacao;
        $modo_contratacao = $table->find($id)->current();
        return $modo_contratacao;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_ModoContratacao();
            $modo_contratacao = $table->fetchAll();
            foreach($modo_contratacao as $item){
                $options[$item['modo_contratacao_id']] = $item['nome_modo'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($modo_contratacao)
    {

    }

    public function delete($id)
    {

    }

    public function update($modo_contratacao)
    {

    }
}
