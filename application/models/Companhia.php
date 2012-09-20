<?php

class Application_Model_Companhia
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Companhia;
		$companhia = $table->find($id)->current();
		return $companhia;
	}

    public function insert($companhia)
    {

    }

    public function delete($id)
    {

    }

    public function update($companhia)
    {

    }
}

