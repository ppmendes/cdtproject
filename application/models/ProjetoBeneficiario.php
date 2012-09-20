<?php

class Application_Model_ProjetoBeneficiario
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_ProjetoBeneficiario;
        $projeto_beneficiario = $table->find($id)->current();
        return $projeto_beneficiario;
    }

    public function insert($projeto_beneficiario)
    {

    }

    public function delete($id)
    {

    }

    public function update($projeto_beneficiario)
    {

    }
}