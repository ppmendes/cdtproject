<?php

class Application_Model_CronogramaFinanceiroEmpenho
{

    public function find($id){
        //DB TABLE
        $table = new Application_Model_CronogramaFinanceiroEmpenho();
        $cronograma_financeiro_empenho = $table->find($id)->current();
        return $cronograma_financeiro_empenho;
    }

    public function insert($cronograma_financeiro_empenho)
    {

    }

    public function delete($id)
    {

    }

    public function update($cronograma_financeiro_empenho)
    {

    }
}

