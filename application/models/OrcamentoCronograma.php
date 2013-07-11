<?php

class Application_Model_OrcamentoCronograma
{


    public function insert($data)
    {
        $decimalfilter = new Zend_Filter_DecimalFilter();
        $table = new Application_Model_DbTable_OrcamentoCronograma();


        $data['orcamento_cronograma']['valor'] = $decimalfilter->filter($data['orcamento_cronograma']['valor']);

       
        $table->insert($data['orcamento_cronograma']);
    }
}
