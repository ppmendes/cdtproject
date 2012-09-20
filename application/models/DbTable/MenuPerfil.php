<?php

class Application_Model_DbTable_MenuPerfil extends Zend_Db_Table_Abstract
{

    protected $_name = 'menu_perfil';

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Acoes' => array(
            'columns'           => 'acoes_id',
            'refTableClass'     => 'Application_Model_DbTable_Acoes',
            'refColumns'        => 'acoes_id'
        ),

        'Application_Model_DbTable_Perfil' => array(
            'columns'           => 'perfil_id',
            'refTableClass'     => 'Application_Model_DbTable_Perfil',
            'refColumns'        => 'perfil_id'
        ),

        'Application_Model_DbTable_Menu' => array(
            'columns'           => 'menu_id',
            'refTableClass'     => 'Application_Model_DbTable_Menu',
            'refColumns'        => 'menu_id'
        ),
    );

}