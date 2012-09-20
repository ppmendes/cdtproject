<?php

class Application_Model_DbTable_Acesso extends Zend_Db_Table_Abstract
{

   	protected $_name = 'acesso';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_EstadoProjeto' => array(
            'columns'           => 'estado_projeto_id',
            'refTableClass'     => 'Application_Model_DbTable_EstadoProjeto',
            'refColumns'        => 'estado_projeto_id'
        ),
        'Application_Model_DbTable_' => array(
            'columns'           => '_id',
            'refTableClass'     => 'Application_Model_DbTable_',
            'refColumns'        => 'id'
        ),
        'Application_Model_DbTable_' => array(
            'columns'           => '_id',
            'refTableClass'     => 'Application_Model_DbTable_',
            'refColumns'        => 'id'
        ),
    );
}

