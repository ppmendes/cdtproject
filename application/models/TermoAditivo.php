<?php

class Application_Model_TermoAditivo
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_TermoAditivo();
		$termo_aditivo = $table->find($id)->current();
		return $termo_aditivo;
	}

    public function insert($data)
    {
    }

    public function delete($id)
    {
    }

    public function update($data, $id)
    {

    }

    public function selectAll()
    {
    }

    public static function getOptions(){
    }
}

