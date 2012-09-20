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
}
