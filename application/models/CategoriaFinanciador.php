<?php

class Application_Model_CategoriaFinanciador
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_CategoriaFinanciador;
        $categoria_financiador = $table->find($id)->current();
        return $categoria_financiador;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_CategoriaFinanciador();
            $categoria_financiador = $table->fetchAll();
            foreach($categoria_financiador as $item){
                $options[$item['categoria_financiador_id']] = $item['categoria'].' - '.$item['administracao_pessoa'].' - '.$item['orgao_pessoa_juridica'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($categoria_financiador)
    {

    }

    public function delete($id)
    {

    }

    public function update($categoria_financiador)
    {

    }
}
