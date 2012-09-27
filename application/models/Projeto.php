<?php

class Application_Model_Projeto
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Projeto;
		$projeto = $table->find($id)->current();
		return $projeto;
	}

    public function insert($projeto)
    {

    }

    public function delete($id)
    {

    }

    public function update($projeto)
    {

    }

    public function fetchAll()
    {
        $table = new Application_Model_DbTable_Projeto;
        $projeto = $table->fetchAll();
        return $projeto;
    }
}

