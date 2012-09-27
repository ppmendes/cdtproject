<?php

class Application_Model_AreaConhecimento
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_AreaConhecimento;
		$areaConhecimento = $table->find($id)->current();
		return $areaConhecimento;
	}

    public function insert($areaConhecimento)
    {

    }

    public function delete($id)
    {

    }

    public function update($areaConhecimento)
    {

    }
}

