<?php

class Application_Model_DbTable_Desembolso extends Zend_Db_Table_Abstract
{

    protected $_name = 'desembolso';
    protected $_referenceMap    = array(
        'Application_Model_DbTable_Empenho' => array(
            'columns'           => 'empenho_id',
            'refTableClass'     => 'Application_Model_DbTable_Empenho',
            'refColumns'        => 'empenho_id'
        ),
    );
}