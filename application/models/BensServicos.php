<?php

class Application_Model_BensServicos
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_BensServicos;
		$bensServicos = $table->find($id)->current();
		return $bensServicos;
	}

    public function insert($bensServicos)
    {

    }

    public function delete($id)
    {

    }

    public function update($bensServicos)
    {

    }
}

