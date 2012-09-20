<?php

class Application_Model_DbTable_Instituicao extends Zend_Db_Table_Abstract
{

   	protected $_name = 'instituicao';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Denominacao' => array(
            'columns'           => 'denominacao_id',
            'refTableClass'     => 'Application_Model_DbTable_Denominacao',
            'refColumns'        => 'denominacao_id'
        ),
    );

}

