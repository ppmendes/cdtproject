<?php

class Application_Model_DbTable_EmpenhoTarefa extends Zend_Db_Table_Abstract
{

    protected $_name = 'empenho_tarefa';
    protected $_referenceMap    = array(
        'Application_Model_DbTable_Tarefa' => array(
            'columns'           => 'tarefa_id',
            'refTableClass'     => 'Application_Model_DbTable_Tarefa',
            'refColumns'        => 'tarefa_id'
        ),
        'Application_Model_DbTable_Empenho' => array(
            'columns'           => 'empenho_id',
            'refTableClass'     => 'Application_Model_DbTable_Empenho',
            'refColumns'        => 'empenho_id'
        ),
    );
}