<?php

class Application_Model_Instituicao
{
	/**
	* Busca a Solução e seus respectivos relacionamentos pelo ID da solução
	* Retorna um array com a Solução
	*/
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_Instituicao;
        $instituicao = $table->find($id)->current();
        return $instituicao;
    }

    public function insert($instituicao)
    {

    }

    public function delete($id)
    {

    }

    //recebe o id dentro de soluções
    public function update($instituicao)
    {

    }
}
