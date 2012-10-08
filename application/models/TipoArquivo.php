<?php

class Application_Model_TipoArquivo
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoArquivo;
        $tipo_arquivo = $table->find($id)->current();
        return $tipo_arquivo;
    }

    public function insert($tipo_arquivo)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_arquivo)
    {

    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_TipoArquivo();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['tipo_arquivo_id']] = $item['nome_tipo'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}