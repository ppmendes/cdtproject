<?php

class Application_Model_DbTable_Orcamento extends Zend_Db_Table_Abstract
{

    protected $_name = 'orcamento';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Rubrica' => array(
            'columns'           => 'rubrica_id',
            'refTableClass'     => 'Application_Model_DbTable_Rubrica',
            'refColumns'        => 'rubrica_id'
        ),

        'Application_Model_DbTable_Destino' => array(
            'columns'           => 'destino_id',
            'refTableClass'     => 'Application_Model_DbTable_Destino',
            'refColumns'        => 'destino_id'
        ),

        'Application_Model_DbTable_Projeto' => array(
            'columns'           => 'projeto_id',
            'refTableClass'     => 'Application_Model_DbTable_Projeto',
            'refColumns'        => 'projeto_id'
        ),
    );

}