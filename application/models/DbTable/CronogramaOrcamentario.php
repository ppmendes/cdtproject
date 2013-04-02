<?php

class Application_Model_DbTable_CronogramaOrcamentario extends Zend_Db_Table_Abstract
{

    protected $_name = 'cronograma_orcamentario';
    protected $_referenceMap    = array(
        'Application_Model_DbTable_Projeto' => array(
            'columns'           => 'projeto_id',
            'refTableClass'     => 'Application_Model_DbTable_Projeto',
            'refColumns'        => 'projeto_id'
        ),
    );
}