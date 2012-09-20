<?php

class Application_Model_DbTable_CronogramaAtividades extends Zend_Db_Table_Abstract
{

    protected $_name = 'cronograma_atividades';
    protected $_referenceMap    = array(
        'Application_Model_DbTable_Solicitacao' => array(
            'columns'           => 'solicitacao_id',
            'refTableClass'     => 'Application_Model_DbTable_Solicitacao',
            'refColumns'        => 'solicitacao_id'
        ),
    );
}