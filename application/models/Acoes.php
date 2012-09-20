<?php

class Application_Model_Acoes
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Acoes;
		$acoes = $table->find($id)->current();
		return $acoes;
	}

    public function insert($acoes)
    {

    }

    public function delete($id)
    {

    }

    public function update($acoes)
    {

    }
}

