<?php

class Application_Model_PastaArquivo
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_PastaArquivo;
        $pasta_arquivo = $table->find($id)->current();
        return $pasta_arquivo;
    }

    public function insert($pasta_arquivo)
    {

    }

    public function delete($id)
    {

    }

    public function update($pasta_arquivo)
    {

    }
    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_PastaArquivo();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['pasta_arquivo_id']] = $item['nome_pasta'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}
