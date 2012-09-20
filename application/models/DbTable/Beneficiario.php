<?php

class Application_Model_DbTable_Beneficiario extends Zend_Db_Table_Abstract
{

   	protected $_name = 'beneficiario';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Banco' => array(
            'columns'           => 'banco_id',
            'refTableClass'     => 'Application_Model_DbTable_Banco',
            'refColumns'        => 'banco_id'
        ),
    );
}

