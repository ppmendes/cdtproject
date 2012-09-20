<?php

class Application_Model_DbTable_Companhia extends Zend_Db_Table_Abstract
{

   	protected $_name = 'companhia';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_EstadoProjeto' => array(
            'columns'           => 'estado_projeto_id',
            'refTableClass'     => 'Application_Model_DbTable_EstadoProjeto',
            'refColumns'        => 'estado_projeto_id'
        ),
    );
}

