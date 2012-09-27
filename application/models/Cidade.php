<?php

class Application_Model_Cidade
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Cidade;
		$cidade = $table->find($id)->current();
		return $cidade;
	}

    public function insert($cidade)
    {

    }

    public function delete($id)
    {

    }

    public function update($cidade)
    {

    }
}

