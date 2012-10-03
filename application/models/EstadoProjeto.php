<?php

class Application_Model_EstadoProjeto
{
    /**
     * Busca a Solução e seus respectivos relacionamentos pelo ID da solução
     * Retorna um array com a Solução
     */
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_EstadoProjeto;
        $estado_projeto = $table->find($id)->current();
        return $estado_projeto;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_EstadoProjeto;
            $estadoProjeto = $table->fetchAll();
            foreach($estadoProjeto as $item){
                $options[$item['estado_projeto_id']] = $item['nome_estado'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($estado_projeto)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de soluções
    public function update($estado_projeto)
    {

    }
}
