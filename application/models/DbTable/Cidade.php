<?php

class Application_Model_DbTable_Cidade extends Zend_Db_Table_Abstract
{

   	protected $_name = 'cidade';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Estados' => array(
            'columns'           => 'estados_id',
            'refTableClass'     => 'Application_Model_DbTable_Estados',
            'refColumns'        => 'estados_id'
        ),
    );
}

