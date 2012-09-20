<?php

class Application_Model_ArquivoUsuarioAcesso
{
	public function find($id){
		//DB TABLE
		$table = new Application_Model_DbTable_ArquivoUsuarioAcesso;
		$arquivoUsuarioAcesso = $table->find($id)->current();
		return $arquivoUsuarioAcesso;
	}

    public function insert($arquivoUsuarioAcesso)
    {

    }

    public function delete($id)
    {

    }

    public function update($arquivoUsuarioAcesso)
    {

    }
}

