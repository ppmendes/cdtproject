<?php

class Application_Model_BensServicosDetalhe
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_BensServicosDetalhe;
		$bensServicosDetalhe = $table->find($id)->current();
		return $bensServicosDetalhe;
	}

    public function insert($bensServicosDetalhe)
    {

    }

    public function delete($id)
    {

    }

    public function update($bensServicosDetalhe)
    {

    }
}

