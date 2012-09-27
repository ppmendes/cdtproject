<?php

class Application_Model_DbTable_Estados extends Zend_Db_Table_Abstract
{

    protected $_name = 'estados';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Pais' => array(
            'columns'           => 'pais_id',
            'refTableClass'     => 'Application_Model_DbTable_Pais',
            'refColumns'        => 'pais_id'
        ),
    );
}

