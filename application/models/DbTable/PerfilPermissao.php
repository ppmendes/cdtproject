<?php

class Application_Model_DbTable_PerfilPermissao extends Zend_Db_Table_Abstract
{

    protected $_name = 'perfil-permissao'; // nome tabela no banco

    protected $_referenceMap    = array(
        'Application_Model_DbTable_Perfil' => array(
            'columns'           => 'perfil_id',
            'refTableClass'     => 'Application_Model_DbTable_Perfil',
            'refColumns'        => 'perfil_id'
        ),
    );

}