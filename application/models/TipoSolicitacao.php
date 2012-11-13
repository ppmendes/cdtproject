<?php

class Application_Model_TipoSolicitacao
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoSolicitacao;
        $tipo_solicitacao = $table->find($id)->current();
        return $tipo_solicitacao;
    }
    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_TipoSolicitacao();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                $options[$item['tipo_solicitacao_id']] = $item['nome_tipo'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public static function getOptionsAquisicao(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_TipoSolicitacao();
            $resultado = $table->fetchAll();
            foreach($resultado as $item){
                if ($item['tipo_solicitacao_id'] == 4 || $item['tipo_solicitacao_id'] == 5 || $item['tipo_solicitacao_id'] == 6)
                $options[$item['tipo_solicitacao_id']] = $item['nome_tipo'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($tipo_solicitacao)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_solicitacao)
    {

    }
}