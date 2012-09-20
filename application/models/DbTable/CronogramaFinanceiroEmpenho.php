<?php

class Application_Model_DbTable_CronogramaFinanceiroEmpenho extends Zend_Db_Table_Abstract
{

    protected $_name = 'cronograma_financeiro_empenho';
    protected $_referenceMap    = array(
        'Application_Model_DbTable_CronogramaFinanceiro' => array(
            'columns'           => 'cronograma_financeiro_id',
            'refTableClass'     => 'Application_Model_DbTable_CronogramaFinanceiro',
            'refColumns'        => 'cronograma_financeiro_id'
        ),
        'Application_Model_DbTable_Rubrica' => array(
            'columns'           => 'rubrica_id',
            'refTableClass'     => 'Application_Model_DbTable_Rubrica',
            'refColumns'        => 'rubrica_id'
        ),
    );
}