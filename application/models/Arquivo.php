<?php

class Application_Model_Arquivo
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_Arquivo;
		$arquivo = $table->find($id)->current();
		return $arquivo;
	}

    public function insert($arquivo)
    {

    }

    public function delete($id)
    {

    }

    public function update($arquivo)
    {

    }
}

