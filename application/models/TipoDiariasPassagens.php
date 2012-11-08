<?php

class Application_Model_TipoDiariasPassagens
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoDiariasPassagens;
        $tipo_diarias_passagens = $table->find($id)->current();
        return $tipo_diarias_passagens;
    }
    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_TipoDiariasPassagens();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['tipo_diarias_passagens_id']] = $item['nome_tipo'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
    public function insert($tipo_diarias_passagens)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_diarias_passagens)
    {

    }
}