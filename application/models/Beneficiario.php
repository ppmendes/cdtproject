<?php

class Application_Model_Beneficiario
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Beneficiario;
		$beneficiario = $table->find($id)->current();
		return $beneficiario;
	}

    public function insert($beneficiario)
    {

    }

    public function delete($id)
    {

    }

    public function update($beneficiario)
    {

    }
}

