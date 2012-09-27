<?php

class Application_Model_DbTable_Companhia extends Zend_Db_Table_Abstract
{

   	protected $_name = 'companhia';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Usuario' => array(
            'columns'           => 'representante_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Application_Model_DbTable_Pais' => array(
            'columns'           => 'pais_id',
            'refTableClass'     => 'Application_Model_DbTable_Pais',
            'refColumns'        => 'pais_id'
        ),
        'Application_Model_DbTable_Estados' => array(
            'columns'           => 'estados_id',
            'refTableClass'     => 'Application_Model_DbTable_Estados',
            'refColumns'        => 'estados_id'
        ),
        'Application_Model_DbTable_Cidade' => array(
            'columns'           => 'cidade_id',
            'refTableClass'     => 'Application_Model_DbTable_Cidade',
            'refColumns'        => 'cidade_id'
        ),
    );
}

