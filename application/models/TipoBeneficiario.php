<?php

class Application_Model_TipoBeneficiario
{
    public function find($id){
        //DB TABLE
        $table = new Application_Model_DbTable_TipoBeneficiario;
        $tipo_beneficiario = $table->find($id)->current();
        return $tipo_beneficiario;
    }

    public function insert($tipo_beneficiario)
    {

    }

    public function delete($id)
    {

    }

    public function update($tipo_beneficiario)
    {

    }
}