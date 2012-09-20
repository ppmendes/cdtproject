<?php

class Application_Model_CronogramaFinanceiro
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_CronogramaFinanceiro();
        $cronograma_financeiro = $table->find($id)->current();
        return $cronograma_financeiro;
    }

    public function insert($cronograma_financeiro)
    {

    }

    public function delete($id)
    {

    }

    public function update($cronograma_financeiro)
    {

    }
}

