<?php

class Application_Model_TipoTermoAditivo
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoTermoAditivo;
        $tipoTermoAditivo = $table->find($id)->current();
        return $tipoTermoAditivo;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_TipoTermoAditivo;
            $tipoTermoAditivo = $table->fetchAll();
            foreach($tipoTermoAditivo as $item){
                $options[$item['tipo_termo_aditivo_id']] = $item['nome_modificacao'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($tipoTermoAditivo)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipoTermoAditivo)
    {

    }
}