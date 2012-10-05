<?php

class Application_Model_Orcamento
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Orcamento;
        $orcamento = $table->find($id)->current();
        return $orcamento;
    }

    public function insert($orcamento)
    {

    }

    public function delete($id)
    {

    }

    public function update($orcamento)
    {

    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Orcamento();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['orcamento_id']] = $item['descricao_orcamento'];
            }
            return $options;
        } catch(Exception $e){

        }

    }
}
