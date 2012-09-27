<?php

class Application_Model_Escolaridade
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Escolaridade;
		$escolaridade = $table->find($id)->current();
		return $escolaridade;
	}

    public function insert($escolaridade)
    {

    }

    public function delete($id)
    {

    }

    public function update($escolaridade)
    {

    }
}

