<?php

class Application_Model_Acesso
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Acesso;
		$acesso = $table->find($id)->current();
		return $acesso;
	}

    public function insert($acesso)
    {

    }

    public function delete($id)
    {

    }

    public function update($acesso)
    {

    }
}

