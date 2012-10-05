<?php

class Application_Model_Prioridade
{
	/**
	* Busca a Solução e seus respectivos relacionamentos pelo ID da solução
	* Retorna um array com a Solução
	*/
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Prioridade;
        $prioridade = $table->find($id)->current();
        return $prioridade;
    }

    public static function getOptions(){
        try{
            $options = array();
            $table = new Application_Model_DbTable_Prioridade;
            $prioridade = $table->fetchAll();
            foreach($prioridade as $item){
                $options[$item['prioridade_id']] = $item['nome_prioridade'];
            }
            return $options;
        } catch(Exception $e){

        }

    }

    public function insert($prioridade)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de soluções
    public function update($prioridade)
    {

    }
}//
