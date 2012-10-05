<?php

class Application_Model_TipoDuracao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoDuracao;
        $tipo_duracao = $table->find($id)->current();
        return $tipo_duracao;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_TipoDuracao;
            $data = $table->fetchAll();
            foreach($data as $item){
                $options[$item['tipo_duracao_id']] = $item['duracao_nome'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($tipo_duracao)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_duracao)
    {

    }
}