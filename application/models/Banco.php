<?php

class Application_Model_Banco
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Banco;
		$banco = $table->find($id)->current();
		return $banco;
	}

    public function insert($banco)
    {

    }

    public function delete($id)
    {

    }

    public function update($banco)
    {

    }
}

