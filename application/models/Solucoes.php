<?php

class Application_Model_Solucoes
{
	/**
	* Busca a Solução e seus respectivos relacionamentos pelo ID da solução
	* Retorna um array com a Solução
	*/
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Solucoes;
		$solucao = $table->find($id)->current();
		return $solucao;
	}

    public function insert($solucoes)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de soluções
    public function update($solucoes)
    {

    }
}

