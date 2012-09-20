<?php

class Application_Model_DbTable_Acesso extends Zend_Db_Table_Abstract
{

   	protected $_name = 'acesso';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Menu' => array(
            'columns'           => 'menu_id',
            'refTableClass'     => 'Application_Model_DbTable_Menu',
            'refColumns'        => 'menu_id'
        ),
        'Application_Model_DbTable_Usuario' => array(
            'columns'           => 'usuario_id',
            'refTableClass'     => 'Application_Model_DbTable_Usuario',
            'refColumns'        => 'usuario_id'
        ),
        'Application_Model_DbTable_Acoes' => array(
            'columns'           => 'acoes_id',
            'refTableClass'     => 'Application_Model_DbTable_Acoes',
            'refColumns'        => 'acoes_id'
        ),
    );
}

